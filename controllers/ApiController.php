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
        if (empty($taiSan)) {
            return [
                'success' => false,
                'message' => 'Không tìm thấy xe.',
            ];
        }

        $listGvName = [];
        foreach ($taiSan->getListGiaoVienSuDung() as $gv) {
            $listGvName[] = $gv->giaoVien->ho_ten;
        }
        $listHinhAnh = [];
        foreach ($taiSan->hinhAnhs as $ha) {
            $listHinhAnh[] = $ha->urlAnh;
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
    }
}
