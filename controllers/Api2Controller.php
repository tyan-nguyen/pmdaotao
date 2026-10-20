<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\models\PtxXe;
use app\models\GdTietHoc;
use app\modules\thuexe\models\XeCameraLogs;
use app\modules\thuexe\services\XeCameraTripService;

class Api2Controller extends Controller
{
    // Tắt xác thực CSRF để hỗ trợ gọi API qua GET/POST từ bên ngoài
    public $enableCsrfValidation = false;

    /**
     * Mã token mặc định dùng để xác thực API từ bên ngoài
     * Bạn có thể đổi mã này trực tiếp tại đây hoặc khai báo 'camera_api_token' trong file config/params.php
     */
    const API_TOKEN = 'truonglai_camera_secure_token_2026';

    /**
     * Danh sách các action bắt buộc phải có token xác thực
     * (Thêm 'kiem-tra-di-khong-ke-hoach' vào mảng này nếu muốn áp dụng token cho cả API đó)
     * @var array
     */
    protected $tokenActions = [
        'camera-logs',
        'camera-front',
        'camera-rear',
        'camera-logs-front',
        'camera-logs-rear',
        'camera-can-tin',
        'camera-san-cam-bien',
        'camera-san-cam-bien-vao',
        'camera-san-cam-bien-ra',
        'camera-san-xuat-phat',
        'camera-san-ket-thuc',
    ];

    /**
     * Lấy token hợp lệ của hệ thống (ưu tiên config/params.php, fallback về const API_TOKEN)
     * @return string
     */
    public function getValidToken()
    {
        return Yii::$app->params['camera_api_token'] ?? self::API_TOKEN;
    }

    /**
     * Trích xuất token từ request
     * Hỗ trợ đa dạng phương thức:
     * 1. Header 'Authorization: Bearer <token>'
     * 2. Header 'X-API-Key: <token>' hoặc 'X-Token: <token>'
     * 3. Trường 'token' hoặc 'api_token' trong JSON Body
     * 4. Tham số 'token' hoặc 'api_token' trong form POST / GET
     *
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

        // 3. Kiểm tra trong Raw JSON body (nếu client gửi kèm trường token / api_token)
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
     * Kiểm tra tính hợp lệ của token (dùng hash_equals chống tấn công timing attack)
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
     * {@inheritdoc}
     */
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        // Tự động định dạng JSON cho mọi response của API
        Yii::$app->response->format = Response::FORMAT_JSON;

        // Kiểm tra xác thực token cho các action trong danh sách $tokenActions
        if (in_array($action->id, $this->tokenActions, true)) {
            if (!$this->validateApiToken()) {
                Yii::$app->response->statusCode = 401; // Unauthorized
                Yii::$app->response->data = [
                    'success' => false,
                    'status' => 'error',
                    'message' => 'Xác thực thất bại: Token API không hợp lệ hoặc chưa được cung cấp.',
                ];
                return false;
            }
        }

