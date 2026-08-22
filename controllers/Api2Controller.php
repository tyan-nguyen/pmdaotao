<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\models\PtxXe;
use app\models\GdTietHoc;

class Api2Controller extends Controller
{
    // Tắt xác thực CSRF để hỗ trợ gọi API qua GET/POST từ bên ngoài
    public $enableCsrfValidation = false;

    /**
     * API KiemTraDiCoKeHoach
     * Truyền vào biển số xe (qua GET, POST hoặc JSON body)
     * Loại bỏ các dấu ., -, space, ký tự đặc biệt khỏi biển số.
     * Tìm trong bảng [ptx_xe] xem có thuộc danh sách xe không (trường ma_bien_so).
     * Nếu có thì search trong bảng [gd_tiet_hoc] dựa vào id của xe (id_xe) và ngày hiện tại (thoi_gian_bd).
     * Nếu có trả về true, không có trả về false.
     *
     * @param string|null $bien_so
     * @return bool
     */
    public function actionKiemTraDiKhongKeHoach($bien_so = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $request = Yii::$app->request;
        $inputPlate = $bien_so;

        // Nếu tham số không truyền qua URL action, tìm thêm trong GET, POST và Raw JSON Body
        if (empty($inputPlate)) {
            $inputPlate = $request->get('bien_so')
                ?: $request->get('bienSo')
                ?: $request->get('ma_bien_so')
                ?: $request->get('code')
                ?: $request->get('plate')
                ?: $request->post('bien_so')
                ?: $request->post('bienSo')
                ?: $request->post('ma_bien_so')
                ?: $request->post('code')
                ?: $request->post('plate');
        }

        if (empty($inputPlate)) {
            $rawBody = $request->getRawBody();
            if (!empty($rawBody)) {
                $jsonData = json_decode($rawBody, true);
                if (is_array($jsonData)) {
                    $inputPlate = $jsonData['bien_so']
                        ?? $jsonData['bienSo']
                        ?? $jsonData['ma_bien_so']
                        ?? $jsonData['code']
                        ?? $jsonData['plate']
                        ?? null;
                }
            }
        }

        if (empty($inputPlate)) {
            return false;
        }

        // Loại bỏ các dấu ., -, space, ký tự đặc biệt khỏi biển số
        $bienSoClean = preg_replace('/[^A-Za-z0-9]/', '', (string)$inputPlate);
        $bienSoClean = strtoupper($bienSoClean);

        if (empty($bienSoClean)) {
            return false;
        }

        // Tìm trong bảng [ptx_xe] xem có thuộc danh sách xe không (trường ma_bien_so)
        $xe = PtxXe::find()
            ->where(['ma_bien_so' => $bienSoClean])
            ->orWhere(['REPLACE(REPLACE(REPLACE(ma_bien_so, ".", ""), "-", ""), " ", "")' => $bienSoClean])
            ->orWhere(['REPLACE(REPLACE(REPLACE(bien_so_xe, ".", ""), "-", ""), " ", "")' => $bienSoClean])
            ->one();

        if (!$xe) {
            return false;
        }

        // Tìm trong bảng [gd_tiet_hoc] dựa vào id của xe (trường id_xe) và ngày hiện tại (trường datetime thoi_gian_bd)
        $today = date('Y-m-d');
        $hasSchedule = GdTietHoc::find()
            ->where(['id_xe' => $xe->id])
            ->andWhere(['>=', 'thoi_gian_bd', $today . ' 00:00:00'])
            ->andWhere(['<=', 'thoi_gian_bd', $today . ' 23:59:59'])
            ->exists();

        return !(bool)$hasSchedule; //có return false, không return true
    }
}
