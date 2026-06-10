<?php

namespace app\controllers; // Đổi lại thành frontend\controllers hoặc backend\controllers nếu dùng Advanced Template

use app\models\XeLogApi;
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
            return [
                'success' => true,
                'message' => 'Lấy thông tin kế hoạch xe thành công.',
                'data' => [
                    'bien_so_xe' => '84A-111.11',
                    'nguoi_quan_ly' => [
                        'Nguyễn Văn A',
                        'Nguyễn Văn B',
                    ],
                    'ngay_tra_cuu' => $ngay,
                    'ke_hoach' => [
                        [
                            'thoi_gian' => '07:00 - 09:00',
                            'noi_dung' => 'Dạy thực hành lái xe hạng B',
                            'nguoi_phu_trach' => 'Nguyễn Văn A',
                        ],
                        [
                            'thoi_gian' => '09:30 - 11:30',
                            'noi_dung' => 'Ôn tập sa hình',
                            'nguoi_phu_trach' => 'Nguyễn Văn B',
                        ],
                        [
                            'thoi_gian' => '14:00 - 16:00',
                            'noi_dung' => 'Kiểm tra xe trước sát hạch',
                            'nguoi_phu_trach' => 'Nguyễn Văn A',
                        ],
                    ],
                ],
            ];
        }
    }
}
