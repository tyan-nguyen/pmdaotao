<?php

namespace app\controllers; // Đổi lại thành frontend\controllers hoặc backend\controllers nếu dùng Advanced Template

use app\models\XeLogApi;
use app\modules\taisan\models\TaiSan;
use app\modules\thuexe\models\Xe;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;

class ApiController extends Controller
{
    // Bắt buộc: Tắt xác thực CSRF để tool Python có thể gọi POST vào API này mà không bị chặn
    public $enableCsrfValidation = false;
    public function actionLpr()
    {
        // Yêu cầu framework trả kết quả về dưới dạng JSON
        Yii::$app->response->format = Response::FORMAT_JSON;

        // Chỉ cho phép phương thức POST
        if (!Yii::$app->request->isPost) {
            Yii::$app->response->statusCode = 405; // Method Not Allowed
            return [
                'status' => 'error',
                'message' => 'Chỉ chấp nhận phương thức POST.'
            ];
        }

        // Lấy dữ liệu thô (raw body) và giải mã JSON
        $rawBody = Yii::$app->request->getRawBody();
        $data = json_decode($rawBody, true);

        if (!$data) {
            Yii::$app->response->statusCode = 400; // Bad Request
            return [
                'status' => 'error',
                'message' => 'Dữ liệu JSON không hợp lệ.'
            ];
        }

        // Lấy các tham số gửi từ file sender.py
        $plate = isset($data['plate']) ? $data['plate'] : null;
        $cameraId = isset($data['camera_id']) ? $data['camera_id'] : null;
        $timestamp = isset($data['timestamp']) ? $data['timestamp'] : date('Y-m-d H:i:s');

        // Kiểm tra xem có đủ dữ liệu bắt buộc không
        if (!$plate || !$cameraId) {
            Yii::$app->response->statusCode = 400;
            return [
                'status' => 'error',
                'message' => 'Thiếu thông tin plate hoặc camera_id.'
            ];
        }

        /* 
         * ==========================================
         * XỬ LÝ LƯU VÀO DATABASE TẠI ĐÂY
         * ==========================================
         */

        // Ví dụ: Lưu vào model LogBienSo
        $model = new XeLogApi();
        $model->ma_bien_so = $plate;
        $model->ma_camera = $cameraId;
        $model->thoi_gian = $timestamp;
        $model->save();

        // Trả về phản hồi thành công cho tool Python
        return [
            'status' => 'success',
            'message' => 'Đã nhận thành công',
            'data' => [
                'plate' => $plate,
                'camera' => $cameraId,
                'time' => $timestamp
            ]
        ];
    }

    private function isValidDate($date)
    {
        $d = \DateTime::createFromFormat('Y-m-d', $date);

        return $d && $d->format('Y-m-d') === $date;
    }
    /**
     * kiem tra xe vao ra
     * GET /api/xe/ke-hoach?code=84A-111.11&ngay=2026-06-10
     */
    public function actionCheckCar()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $code = Yii::$app->request->get('code');
        $ngay = Yii::$app->request->get('ngay');

        if (empty($code)) {
            throw new BadRequestHttpException('Thiếu tham số code.');
        }

        if (empty($ngay)) {
            $ngay = date('Y-m-d');
        }

        if (!$this->isValidDate($ngay)) {
            throw new BadRequestHttpException('Ngày không đúng định dạng Y-m-d.');
        }

