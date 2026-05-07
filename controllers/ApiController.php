<?php

namespace app\controllers; // Đổi lại thành frontend\controllers hoặc backend\controllers nếu dùng Advanced Template

use app\models\XeLogApi;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class ApiController extends Controller
{
    // Bắt buộc: Tắt xác thực CSRF để tool Python có thể gọi POST vào API này mà không bị chặn
    public $enableCsrfValidation = false;

    public function actionLpr1()
    {
        echo 'kkkkkkkkkkk';
    }

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
        $model->bien_so = $plate;
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
}
