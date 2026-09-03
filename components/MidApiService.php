<?php

namespace app\components;

use Yii;
use yii\base\Component;
use yii\httpclient\Client;

class MidApiService extends Component
{
    public $baseUrl = 'https://api-gw.midvietnam.net';
    public $apiKey = 'YOUR_API_KEY';
    public $secretKeyHash = 'YOUR_SECRET_KEY_HASH';
    public $username = 'YOUR_USERNAME';
    public $password = 'YOUR_PASSWORD';

    // Đường dẫn tới file privateNTTV.pem
    public $privateKeyPath = '@app/config/keys/privateNTTV.pem';

    /**
     * Bảng ánh xạ mã lỗi theo tài liệu kỹ thuật V2.0 của MID (Trang 12)
     */
    public static function getErrorMessageByCode($code)
    {
        $errors = [
            1000 => 'Không tìm thấy API key (x-api-key chưa tồn tại trên hệ thống MID)',
            1100 => 'API key không chính xác',
            2000 => 'Request hết hạn (request chỉ tồn tại trong vòng 10 giây)',
            2100 => 'Chữ ký số (x-signature) không chính xác',
            40001 => 'Đường dẫn API không tìm thấy (Route not found)',
            40100 => 'Xác thực không thành công (Authentication failed)',
        ];

        return $errors[$code] ?? "Lỗi không xác định (mã {$code})";
    }

    /**
     * Lấy timestamp hiện tại (mili-giây)
     */
    private function getTimestamp()
    {
        return (string) round(microtime(true) * 1000);
    }

    /**
     * Tạo headers chứa chữ ký số theo tài liệu kỹ thuật MID V2.0 (Mục 3.1)
     */
    private function generateHeaders($method, $payloadData = [])
    {
        $timestamp = $this->getTimestamp();

        // Cấu trúc JSON payload: nếu method GET và không có query thì mặc định là {}
        if ($method === 'GET') {
            $dataStr = empty($payloadData) ? '{}' : json_encode($payloadData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        } else {
            $dataStr = empty($payloadData) ? '' : json_encode($payloadData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        // 1. Cấu trúc trường INPUT theo tài liệu MID: METHOD|JSON_DATA|timestamp|x-api-key
        // Ví dụ trong tài liệu: GET|JSON.stringify({ imei: "12345" })|timestamp|x-api-key
        $inputString = strtoupper($method) . '|' . $dataStr . '|' . $timestamp . '|' . $this->apiKey;

        // 2. [B1] Nếu có secretKeyHash, dùng HMAC-SHA256 để tạo hash
        // hmac = crypto.createHmac("SHA256", SECRET_KEY_HASH)
        if (!empty($this->secretKeyHash)) {
            $dataToSign = hash_hmac('sha256', $inputString, $this->secretKeyHash);
        } else {
            $dataToSign = $inputString;
        }

        // 3. [B2 & B3] Ký điện tử bằng Private Key RSA SHA256 (file .pem)
        // sign = crypto.createSign("SHA256"); sign.sign(privateKey, "base64");
        $privateKeyPath = Yii::getAlias($this->privateKeyPath);
        if (!file_exists($privateKeyPath)) {
            throw new \Exception("File Private Key không tồn tại: " . $privateKeyPath);
        }
        $privateKey = file_get_contents($privateKeyPath);
        if (!$privateKey) {
            throw new \Exception("Không thể đọc được file Private Key: " . $privateKeyPath);
        }

        $signature = '';
        $pkeyId = openssl_pkey_get_private($privateKey);
        if (!$pkeyId) {
            throw new \Exception("Private Key không hợp lệ hoặc sai định dạng PEM.");
        }

        openssl_sign($dataToSign, $signature, $pkeyId, OPENSSL_ALGO_SHA256);

        // Mã hóa base64 chữ ký
        $base64Signature = base64_encode($signature);

        return [
            'x-api-key' => $this->apiKey,
            'x-timestamp' => $timestamp,
            'x-signature' => $base64Signature,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

    /**
     * Trích xuất thông điệp lỗi chi tiết từ response API MID
     */
    private function parseApiError($response, $actionName = 'Thao tác')
    {
        $statusCode = $response->getStatusCode();
        $data = $response->data;
        $errorDetails = [];

        if (isset($data['errors']) && is_array($data['errors'])) {
            foreach ($data['errors'] as $err) {
                $code = $err['code'] ?? null;
                if ($code !== null) {
                    $errorDetails[] = "Mã {$code}: " . self::getErrorMessageByCode($code);
                }
            }
        }

        if (isset($data['code']) && !empty($data['code'])) {
            $errorDetails[] = "Mã {$data['code']}: " . self::getErrorMessageByCode($data['code']);
        }

        $msg = $data['message'] ?? $response->getContent();
        $detailStr = !empty($errorDetails) ? ' (' . implode('; ', $errorDetails) . ')' : '';

        return "{$actionName} thất bại (HTTP {$statusCode}): {$msg}{$detailStr}";
    }

    /**
     * Gọi API Login để lấy Token
     */
    public function login()
    {
        $client = new Client(['baseUrl' => $this->baseUrl]);
        $payload = [
            'username' => $this->username,
            'password' => $this->password
        ];

        // Ép sang JSON string chuẩn để body gửi đi và body dùng để ký trùng khớp 100%
        $jsonBody = json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $headers = $this->generateHeaders('POST', $payload);

        $response = $client->createRequest()
            ->setMethod('POST')
            ->setUrl('/api/v2/users/login')
            ->addHeaders($headers)
            ->setContent($jsonBody)
            ->send();

        if ($response->isOk) {
            $data = $response->data;
            if (isset($data['data']['token'])) {
                return $data['data']['token'];
            }
        }

        $errMsg = $this->parseApiError($response, 'Đăng nhập MID');
        Yii::error("Lỗi đăng nhập MID: " . $errMsg . " | Data: " . json_encode($response->data));
        throw new \Exception($errMsg);
    }

    /**
     * Gọi API lấy dữ liệu GPS Realtime
     */
    public function getRealtimeGps($token)
    {
        $client = new Client(['baseUrl' => $this->baseUrl]);

        // Với phương thức GET, query data rỗng []
        $headers = $this->generateHeaders('GET', []);
        $headers['Authorization'] = 'Bearer ' . $token;

        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl('/api/v2/realtime/gps')
            ->addHeaders($headers)
            ->send();

        if ($response->isOk) {
            return $response->data;
        }

        $errMsg = $this->parseApiError($response, 'Lấy dữ liệu GPS');
        Yii::error("Lỗi lấy GPS: " . $errMsg . " | Data: " . json_encode($response->data));
        throw new \Exception($errMsg);
    }
}
