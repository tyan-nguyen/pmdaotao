<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class MidController extends Controller
{
    public function actionTestGps()
    {
        try {
            // 1. Gọi đăng nhập lấy token (Trong thực tế nên lưu token vào Cache để tránh login liên tục)
            $token = Yii::$app->midApi->login();

            // 2. Dùng token gọi API Realtime GPS
            $gpsData = Yii::$app->midApi->getRealtimeGps($token);

            echo "<pre>";
            print_r($gpsData);
            echo "</pre>";
        } catch (\Exception $e) {
            return "Đã xảy ra lỗi: " . $e->getMessage();
        }
    }
}
