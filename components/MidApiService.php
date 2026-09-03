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
     * Lấy timestamp hiện tại (mili-giây)
     */
    private function getTimestamp()
    {
        return (string) round(microtime(true) * 1000);
    }

    /**
     * Tạo headers chứa chữ ký số
     */
    private function generateHeaders($method, $payloadData = [])
    {
        $timestamp = $this->getTimestamp();

        $dataStr = empty($payloadData) ? '' : json_encode($payloadData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        // 1. Tạo chuỗi dữ liệu gốc
        $inputString = strtoupper($method) . ' ' . $dataStr . '\\' . $timestamp . '|' . $this->apiKey;

        // 2. [B1] Dùng SECRET_KEY_HASH để tạo hash (HMAC-SHA256) từ chuỗi dữ liệu gốc
        // Đây chính là bước: hmac = crypto.createHmac("SHA256", SECRET_KEY_HASH);
        $hmacHash = hash_hmac('sha256', $inputString, $this->secretKeyHash);

        // Đọc file private key
        $privateKey = file_get_contents(Yii::getAlias($this->privateKeyPath));
        if (!$privateKey) {
            throw new \Exception("Không thể đọc được file Private Key");
        }

        // 3. [B2 & B3] Ký điện tử chuỗi HMAC bằng Private Key (file .pem)
        // Đây chính là bước: sign = crypto.createSign("SHA256"); sign.sign(privateKey, "base64");
        $signature = '';
        $pkeyId = openssl_pkey_get_private($privateKey);

        // Truyền $hmacHash vào để ký
        openssl_sign($hmacHash, $signature, $pkeyId, OPENSSL_ALGO_SHA256);

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

        Yii::error("Lỗi đăng nhập MID: " . json_encode($response->data));
        throw new \Exception("Đăng nhập thất bại. Vui lòng kiểm tra log.");
    }

    /**
     * Gọi API lấy dữ liệu GPS Realtime
     */
    public function getRealtimeGps($token)
    {
        $client = new Client(['baseUrl' => $this->baseUrl]);

        // Với phương thức GET, body trống nên param dữ liệu truyền vào mảng rỗng []
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

        Yii::error("Lỗi lấy GPS: " . json_encode($response->data));
        throw new \Exception("Lấy dữ liệu GPS thất bại.");
    }
}