        $xe = Xe::find()
            ->where([
                'or',
                ['bien_so_xe' => $code],
                ['ma_bien_so' => $code],
            ])
            ->one();
        if (!$xe) {
            return [
                'success' => false,
                'message' => 'Không tìm thấy xe theo biển số.',
                'data' => null,
            ];
        } else {
            $listGvName = [];
            foreach ($xe->getListGiaoVienSuDung() as $gv) {
                $listGvName[] = $gv->giaoVien->ho_ten;
            }
            return [
                'success' => true,
                'message' => 'Lấy thông tin kế hoạch xe thành công.',
                'data' => [
                    'bien_so_xe' => $xe->bien_so_xe,
                    'trang_thai' => $xe->getXeDangSuDungQuaCamera() ? "Hoạt động" : "Không hoạt động", //!!!!
                    'nguoi_quan_ly' => $listGvName,
                    'ngay_tra_cuu' => $ngay,
                    'ke_hoach' => $xe->getListHoatDongTheoNgay($ngay),
                ],
            ];
            /* return [
                'success' => true,
                'message' => 'Lấy thông tin kế hoạch xe thành công.',
                'data' => [
                    'bien_so_xe' => '84A-111.11',
                    'trang_thai' => 'Không hoạt động',
                    'nguoi_quan_ly' => [
                        'Nguyễn Văn A',
                        'Nguyễn Văn B',
                    ],
                    'ngay_tra_cuu' => $ngay,
                    'ke_hoach' => [
                        [
                            'thoi_gian' => '07:00 - 09:00' . $ngay,
                            'noi_dung' => 'Dạy thực hành lái xe hạng B',
                            'nguoi_phu_trach' => 'Nguyễn Văn A',
                        ],
                        [
                            'thoi_gian' => '09:30 - 11:30' . $ngay,
                            'noi_dung' => 'Ôn tập sa hình',
                            'nguoi_phu_trach' => 'Nguyễn Văn B',
                        ],
                        [
                            'thoi_gian' => '14:00 - 16:00' . $ngay,
                            'noi_dung' => 'Kiểm tra xe trước sát hạch',
                            'nguoi_phu_trach' => 'Nguyễn Văn A',
                        ],
                    ],
                ],
            ]; */
        }
    }

    /**
     * kiem tra xe vao ra
     * GET /api/xe/ke-hoach?code=84A-111.11&ngay=2026-06-10
     */
    public function actionGetTaiSan($code)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $code = Yii::$app->request->get('code');

        if (empty($code)) {
            throw new BadRequestHttpException('Thiếu tham số code.');
        }

        //lay xe truoc
        $taiSan = Xe::find()->where(['ma_bien_so' => $code])->one();
        if (!empty($taiSan)) {
            $listGvName = [];
            foreach ($taiSan->getListGiaoVienSuDung() as $gv) {
                $listGvName[] = $gv->giaoVien->ho_ten;
            }
            $listHinhAnh = [];
            foreach ($taiSan->hinhAnhs as $ha) {
                $listHinhAnh[] = 'https://qltl.nguyentrinh.com.vn' . $ha->urlAnh;
            }
            return [
                'success' => true,
                'message' => 'Lấy danh sách tài sản thành công.',
                'data' => [
                    'ma_tai_san' => $taiSan->ma_bien_so,
                    'ten_tai_san' => $taiSan->bien_so_xe,
                    'trang_thai' => $taiSan->getXeDangSuDungQuaCamera() ? "Hoạt động" : "Không hoạt động", //!!!!
                    'ngay_san_xua' => $taiSan->nam_san_xuat,
                    'ngay_mua' => $taiSan->nam_mua,
                    'ngay_dua_vao_su_dung' => '',
                    'nguoi_quan_ly' => $listGvName,
                    'hinh_anh' => $listHinhAnh
                ],
            ];
        } else {
            $taiSan = TaiSan::find()->where([
                'autoid' => $code,
            ])->one();
            if (empty($taiSan)) {
                return [
                    'success' => false,
                    'message' => 'Không tìm thấy.',
                ];
            }
            $listGvName = [];
            /* foreach ($taiSan->getListGiaoVienSuDung() as $gv) {
                $listGvName[] = $gv->giaoVien->ho_ten;
            } */
            $listHinhAnh = [];
            foreach ($taiSan->getListHinhAnh() as $ha) {
                $listHinhAnh[] = 'https://qltl.nguyentrinh.com.vn' . $ha;
            }
            /*  foreach ($taiSan->hinhAnhs as $ha) {
                $listHinhAnh[] = 'https://qltl.nguyentrinh.com.vn' . $ha->urlAnh;
            } */
            return [
                'success' => true,
                'message' => 'Lấy danh sách tài sản thành công.',
                'data' => [
                    'ma_tai_san' => $taiSan->autoid,
                    'ten_tai_san' => $taiSan->ten_tai_san,
                    'trang_thai' => $taiSan->trang_thai == 1 ? "Hoạt động" : "Không hoạt động", //!!!!
                    'ngay_san_xua' => '',
                    'ngay_mua' => $taiSan->ngay_mua,
                    'ngay_dua_vao_su_dung' => $taiSan->ngay_dua_vao_su_dung,
                    'nguoi_quan_ly' => $taiSan->nguoiChiuTrachNhiem ? [$taiSan->nguoiChiuTrachNhiem->ho_ten] : null,
                    'hinh_anh' => $listHinhAnh
                ],
            ];
        }



        /*  return [
            'success' => true,
            'message' => 'Lấy danh sách tài sản thành công.',
            'data' => [
                'ma_tai_san' => $taiSan->ma_bien_so,
                'ten_tai_san' => $taiSan->bien_so_xe,
                'trang_thai' => $taiSan->getXeDangSuDungQuaCamera() ? "Hoạt động" : "Không hoạt động", //!!!!
                'ngay_san_xua' => $taiSan->nam_san_xuat,
                'ngay_mua' => $taiSan->nam_mua,
                'ngay_dua_vao_su_dung' => '',
                'nguoi_quan_ly' => $listGvName,
                'hinh_anh' => [
                    'https://qltl.nguyentrinh.com.vn/images/hinh-xe/6916d0650dd17.jpg',
                    'https://qltl.nguyentrinh.com.vn/images/hinh-xe/6916d0650f7b7.jpg',
                    'https://qltl.nguyentrinh.com.vn/images/hinh-xe/694b3fed2f53e.jpg'
                ]
            ],
        ]; */

        /* if (empty($taiSan)) {
            return [
                'success' => false,
                'message' => 'Không tìm thấy.',
            ];
        } */
    }

    /**
     * Lấy token hợp lệ của hệ thống từ config/params.php (fallback về token mặc định)
     * @return string
     */
    public function getValidToken()
    {
        return Yii::$app->params['camera_api_token'] ?? 'truonglai_camera_secure_token_2026';
    }

    /**
     * Trích xuất token từ request (Header Authorization Bearer, X-API-Key, X-Token, Body JSON hoặc Query/Post param)
     * @return string|null
     */
    protected function getRequestToken()
    {
        $request = Yii::$app->request;

        // 1. Kiểm tra header Authorization: Bearer <token>
        $authHeader = $request->headers->get('Authorization');
        if ($authHeader && preg_match('/^Bearer\s+(.*?)$/i', $authHeader, $matches)) {
            return trim($matches[1]);
        }

        // 2. Kiểm tra header X-API-Key hoặc X-Token
        $apiKey = $request->headers->get('X-API-Key') ?: $request->headers->get('X-Token');
        if (!empty($apiKey)) {
            return trim($apiKey);
        }

        // 3. Kiểm tra trong Raw JSON body (token hoặc api_token)
        $rawBody = $request->getRawBody();
        if (!empty($rawBody)) {
            $jsonData = json_decode($rawBody, true);
            if (is_array($jsonData)) {
                if (!empty($jsonData['token'])) {
                    return trim($jsonData['token']);
                }
                if (!empty($jsonData['api_token'])) {
                    return trim($jsonData['api_token']);
                }
            }
        }

        // 4. Kiểm tra trong POST hoặc GET param
        return $request->post('token')
            ?: $request->post('api_token')
            ?: $request->get('token')
            ?: $request->get('api_token');
    }

    /**
     * Kiểm tra tính hợp lệ của token
     * @return bool
     */
    protected function validateApiToken()
    {
        $requestToken = $this->getRequestToken();
        $validToken = $this->getValidToken();

        if (empty($requestToken) || empty($validToken)) {
            return false;
        }

        return hash_equals((string)$validToken, (string)$requestToken);
    }

    /**
     * API Tìm biển số xe theo mã số xe
     * Tìm trong bảng ptx_xe theo ma_so, nếu có trả về ma_bien_so, nếu không có trả về null
     * Yêu cầu xác thực API token theo cấu hình config/params['camera_api_token']
     * 
     * Hỗ trợ GET / POST:
     * GET  /api/take-plate-by-number?number=01&token=xxx
     * POST /api/take-plate-by-number {"number": "01", "token": "xxx"}
     * Hoặc truyền qua Header:
     * Authorization: Bearer xxx
     * X-API-Key: xxx
     * 
     * @param string|null $number
     * @param string|null $ma_so
     * @return string|null|array
     */
    public function actionTakePlateByNumber($number = null, $ma_so = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        // Kiểm tra xác thực API token từ config param
        if (!$this->validateApiToken()) {
            Yii::$app->response->statusCode = 401; // Unauthorized
            return [
                'success' => false,
                'status' => 'error',
                'message' => 'Xác thực thất bại: Token API không hợp lệ hoặc chưa được cung cấp.',
            ];
        }

        $param = $number !== null ? $number : ($ma_so !== null ? $ma_so : null);
        if ($param === null) {
            $param = Yii::$app->request->get('number', Yii::$app->request->get('ma_so'));
        }
        if ($param === null) {
            $rawBody = Yii::$app->request->getRawBody();
            $data = json_decode($rawBody, true);
            if (is_array($data)) {
                $param = isset($data['number']) ? $data['number'] : (isset($data['ma_so']) ? $data['ma_so'] : null);
            }
        }
        if ($param === null) {
            $param = Yii::$app->request->post('number', Yii::$app->request->post('ma_so'));
        }

        if ($param === null || trim((string)$param) === '') {
            return null;
        }

        $param = trim((string)$param);

        // Tìm trong bảng ptx_xe theo ma_so
        $xe = Xe::find()->where(['ma_so' => $param])->one();

        // Fallback: nếu không tìm thấy và là dạng số, thử tìm dạng đệm 2 chữ số ('01') hoặc dạng thường ('1')
        if (!$xe && is_numeric($param)) {
            $intVal = (int)$param;
            $padded = sprintf('%02d', $intVal);
            $unpadded = (string)$intVal;
            $xe = Xe::find()
                ->where(['or', ['ma_so' => $padded], ['ma_so' => $unpadded]])
                ->one();
        }

        if ($xe && !empty($xe->ma_bien_so)) {
            return $xe->ma_bien_so;
        }

        return null;
    }
}