        return true;
    }

    /**
     * Logic kiểm tra kế hoạch đi của xe (dùng chung cho actionKiemTraDiKhongKeHoach và actionCameraLogs)
     * - Tìm trong bảng [ptx_xe] theo biển số (loại bỏ dấu ., -, khoảng trắng).
     * - Nếu tìm thấy, tìm trong bảng [gd_tiet_hoc] dựa vào id của xe (id_xe) và ngày kiểm tra (thoi_gian_bd).
     *
     * @param string|null $bienSo
     * @param string|null $checkDate Định dạng 'Y-m-d' hoặc 'Y-m-d H:i:s' (mặc định là ngày hôm nay)
     * @return array [
     *     'thuoc_danh_sach_xe' => bool,
     *     'co_ke_hoach' => bool,
     *     'di_khong_ke_hoach' => bool, // Có lịch return false, không có lịch return true
     *     'xe' => PtxXe|null
     * ]
     */
    public function kiemTraKeHoachXe($bienSo, $checkDate = null)
    {
        return XeCameraTripService::kiemTraKeHoachXe($bienSo, $checkDate);
    }

    /**
     * API KiemTraDiCoKeHoach
     * Truyền vào biển số xe (qua GET, POST hoặc JSON body)
     * Loại bỏ các dấu ., -, space, ký tự đặc biệt khỏi biển số.
     * Tìm trong bảng [ptx_xe] xem có thuộc danh sách xe không (trường ma_bien_so).
     * Nếu có thì search trong bảng [gd_tiet_hoc] (với Cổng căn tin) hoặc [ptx_lich_thue] (với Sân cảm biến).
     * Nếu không có kế hoạch/lịch thuê trả về true, có kế hoạch trả về false.
     *
     * @param string|null $bien_so
     * @param string|null $camera_code
     * @param string|null $thoi_gian
     * @return bool
     */
    public function actionKiemTraDiKhongKeHoach($bien_so = null, $camera_code = null, $thoi_gian = null)
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

        $camCode = $camera_code ?: $request->get('camera_code') ?: $request->post('camera_code');
        $timeStr = $thoi_gian ?: $request->get('thoi_gian') ?: $request->get('detected_at') ?: $request->post('thoi_gian') ?: $request->post('detected_at');

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
                    if (empty($camCode)) {
                        $camCode = $jsonData['camera_code'] ?? $jsonData['camera'] ?? null;
                    }
                    if (empty($timeStr)) {
                        $timeStr = $jsonData['thoi_gian'] ?? $jsonData['detected_at'] ?? null;
                    }
                }
            }
        }

        if (empty($inputPlate)) {
            return false;
        }

        $parsedCam = XeCameraLogs::parseMaCamera($camCode);
        if (
            $parsedCam === XeCameraLogs::CAMERA_CONG_SAN_CAM_BIEN
            || $parsedCam === XeCameraLogs::CAMERA_CONG_SAN_CAM_BIEN_VAO
            || $parsedCam === XeCameraLogs::CAMERA_CONG_SAN_CAM_BIEN_RA
            || $parsedCam === XeCameraLogs::CAMERA_SAN_XUAT_PHAT
            || $parsedCam === XeCameraLogs::CAMERA_SAN_KET_THUC
        ) {
            $check = XeCameraTripService::kiemTraLichThueXe($inputPlate, $timeStr);
        } else {
            $check = $this->kiemTraKeHoachXe($inputPlate, $timeStr);
        }

        return $check['di_khong_ke_hoach'];
    }

    /**
     * API tiếp nhận log camera chung cho tất cả các cổng
     * Route: POST /api2/camera-logs
     *
     * @return array
     */
    public function actionCameraLogs()
    {
        return $this->processCameraLog();
    }

    /**
     * Dedicated API tiếp nhận Camera Mặt Trước (Xe đi ra / Xe ngoài ra)
     * Route: POST /api2/camera-front
     *
     * @return array
     */
    public function actionCameraFront()
    {
        return $this->processCameraLog(XeCameraLogs::SU_KIEN_MAT_TRUOC);
    }

    /**
     * Alias route: POST /api2/camera-logs-front
     * @return array
     */
    public function actionCameraLogsFront()
    {
        return $this->processCameraLog(XeCameraLogs::SU_KIEN_MAT_TRUOC);
    }

    /**
     * Dedicated API tiếp nhận Camera Mặt Sau (Xe về bãi / Xe lạ vào sân)
     * Route: POST /api2/camera-rear
     *
     * @return array
     */
    public function actionCameraRear()
    {
        return $this->processCameraLog(XeCameraLogs::SU_KIEN_MAT_SAU);
    }

    /**
     * Alias route: POST /api2/camera-logs-rear
     * @return array
     */
    public function actionCameraLogsRear()
    {
        return $this->processCameraLog(XeCameraLogs::SU_KIEN_MAT_SAU);
    }

    /**
     * Dedicated API tiếp nhận Camera CỔNG CĂN TIN
     * Route: POST /api2/camera-can-tin
     * Tự động gán mã camera = cong_can_tin, kiểm tra kế hoạch giảng dạy trong gd_tiet_hoc
     *
     * @return array
     */
    public function actionCameraCanTin()
    {
        return $this->processCameraLog(null, XeCameraLogs::CAMERA_CONG_CAN_TIN);
    }

    /**
     * Dedicated API tiếp nhận Camera SÂN CẢM BIẾN (Chung cả Vào và Ra)
     * Route: POST /api2/camera-san-cam-bien
     * Tự động gán mã camera = cong_san_cam_bien, kiểm tra lịch thuê xe trong ptx_lich_thue
     *
     * @return array
     */
    public function actionCameraSanCamBien()
    {
        return $this->processCameraLog(null, XeCameraLogs::CAMERA_CONG_SAN_CAM_BIEN);
    }

    /**
     * Dedicated API tiếp nhận Camera SÂN CẢM BIẾN - LÀN VÀO
     * Route: POST /api2/camera-san-cam-bien-vao
     * Tự động gán mã camera = cong_san_cam_bien_vao, kiểm tra lịch thuê xe trong ptx_lich_thue khi xe vào
     *
     * @return array
     */
    public function actionCameraSanCamBienVao()
    {
        return $this->processCameraLog(XeCameraLogs::SU_KIEN_MAT_TRUOC, XeCameraLogs::CAMERA_CONG_SAN_CAM_BIEN_VAO);
    }

    /**
     * Dedicated API tiếp nhận Camera SÂN CẢM BIẾN - LÀN RA
     * Route: POST /api2/camera-san-cam-bien-ra
     * Tự động gán mã camera = cong_san_cam_bien_ra, ghi nhận rời sân cảm biến
     *
     * @return array
     */
    public function actionCameraSanCamBienRa()
    {
        return $this->processCameraLog(XeCameraLogs::SU_KIEN_MAT_TRUOC, XeCameraLogs::CAMERA_CONG_SAN_CAM_BIEN_RA);
    }

    /**
     * Dedicated API tiếp nhận Camera SÂN XUẤT PHÁT
     * Route: POST /api2/camera-san-xuat-phat
     * Kiểm tra vé / lịch thuê xe realtime, không lưu database, không ghép cặp
     *
     * @return array
     */
    public function actionCameraSanXuatPhat()
    {
        return $this->processKiemTraVeSanTap('xuat_phat');
    }

    /**
     * Dedicated API tiếp nhận Camera SÂN KẾT THÚC
     * Route: POST /api2/camera-san-ket-thuc
     * Kiểm tra vé / lịch thuê xe realtime, không lưu database, không ghép cặp
     *
     * @return array
     */
    public function actionCameraSanKetThuc()
    {
        return $this->processKiemTraVeSanTap('ket_thuc');
    }

    /**
     * Xử lý kiểm tra vé xe tại Sân tập (Sân xuất phát / Sân kết thúc)
     * - Chỉ phát hiện xe trong ptx_xe có đăng ký lịch thuê trong ptx_lich_thue hay không
     * - Không lưu dữ liệu vào CSDL
     * - Không ghép cặp chuyến đi/về
     * - Trả về dữ liệu chuẩn xác cho ứng dụng camera ANPR phát loa và cảnh báo
     *
     * @param string $diemKiemSoat 'xuat_phat' hoặc 'ket_thuc'
     * @return array
     */
    public function processKiemTraVeSanTap($diemKiemSoat = 'xuat_phat')
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $request = Yii::$app->request;

        // Lấy dữ liệu từ JSON Raw Body hoặc Form POST/GET
        $data = [];
        $rawBody = $request->getRawBody();
        if (!empty($rawBody)) {
            $jsonData = json_decode($rawBody, true);
            if (is_array($jsonData)) {
                $data = $jsonData;
            }
        }

        // 1. Trích xuất Biển số xe gốc
        $plateNumber = $data['plate_number']
            ?? $data['bien_so_xe']
            ?? $data['bien_so']
            ?? $data['bienSo']
            ?? $data['bienSoXe']
            ?? $request->post('plate_number')
            ?? $request->post('bien_so_xe')
            ?? $request->post('bien_so')
            ?? $request->get('plate_number')
            ?? $request->get('bien_so_xe')
            ?? $request->get('bien_so');

        // 2. Trích xuất Mã xe đã làm sạch (nếu có)
        $cleanPlateInput = $data['clean_plate']
            ?? $data['ma_xe']
            ?? $request->post('clean_plate')
            ?? $request->post('ma_xe')
            ?? $request->get('clean_plate')
            ?? $request->get('ma_xe');

        $cleanPlate = !empty($cleanPlateInput)
            ? XeCameraLogs::chuanHoaMaXe($cleanPlateInput)
            : XeCameraLogs::chuanHoaMaXe($plateNumber);

        if (empty($cleanPlate)) {
            Yii::$app->response->statusCode = 422;
            return [
                'success' => false,
                'status' => 'error',
                'message' => 'Thiếu thông tin biển số xe (plate_number hoặc bien_so_xe).',
            ];
        }

        $displayPlate = !empty($plateNumber) ? trim((string)$plateNumber) : $cleanPlate;

        // 3. Trích xuất Thời gian quét
        $detectedAt = $data['detected_at']
            ?? $data['thoi_gian']
            ?? $data['time']
            ?? $request->post('detected_at')
            ?? $request->post('thoi_gian')
            ?? $request->get('detected_at')
            ?? date('Y-m-d H:i:s');

        // Cấu hình theo điểm kiểm soát
        if ($diemKiemSoat === 'ket_thuc') {
            $cameraCode = XeCameraLogs::CAMERA_SAN_KET_THUC;
            $diemKey = 'ket_thuc';
            $tenDiem = 'điểm kết thúc';
        } else {
            $cameraCode = XeCameraLogs::CAMERA_SAN_XUAT_PHAT;
            $diemKey = 'xuat_phat';
            $tenDiem = 'điểm xuất phát';
        }

        // 4. Kiểm tra xe trong danh sách ptx_xe và lịch thuê trong ptx_lich_thue
        $check = XeCameraTripService::kiemTraLichThueXe($cleanPlate, $detectedAt);
        $isXeNoiBo = (bool)$check['thuoc_danh_sach_xe'];
        $hasLichThue = (bool)$check['co_ke_hoach'];
        $lichThue = $check['lich_thue'];

        // =========================================================================
        // PHÂN NHÁNH 3 TRƯỜNG HỢP CHUẨN XÁC THEO HỆ THỐNG ANPR CAMERA
        // =========================================================================
        if ($isXeNoiBo) {
            if ($hasLichThue && $lichThue) {
                // TH 1: Xe nội bộ CÓ lịch thuê hợp lệ
                return [
                    'success' => true,
                    'status' => 'success',
                    'action_status' => 'APPROVED',
                    'vehicle_classification' => 'INTERNAL_VALID',
                    'alert_level' => 'normal',
                    'summary' => 'Xe có lịch thuê sân',
                    'message' => "Xe {$displayPlate} hợp lệ",
                    'voice_message' => "Xe {$displayPlate} hợp lệ",
                    'webhook_result_bool' => true,
                    'data' => [
                        'camera' => $cameraCode,
                        'diem_kiem_soat' => $diemKey,
                        'plate_number' => $displayPlate,
                        'clean_plate' => $cleanPlate,
                        'thuoc_danh_sach_xe' => true,
                        'co_lich_thue' => true,
                        'rental_schedule' => [
                            'id' => $lichThue->id,
                            'thoi_gian_bat_dau' => $lichThue->thoi_gian_bat_dau,
                            'thoi_gian_ket_thuc' => $lichThue->thoi_gian_ket_thuc,
                        ],
                    ],
                ];
            } else {
                // TH 2: Xe nội bộ KHÔNG có lịch thuê (Vi phạm xe trường)
                return [
                    'success' => false,
                    'status' => 'error',
                    'action_status' => 'UNPLANNED',
                    'vehicle_classification' => 'INTERNAL_UNPLANNED',
                    'alert_level' => 'warning',
                    'summary' => 'Xe không có lịch thuê',
                    'message' => "Phát hiện xe {$displayPlate} vào sân không mua vé tại {$tenDiem}",
                    'voice_message' => "Phát hiện xe {$displayPlate} vào sân không mua vé tại {$tenDiem}",
                    'webhook_result_bool' => false,
                    'data' => [
                        'camera' => $cameraCode,
                        'diem_kiem_soat' => $diemKey,
                        'plate_number' => $displayPlate,
                        'clean_plate' => $cleanPlate,
                        'thuoc_danh_sach_xe' => true,
                        'co_lich_thue' => false,
                    ],
                ];
            }
        } else {
            // TH 3: XE LẠ ngoài danh sách (Chưa mua vé / Không có trong ptx_xe)
            return [
                'success' => false,
                'status' => 'error',
                'action_status' => 'INFO',
                'vehicle_classification' => 'EXTERNAL_UNKNOWN',
                'alert_level' => 'warning',
                'summary' => 'Xe lạ ngoài danh sách',
                'message' => "Phát hiện xe lạ {$displayPlate} vào sân không mua vé tại {$tenDiem}",
                'voice_message' => "Phát hiện xe lạ {$displayPlate} vào sân không mua vé tại {$tenDiem}",
                'webhook_result_bool' => false,
                'data' => [
                    'camera' => $cameraCode,
                    'diem_kiem_soat' => $diemKey,
                    'plate_number' => $displayPlate,
                    'clean_plate' => $cleanPlate,
                    'thuoc_danh_sach_xe' => false,
                    'co_lich_thue' => false,
                ],
            ];
        }
    }

    /**
     * Xử lý lõi tiếp nhận log camera
     *
     * @param string|null $forcedView Ép cố định góc chụp nếu gọi từ endpoint chuyên biệt (mat_truoc / mat_sau)
     * @param string|null $forcedCameraCode Ép cố định mã camera nếu gọi từ endpoint chuyên biệt (cong_can_tin / cong_san_cam_bien_vao / cong_san_cam_bien_ra)
     * @return array
     */
    protected function processCameraLog($forcedView = null, $forcedCameraCode = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $request = Yii::$app->request;

        if (!$request->isPost) {
            Yii::$app->response->statusCode = 405;
            return [
                'status' => 'error',
                'message' => 'Phương thức yêu cầu không hợp lệ. Vui lòng gửi bằng phương thức POST.',
            ];
        }

        // Lấy dữ liệu từ JSON Raw Body hoặc Form POST
        $data = [];
        $rawBody = $request->getRawBody();
        if (!empty($rawBody)) {
            $jsonData = json_decode($rawBody, true);
            if (is_array($jsonData)) {
                $data = $jsonData;
            }
        }

        // 0. Phân loại sự kiện: CREATE (mặc định), UPDATE, DELETE, RESTORE
        $eventAction = strtoupper(trim((string)($data['event_action'] ?? $request->post('event_action') ?? 'CREATE')));
        $logId = $data['log_id'] ?? $data['id_su_kien'] ?? $request->post('log_id') ?? $request->post('id_su_kien') ?? null;
        if (!empty($logId)) {
            $logId = (int)$logId;
        }
        $oldPlate = $data['old_plate_number'] ?? $data['bien_so_cu'] ?? $request->post('old_plate_number') ?? $request->post('bien_so_cu') ?? null;
        $deletedBy = $data['deleted_by'] ?? $request->post('deleted_by') ?? 'admin';
        $deletedAt = $data['deleted_at'] ?? $request->post('deleted_at') ?? date('Y-m-d H:i:s');
        $restoredBy = $data['restored_by'] ?? $request->post('restored_by') ?? 'admin';
        $restoredAt = $data['restored_at'] ?? $request->post('restored_at') ?? date('Y-m-d H:i:s');

        // 1. Trích xuất mã Camera (ưu tiên $forcedCameraCode, sau đó camera_code, camera_id số, object camera, camera_name hoặc ma_camera)
        $maCamera = null;
        if ($forcedCameraCode !== null) {
            $maCamera = $forcedCameraCode;
        } elseif (!empty($data['camera_code'])) {
            $maCamera = $data['camera_code'];
        } elseif ($request->post('camera_code')) {
            $maCamera = $request->post('camera_code');
        } elseif (isset($data['camera'])) {
            if (is_array($data['camera'])) {
                $maCamera = $data['camera']['code'] ?? $data['camera']['camera_code'] ?? $data['camera']['id'] ?? $data['camera']['name'] ?? null;
            } elseif (is_string($data['camera']) || is_numeric($data['camera'])) {
                $maCamera = $data['camera'];
            }
        }
        if ($maCamera === null) {
            $maCamera = $data['camera_id']
                ?? $data['camera_name']
                ?? $data['ma_camera']
                ?? $data['maCamera']
                ?? $request->post('camera_id')
                ?? $request->post('camera_name')
                ?? $request->post('ma_camera')
                ?? $request->post('camera');
        }
        $maCamera = XeCameraLogs::parseMaCamera($maCamera);

        // Nếu là camera Sân xuất phát hoặc Sân kết thúc -> chuyển hướng sang processKiemTraVeSanTap (không lưu CSDL, không ghép cặp)
        if ($maCamera === XeCameraLogs::CAMERA_SAN_XUAT_PHAT) {
            return $this->processKiemTraVeSanTap('xuat_phat');
        } elseif ($maCamera === XeCameraLogs::CAMERA_SAN_KET_THUC) {
            return $this->processKiemTraVeSanTap('ket_thuc');
        }

        // 2. Trích xuất Biển số xe gốc (hỗ trợ plate_number từ ANPR hoặc bien_so_xe)
        $bienSoXe = $data['plate_number']
            ?? $data['bien_so_xe']
            ?? $data['bien_so']
            ?? $data['bienSo']
            ?? $data['bienSoXe']
            ?? $request->post('plate_number')
            ?? $request->post('bien_so_xe')
            ?? $request->post('bien_so');

        // 3. Trích xuất Mã xe đã làm sạch (hỗ trợ clean_plate từ ANPR hoặc ma_xe)
        $cleanPlateInput = $data['clean_plate']
            ?? $data['ma_xe']
            ?? $request->post('clean_plate')
            ?? $request->post('ma_xe');

        // Chuẩn hóa biển số xe -> ma_xe
        $maXe = !empty($cleanPlateInput) ? XeCameraLogs::chuanHoaMaXe($cleanPlateInput) : XeCameraLogs::chuanHoaMaXe($bienSoXe);

        // 4. Trích xuất & Ánh xạ Sự kiện (hỗ trợ vehicle_view từ ANPR, su_kien, hoặc forcedView)
        $suKienRaw = $data['vehicle_view']
            ?? $data['su_kien']
            ?? $data['suKien']
            ?? $data['event']
            ?? $request->post('vehicle_view')
            ?? $request->post('su_kien');

        $suKien = null;
        if (!empty($suKienRaw)) {
            $viewLower = strtolower(trim((string)$suKienRaw));
            if (in_array($viewLower, ['front', 'mat_truoc', 'truoc'], true)) {
                $suKien = XeCameraLogs::SU_KIEN_MAT_TRUOC; // 'mat_truoc'
            } elseif (in_array($viewLower, ['rear', 'back', 'mat_sau', 'sau'], true)) {
                $suKien = XeCameraLogs::SU_KIEN_MAT_SAU;   // 'mat_sau'
            } else {
                $suKien = $viewLower;
            }
        } elseif ($forcedView !== null) {
            $suKien = $forcedView;
        } elseif (
            $maCamera === XeCameraLogs::CAMERA_CONG_SAN_CAM_BIEN_VAO
            || $maCamera === XeCameraLogs::CAMERA_CONG_SAN_CAM_BIEN_RA
        ) {
            // Đối với các làn riêng của Sân cảm biến, nếu không truyền góc chụp thì mặc định là mặt trước
            $suKien = XeCameraLogs::SU_KIEN_MAT_TRUOC;
        }

        // 5. Trích xuất Thời gian (hỗ trợ detected_at từ ANPR hoặc thoi_gian)
        $thoiGian = $data['detected_at']
            ?? $data['thoi_gian']
            ?? $data['thoiGian']
            ?? $data['time']
            ?? $request->post('detected_at')
            ?? $request->post('thoi_gian');

        // =========================================================================
        // XỬ LÝ NHÁNH A: XÓA TẠM VÀO THÙNG RÁC (DELETE - SOFT DELETE)
        // =========================================================================
        if ($eventAction === 'DELETE') {
            $record = null;
            if (!empty($logId)) {
                $record = XeCameraLogs::findOne(['camera_log_id' => $logId]);
            }
            if (!$record && (!empty($maXe) || !empty($bienSoXe))) {
                $searchPlate = !empty($maXe) ? $maXe : XeCameraLogs::chuanHoaMaXe($bienSoXe);
                $query = XeCameraLogs::find()
                    ->where(['or', ['ma_xe' => $searchPlate], ['bien_so_xe' => $bienSoXe]]);
                if (!empty($thoiGian)) {
                    $timeWindowStart = date('Y-m-d H:i:s', strtotime($thoiGian) - 300);
                    $timeWindowEnd   = date('Y-m-d H:i:s', strtotime($thoiGian) + 300);
                    $query->andWhere(['between', 'thoi_gian', $timeWindowStart, $timeWindowEnd]);
                }
                $record = $query->orderBy(['id' => SORT_DESC])->one();
            }

            if ($record) {
                if ($record->hasAttribute('is_deleted')) {
                    $record->is_deleted = XeCameraLogs::STATUS_DELETED;
                    $record->deleted_at = $deletedAt;
                    $record->deleted_by = $deletedBy;
                }
                $record->save(false);

                // Tự động re-sync lại các block chuyến cho xe này khi log bị xóa tạm
                XeCameraTripService::syncVehicleTrips($record->ma_xe);
            }

            Yii::$app->response->statusCode = 200;
            return [
                'success' => true,
                'action_status' => 'DELETED',
                'message' => 'Đã đánh dấu xóa sự kiện' . (!empty($bienSoXe) ? " xe {$bienSoXe}" : '') . ' thành công',
            ];
        }

        // =========================================================================
        // XỬ LÝ NHÁNH B: UPDATE HOẶC RESTORE - TÌM BẢN GHI CŨ & DỰ PHÒNG THÔNG TIN
        // =========================================================================
        $log = null;
        $oldMaXe = null;
        if ($eventAction === 'UPDATE' || $eventAction === 'RESTORE') {
            // 1. Tìm bản ghi cũ theo camera_log_id
            if (!empty($logId)) {
                $log = XeCameraLogs::findOne(['camera_log_id' => $logId]);
            }

            // 2. Fallback tìm theo biển số cũ và thời gian xấp xỉ (+- 300 giây)
            if (!$log && (!empty($oldPlate) || !empty($bienSoXe))) {
                $searchPlate = !empty($oldPlate) ? $oldPlate : $bienSoXe;
                $searchClean = XeCameraLogs::chuanHoaMaXe($searchPlate);
                $query = XeCameraLogs::find()
                    ->where(['or', ['ma_xe' => $searchClean], ['bien_so_xe' => $searchPlate]]);
                if (!empty($thoiGian)) {
                    $timeWindowStart = date('Y-m-d H:i:s', strtotime($thoiGian) - 300);
                    $timeWindowEnd   = date('Y-m-d H:i:s', strtotime($thoiGian) + 300);
                    $query->andWhere(['between', 'thoi_gian', $timeWindowStart, $timeWindowEnd]);
                }
                $log = $query->orderBy(['id' => SORT_DESC])->one();
            }

            // Nếu tìm thấy bản ghi cũ, lưu lại mã xe cũ trước khi ghi đè
            if ($log) {
                $oldMaXe = $log->ma_xe;
                if (empty($maCamera)) {
                    $maCamera = $log->camera;
                }
                if (empty($bienSoXe)) {
                    $bienSoXe = $log->bien_so_xe;
                    $maXe = $log->ma_xe;
                }
                if (empty($suKien)) {
                    $suKien = $log->su_kien;
                }
                if (empty($thoiGian)) {
                    $thoiGian = $log->thoi_gian;
                }
            }
        }

        $errors = [];

        // Kiểm tra tham số bắt buộc
        if (empty($maCamera)) {
            $errors['camera_code'] = 'Thiếu tham số mã camera (camera_code hoặc ma_camera).';
        }
        if (empty($bienSoXe)) {
            $errors['plate_number'] = 'Thiếu tham số biển số xe (plate_number hoặc bien_so_xe).';
        }
        if (empty($suKien)) {
            $errors['vehicle_view'] = 'Thiếu tham số góc chụp / sự kiện (vehicle_view hoặc su_kien).';
        }
        if (empty($thoiGian)) {
            $errors['detected_at'] = 'Thiếu tham số thời gian (detected_at hoặc thoi_gian).';
        }

        // Kiểm tra camera_code (chỉ chấp nhận các camera hợp lệ của ứng dụng)
        $validCameras = array_keys(XeCameraLogs::getDmCamera());
        if (!empty($maCamera) && !in_array($maCamera, $validCameras, true)) {
            $errors['camera_code'] = "Mã camera_code '{$maCamera}' không đúng. Chỉ chấp nhận camera của ứng dụng: " . implode(', ', [
                XeCameraLogs::CAMERA_CONG_CAN_TIN,
                XeCameraLogs::CAMERA_CONG_SAN_CAM_BIEN,
                XeCameraLogs::CAMERA_CONG_SAN_CAM_BIEN_VAO,
                XeCameraLogs::CAMERA_CONG_SAN_CAM_BIEN_RA,
            ]) . '.';
        }

        if (empty($maXe)) {
            $errors['plate_number'] = 'Biển số xe không hợp lệ sau khi loại bỏ ký tự đặc biệt.';
        }

        // Kiểm tra su_kien (chỉ mat_truoc hoặc mat_sau)
        $validSuKien = array_keys(XeCameraLogs::getDmSuKien());
        if (!empty($suKien) && !in_array($suKien, $validSuKien, true)) {
            $errors['vehicle_view'] = "Góc chụp / Sự kiện '{$suKien}' không đúng. Chỉ chấp nhận: " . implode(' hoặc ', $validSuKien) . " (hoặc 'front', 'rear').";
        }

        // Kiểm tra định dạng thoi_gian Y-m-d H:i:s
        if (!empty($thoiGian)) {
            $thoiGianTrim = trim((string)$thoiGian);
            $dt = \DateTime::createFromFormat('Y-m-d H:i:s', $thoiGianTrim);
            if (!$dt || $dt->format('Y-m-d H:i:s') !== $thoiGianTrim) {
                $errors['detected_at'] = "Thời gian '{$thoiGian}' không đúng định dạng 'Y-m-d H:i:s' (ví dụ: " . date('Y-m-d H:i:s') . ").";
            } else {
                $thoiGian = $thoiGianTrim;
            }
        }

        // Nếu có lỗi xác thực, trả về HTTP 422
        if (!empty($errors)) {
            Yii::$app->response->statusCode = 422;
            return [
                'success' => false,
                'status' => 'error',
                'message' => 'Dữ liệu không hợp lệ.',
                'errors' => $errors,
            ];
        }

        // Nếu là CREATE (hoặc UPDATE/RESTORE nhưng không tìm thấy bản ghi cũ)
        if (!$log) {
            // Tránh trùng lặp nếu sự kiện CREATE bị gửi lại cùng log_id
            if (!empty($logId)) {
                $log = XeCameraLogs::findOne(['camera_log_id' => $logId]);
                if ($log) {
                    $oldMaXe = $log->ma_xe;
                }
            }
            if (!$log) {
                $log = new XeCameraLogs();
                $log->camera_log_id = $logId;
            }
        }

        // Cập nhật các trường thông tin mới nhất
        if (!empty($logId) && empty($log->camera_log_id)) {
            $log->camera_log_id = $logId;
        }
        $log->camera = (string)$maCamera;
        $log->bien_so_xe = trim((string)$bienSoXe);
        $log->ma_xe = $maXe;
        $log->su_kien = (string)$suKien;
        $log->thoi_gian = $thoiGian;

        // Đối với CREATE, UPDATE hoặc RESTORE: đảm bảo cờ xóa mềm được gỡ bỏ
        if ($log->hasAttribute('is_deleted')) {
            $log->is_deleted = XeCameraLogs::STATUS_ACTIVE;
            $log->deleted_at = null;
            $log->deleted_by = null;
        }

        if ($log->save()) {
            Yii::$app->response->statusCode = 200;

            // Kiểm tra xe nội bộ trước
            $bienSoXeClean = $log->ma_xe;
            $ptxXe = PtxXe::find()
                ->where(['ma_bien_so' => $bienSoXeClean])
                ->orWhere(['REPLACE(REPLACE(REPLACE(ma_bien_so, ".", ""), "-", ""), " ", "")' => $bienSoXeClean])
                ->orWhere(['REPLACE(REPLACE(REPLACE(bien_so_xe, ".", ""), "-", ""), " ", "")' => $bienSoXeClean])
                ->one();
            $isNoiBo = ($ptxXe !== null);

            // Xác định cổng kiểm soát và chiều di chuyển (RA / VAO)
            $congVaChieu = XeCameraLogs::xacDinhCongVaChieu($log->camera, $log->su_kien, $isNoiBo);
            $cong = $congVaChieu['cong'];
            $chieu = $congVaChieu['chieu'];
            $maXe = $log->ma_xe;
            $xe = $ptxXe;

            $coKeHoach = false;
            $diKhongKeHoach = false;
            $lichThueInfo = null;

            // =========================================================================
            // PHÂN NHÁNH THEO CỔNG KIỂM SOÁT
            // =========================================================================
            if ($cong === XeCameraLogs::CONG_SAN_CAM_BIEN) {
                // =========================================================================
                // 1. CỔNG SÂN CẢM BIẾN (Kiểm tra lịch thuê xe trong ptx_lich_thue khi xe VÀO)
                // =========================================================================
                $checkLichThue = XeCameraTripService::kiemTraLichThueXe($log->ma_xe, $log->thoi_gian);
                $isNoiBo = $checkLichThue['thuoc_danh_sach_xe'];
                $xe = $checkLichThue['xe'];
                $lichThue = $checkLichThue['lich_thue'];
                $coKeHoach = $checkLichThue['co_ke_hoach'];
                $diKhongKeHoach = $checkLichThue['di_khong_ke_hoach'];

                if ($lichThue) {
                    $lichThueInfo = [
                        'id' => $lichThue->id,
                        'thoi_gian_bat_dau' => $lichThue->thoi_gian_bat_dau,
                        'thoi_gian_ket_thuc' => $lichThue->thoi_gian_ket_thuc,
                        'trang_thai' => $lichThue->trang_thai,
                        'so_gio' => $lichThue->so_gio,
                    ];
                }

                if ($isNoiBo) {
                    if ($chieu === 'VAO') {
                        // Xe nội bộ VÀO SÂN CẢM BIẾN -> Kiểm tra có lịch thuê xe trong ptx_lich_thue hay không
                        if ($coKeHoach) {
                            $actionStatus = 'APPROVED';
                            $vehicleClassification = 'INTERNAL_VALID';
                            $alertLevel = 'normal';
                            $summary = ($eventAction === 'RESTORE') ? 'Xe vào sân có lịch thuê (Đã khôi phục)' : 'Xe vào sân có lịch thuê hợp lệ';
                            $message = "Xe {$maXe} vào sân đúng lịch thuê";
                            $voiceMessage = "Xe {$maXe} vào sân đúng lịch";
                            $webhookResultBool = false;
                        } else {
                            $actionStatus = 'UNPLANNED';
                            $vehicleClassification = 'INTERNAL_UNPLANNED';
                            $alertLevel = 'danger';
                            $summary = ($eventAction === 'RESTORE') ? 'Xe vào sân không có lịch thuê (Đã khôi phục)' : 'Xe vào sân không có lịch thuê';
                            $message = "Xe {$maXe} vào sân không có lịch thuê";
                            $voiceMessage = "Cảnh báo xe {$maXe} vào sân không có lịch thuê";
                            $webhookResultBool = true;
                        }
                    } else {
                        // Xe nội bộ RỜI SÂN CẢM BIẾN (Làn Ra)
                        $actionStatus = 'APPROVED';
                        $vehicleClassification = 'INTERNAL_VALID';
                        $alertLevel = 'normal';
                        $summary = ($eventAction === 'RESTORE') ? 'Xe rời sân cảm biến (Đã khôi phục)' : 'Xe rời sân cảm biến';
                        $message = "Xe {$maXe} rời sân cảm biến";
                        $voiceMessage = "Xe {$maXe} rời sân";
                        $webhookResultBool = false;
                        $diKhongKeHoach = false;
                    }
                } else {
                    if ($chieu === 'VAO') {
                        $actionStatus = 'INFO';
                        $vehicleClassification = 'EXTERNAL_UNKNOWN';
                        $alertLevel = 'warning';
                        $summary = ($eventAction === 'RESTORE') ? 'Xe lạ vào sân cảm biến (Đã khôi phục)' : 'Xe lạ vào sân cảm biến';
                        $message = "Xe lạ {$maXe} vào sân cảm biến";
                        $voiceMessage = "Xe lạ vào sân cảm biến - {$maXe}";
                        $webhookResultBool = false;
                    } else {
                        $actionStatus = 'INFO';
                        $vehicleClassification = 'EXTERNAL_UNKNOWN';
                        $alertLevel = 'normal';
                        $summary = ($eventAction === 'RESTORE') ? 'Xe ngoài rời sân cảm biến (Đã khôi phục)' : 'Xe ngoài rời sân cảm biến';
                        $message = "Xe ngoài {$maXe} rời sân cảm biến";
                        $voiceMessage = "Xe ngoài {$maXe} rời sân";
                        $webhookResultBool = false;
                    }
                }
            } else {
                // =========================================================================
                // 2. CỔNG CĂN TIN (Kiểm tra kế hoạch giảng dạy trong gd_tiet_hoc khi xe ĐI RA)
                // =========================================================================
                $checkKeHoach = $this->kiemTraKeHoachXe($log->ma_xe, $log->thoi_gian);
                $xe = $checkKeHoach['xe'];
                $isNoiBo = $checkKeHoach['thuoc_danh_sach_xe'];
                $coKeHoach = $checkKeHoach['co_ke_hoach'];
                $diKhongKeHoach = $checkKeHoach['di_khong_ke_hoach'];

                if ($isNoiBo) {
                    if ($chieu === 'RA') {
                        // Kịch bản 1: Xe nội bộ ĐI RA - BẮT BUỘC CHECK KẾ HOẠCH
                        if ($coKeHoach) {
                            $actionStatus = 'APPROVED';
                            $vehicleClassification = 'INTERNAL_VALID';
                            $alertLevel = 'normal';
                            $summary = ($eventAction === 'RESTORE') ? 'Xe có kế hoạch hợp lệ (Đã khôi phục)' : 'Xe có kế hoạch hợp lệ';
                            $message = "Xe {$maXe} hợp lệ";
                            $voiceMessage = "Xe {$maXe} đi có kế hoạch";
                            $webhookResultBool = false;
                        } else {
                            $actionStatus = 'UNPLANNED';
                            $vehicleClassification = 'INTERNAL_UNPLANNED';
                            $alertLevel = 'danger';
                            $summary = ($eventAction === 'RESTORE') ? 'Xe đi không lập kế hoạch (Đã khôi phục)' : 'Xe đi không lập kế hoạch';
                            $message = "Xe {$maXe} không lập kế hoạch";
                            $voiceMessage = "Xe đi không lập kế hoạch - {$maXe}";
                            $webhookResultBool = true;
                        }
                    } else {
                        // Kịch bản 2: Xe nội bộ VỀ BÃI - KHÔNG CHECK KẾ HOẠCH NỮA
                        $actionStatus = 'APPROVED';
                        $vehicleClassification = 'INTERNAL_VALID';
                        $alertLevel = 'normal';
                        $summary = ($eventAction === 'RESTORE') ? 'Xe nội bộ về bãi (Đã khôi phục)' : 'Xe nội bộ về bãi';
                        $message = "Xe {$maXe} về bãi";
                        $voiceMessage = "Xe {$maXe} về bãi";
                        $webhookResultBool = false;
                        $diKhongKeHoach = false;
                    }
                } else {
                    if ($chieu === 'VAO') {
                        // Kịch bản 3: Xe lạ VÀO SÂN - KHÔNG CHECK KẾ HOẠCH NỘI BỘ
                        $actionStatus = 'INFO';
                        $vehicleClassification = 'EXTERNAL_UNKNOWN';
                        $alertLevel = 'warning';
                        $summary = ($eventAction === 'RESTORE') ? 'Xe lạ vào khu vực sân (Đã khôi phục)' : 'Xe lạ vào khu vực sân';
                        $message = "Xe lạ {$maXe} vào khu vực sân";
                        $voiceMessage = "Xe lạ vào khu vực sân - {$maXe}";
                        $webhookResultBool = false;
                    } else {
                        // Kịch bản 4: Xe ngoài RỜI SÂN - KHÔNG CHECK KẾ HOẠCH NỘI BỘ
                        $actionStatus = 'INFO';
                        $vehicleClassification = 'EXTERNAL_UNKNOWN';
                        $alertLevel = 'normal';
                        $summary = ($eventAction === 'RESTORE') ? 'Xe ngoài rời sân (Đã khôi phục)' : 'Xe ngoài rời sân';
                        $message = "Xe ngoài {$maXe} rời sân";
                        $voiceMessage = "Xe ngoài {$maXe} rời sân";
                        $webhookResultBool = false;
                    }
                }
            }

            // Cập nhật trạng thái kế hoạch vào log nếu có cột
            if ($log->hasAttribute('trang_thai_ke_hoach')) {
                $log->trang_thai_ke_hoach = $actionStatus;
                $log->save(false);
            }

            // Tự động re-sync các block chuyến đi - về trong bảng ptx_xe_luot_ra_vao cho xe hiện tại
            XeCameraTripService::syncVehicleTrips($log->ma_xe);

            // Nếu là UPDATE có đổi biển số: re-sync lại cho cả xe có biển số cũ
            if (!empty($oldMaXe) && $oldMaXe !== $log->ma_xe) {
                XeCameraTripService::syncVehicleTrips($oldMaXe);
            }
            if ($eventAction === 'UPDATE' && !empty($oldPlate)) {
                $oldClean = XeCameraLogs::chuanHoaMaXe($oldPlate);
                if (!empty($oldClean) && $oldClean !== $log->ma_xe && $oldClean !== $oldMaXe) {
                    XeCameraTripService::syncVehicleTrips($oldClean);
                }
            }

            return [
                'success' => true,
                'status' => 'success',
                'action_status' => $actionStatus,
                'vehicle_classification' => $vehicleClassification,
                'alert_level' => $alertLevel,
                'summary' => $summary,
                'message' => $message,
                'voice_message' => $voiceMessage,
                'barrier_action' => 'NONE',
                'webhook_result_bool' => $webhookResultBool,
                'data' => [
                    'id' => $log->id,
                    'camera_log_id' => $log->camera_log_id,
                    'is_deleted' => $log->hasAttribute('is_deleted') ? (int)$log->is_deleted : 0,
                    'camera' => $log->camera,
                    'camera_label' => $log->getCameraLabel(),
                    'cong' => $cong,
                    'chieu' => $chieu,
                    'su_kien' => $log->su_kien,
                    'su_kien_label' => $log->getSuKienLabel(),
                    'bien_so_xe' => $log->bien_so_xe,
                    'ma_xe' => $log->ma_xe,
                    'thoi_gian' => $log->thoi_gian,
                    'thoi_gian_tao' => $log->thoi_gian_tao,
                    'id_xe' => $xe ? $xe->id : ($log->xe ? $log->xe->id : null),
                    'thuoc_danh_sach_xe' => $isNoiBo,
                    'co_ke_hoach' => $coKeHoach,
                    'di_khong_ke_hoach' => $diKhongKeHoach,
                    'rental_schedule' => $lichThueInfo,
                ],
            ];
        } else {
            Yii::$app->response->statusCode = 500;
            return [
                'success' => false,
                'status' => 'error',
                'message' => 'Không thể lưu log camera vào CSDL.',
                'errors' => $log->getErrors(),
            ];
        }
    }
}
