<?php

namespace app\modules\thuexe\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use app\modules\thuexe\models\XeLuotRaVao;
use app\modules\thuexe\models\search\XeLuotRaVaoSearch;
use app\modules\thuexe\models\XeCameraLogs;
use app\modules\thuexe\models\search\XeCameraLogsSearch;
use app\modules\thuexe\services\XeCameraTripService;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use app\modules\user\models\User;

/**
 * XeCameraLogsController implements actions for viewing and managing camera trips & logs.
 */
class XeCameraLogsController extends Controller
{
    public $freeAccessActions = [
        'export-excel',
        'print-report',
    ];

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'ghost-access' => [
                'class' => 'webvimark\modules\UserManagement\components\GhostAccessControl',
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete-trip' => ['POST'],
                    'delete-log' => ['POST'],
                    'restore-log' => ['POST'],
                    'rebuild-trips' => ['POST', 'GET'],
                ],
            ],
        ];
    }

    /**
     * Lists all XeLuotRaVao trips and XeCameraLogs.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchTripModel = new XeLuotRaVaoSearch();
        $dataTripProvider = $searchTripModel->search(Yii::$app->request->queryParams);

        $searchLogModel = new XeCameraLogsSearch();
        $dataLogProvider = $searchLogModel->search(Yii::$app->request->queryParams);

        $activeTab = Yii::$app->request->get('tab', 'trips');

        return $this->render('index', [
            'searchTripModel' => $searchTripModel,
            'dataTripProvider' => $dataTripProvider,
            'searchLogModel' => $searchLogModel,
            'dataLogProvider' => $dataLogProvider,
            'activeTab' => $activeTab,
        ]);
    }

    /**
     * Chức năng "Làm lại dữ liệu": Quét lại toàn bộ logs và tái tạo các block chuyến đi - về
     * @return mixed
     */
    public function actionRebuildTrips()
    {
        $request = Yii::$app->request;
        $tuNgay = $request->get('tu_ngay');
        $denNgay = $request->get('den_ngay');

        $result = XeCameraTripService::rebuildAllTrips($tuNgay, $denNgay);

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'forceReload' => '#myGridTrips',
                'title' => 'Kết quả đồng bộ',
                'content' => '<div class="alert alert-success"><i class="fa fa-check-circle me-1"></i> ' . Html::encode($result['message']) . '</div>',
                'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => 'modal'])
            ];
        }

        Yii::$app->session->setFlash('success', $result['message']);
        return $this->redirect(['index', 'tab' => 'trips']);
    }

    /**
     * Xem chi tiết một lượt đi - về
     * @param int $id
     * @return mixed
     */
    public function actionViewTrip($id)
    {
        $request = Yii::$app->request;
        $model = $this->findTripModel($id);

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => "Chi tiết lượt xe #" . $model->id . " (" . $model->bien_so_xe . ")",
                'content' => $this->renderAjax('view_trip', [
                    'model' => $model,
                ]),
                'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => 'modal']) .
                    Html::a('Sửa đính chính', ['update-trip', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
            ];
        }

        return $this->render('view_trip', [
            'model' => $model,
        ]);
    }

    /**
     * Sửa đính chính một block chuyến đi - về
     * @param int $id
     * @return mixed
     */
    public function actionUpdateTrip($id)
    {
        $request = Yii::$app->request;
        $model = $this->findTripModel($id);

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Sửa đính chính lượt xe #" . $model->id,
                    'content' => $this->renderAjax('_form_trip', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => 'modal']) .
                        Html::button('Lưu lại', ['class' => 'btn btn-primary', 'type' => 'submit'])
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => '#myGridTrips',
                    'title' => "Lượt xe #" . $model->id,
                    'content' => $this->renderAjax('view_trip', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => 'modal']) .
                        Html::a('Sửa đính chính', ['update-trip', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => "Sửa đính chính lượt xe #" . $model->id,
                    'content' => $this->renderAjax('_form_trip', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => 'modal']) .
                        Html::button('Lưu lại', ['class' => 'btn btn-primary', 'type' => 'submit'])
                ];
            }
        }

        if ($model->load($request->post()) && $model->save()) {
            return $this->redirect(['view-trip', 'id' => $model->id]);
        }

        return $this->render('_form_trip', [
            'model' => $model,
        ]);
    }

    /**
     * Xóa mềm một lượt xe
     * @param int $id
     * @return mixed
     */
    public function actionDeleteTrip($id)
    {
        $request = Yii::$app->request;
        $model = $this->findTripModel($id);
        $model->is_deleted = XeLuotRaVao::STATUS_DELETED;
        $model->save(false);

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose' => true, 'forceReload' => '#myGridTrips'];
        }

        return $this->redirect(['index', 'tab' => 'trips']);
    }

    /**
     * Xem chi tiết một log camera
     * @param int $id
     * @return mixed
     */
    public function actionViewLog($id)
    {
        $request = Yii::$app->request;
        $model = $this->findLogModel($id);

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => "Chi tiết Log Camera #" . $model->id . " (" . $model->bien_so_xe . ")",
                'content' => $this->renderAjax('view_log', [
                    'model' => $model,
                ]),
                'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => 'modal'])
            ];
        }

        return $this->render('view_log', [
            'model' => $model,
        ]);
    }

    /**
     * Xóa mềm một log camera
     * @param int $id
     * @return mixed
     */
    public function actionDeleteLog($id)
    {
        $request = Yii::$app->request;
        $model = $this->findLogModel($id);
        $model->is_deleted = XeCameraLogs::STATUS_DELETED;
        $model->deleted_at = date('Y-m-d H:i:s');
        $model->deleted_by = Yii::$app->user->identity->username ?? 'admin';
        $model->save(false);

        // Tự động re-sync lại block chuyến cho xe này
        XeCameraTripService::syncVehicleTrips($model->ma_xe);

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose' => true, 'forceReload' => '#myGridLogs'];
        }

        return $this->redirect(['index', 'tab' => 'logs']);
    }

    /**
     * Khôi phục một log camera từ thùng rác
     * @param int $id
     * @return mixed
     */
    public function actionRestoreLog($id)
    {
        $request = Yii::$app->request;
        $model = $this->findLogModel($id);
        $model->is_deleted = XeCameraLogs::STATUS_ACTIVE;
        $model->deleted_at = null;
        $model->deleted_by = null;
        $model->save(false);

        // Tự động re-sync lại block chuyến cho xe này
        XeCameraTripService::syncVehicleTrips($model->ma_xe);

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose' => true, 'forceReload' => '#myGridLogs'];
        }

        return $this->redirect(['index', 'tab' => 'logs']);
    }

    /**
     * Finds the XeLuotRaVao model based on its primary key value.
     * @param int $id
     * @return XeLuotRaVao
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findTripModel($id)
    {
        if (($model = XeLuotRaVao::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Không tìm thấy lượt xe yêu cầu.');
    }

    /**
     * Finds the XeCameraLogs model based on its primary key value.
     * @param int $id
     * @return XeCameraLogs
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findLogModel($id)
    {
        if (($model = XeCameraLogs::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Không tìm thấy nhật ký camera yêu cầu.');
    }

    /**
     * Lọc theo khu vực cổng kiểm soát (cong_can_tin vs cong_san_cam_bien)
     * 
     * @param \yii\db\ActiveQuery $query
     * @param string $khuVucCong
     * @return \yii\db\ActiveQuery
     */
    protected function applyGateFilter($query, $khuVucCong = 'cong_can_tin')
    {
        if ($khuVucCong === 'cong_san_cam_bien') {
            return $query->andWhere([
                'or',
                ['like', 'camera_di', 'cong_san_cam_bien'],
                ['like', 'camera_ve', 'cong_san_cam_bien'],
            ]);
        }

        // Mặc định hoặc cong_can_tin: bao gồm 'cong_can_tin', 'cong_cantin', và các bản ghi cũ chưa có thông tin cổng (null)
        return $query->andWhere([
            'or',
            ['camera_di' => ['cong_can_tin', 'cong_cantin']],
            ['camera_ve' => ['cong_can_tin', 'cong_cantin']],
            ['and', ['camera_di' => null], ['camera_ve' => null]],
        ]);
    }

    /**
     * Báo cáo in kết nối trực tiếp Print Preview (chỉ in phần tổng hợp kết quả vi phạm theo lần)
     * Tham khảo kiến trúc tại /demxe/cong-can-tin/bc-vi-pham
     * @return \yii\web\Response
     */
    public function actionPrintReport()
    {
        $request = Yii::$app->request;
        $loaiBaoCao = $request->get('loai_bao_cao', 'XE_KHONG_KE_HOACH');
        $tuNgay = $request->get('tu_ngay', date('Y-m-01'));
        $denNgay = $request->get('den_ngay', date('Y-m-d'));
        $khuVucCong = $request->get('khu_vuc_cong', 'cong_can_tin');
        $tenKhuVucDisplay = ($khuVucCong === 'cong_san_cam_bien') ? 'CỔNG SÂN CẢM BIẾN' : 'CỔNG CĂN TIN';

        if (empty($tuNgay)) {
            $tuNgay = date('Y-m-01');
        }
        if (empty($denNgay)) {
            $denNgay = date('Y-m-d');
        }

        $startDateTime = $tuNgay . ' 00:00:00';
        $endDateTime = $denNgay . ' 23:59:59';

        $tuNgayDisplay = date('d/m/Y', strtotime($tuNgay));
        $denNgayDisplay = date('d/m/Y', strtotime($denNgay));

        $query = XeLuotRaVao::find()
            ->where(['is_deleted' => XeLuotRaVao::STATUS_ACTIVE]);

        // Lọc theo cổng kiểm soát
        $this->applyGateFilter($query, $khuVucCong);

        switch ($loaiBaoCao) {
            case 'XE_QUA_DEM':
                $titleBaoCao = 'BÁO CÁO PHƯƠNG TIỆN LƯU LẠI QUA ĐÊM';
                $query->andWhere(['qua_dem' => XeLuotRaVao::QUA_DEM_CO])
                    ->andWhere([
                        'or',
                        ['between', 'thoi_gian_di', $startDateTime, $endDateTime],
                        ['between', 'thoi_gian_ve', $startDateTime, $endDateTime],
                    ])
                    ->orderBy(['bien_so_xe' => SORT_ASC, 'thoi_gian_di' => SORT_ASC, 'id' => SORT_ASC]);
                break;

            case 'XE_LA':
                $titleBaoCao = 'BÁO CÁO XE KHÁCH NGOÀI / VÃNG LAI VÀO SÂN';
                $query->andWhere(['loai_xe' => XeLuotRaVao::LOAI_XE_NGOAI])
                    ->andWhere([
                        'or',
                        ['between', 'thoi_gian_di', $startDateTime, $endDateTime],
                        ['between', 'thoi_gian_ve', $startDateTime, $endDateTime],
                    ])
                    ->orderBy(['bien_so_xe' => SORT_ASC, 'thoi_gian_di' => SORT_ASC, 'id' => SORT_ASC]);
                break;

            case 'TAT_CA':
                $titleBaoCao = 'BÁO CÁO TỔNG HỢP TOÀN BỘ PHƯƠNG TIỆN VI PHẠM';
                $query->andWhere([
                    'or',
                    ['trang_thai_ke_hoach' => XeLuotRaVao::KE_HOACH_UNPLANNED],
                    ['qua_dem' => XeLuotRaVao::QUA_DEM_CO]
                ])
                ->andWhere([
                    'or',
                    ['between', 'thoi_gian_di', $startDateTime, $endDateTime],
                    ['between', 'thoi_gian_ve', $startDateTime, $endDateTime],
                ])
                ->orderBy(['bien_so_xe' => SORT_ASC, 'thoi_gian_di' => SORT_ASC, 'id' => SORT_ASC]);
                break;

            case 'XE_KHONG_KE_HOACH':
            default:
                $titleBaoCao = 'BÁO CÁO XE NỘI BỘ ĐI KHÔNG LẬP KẾ HOẠCH';
                $query->andWhere(['trang_thai_ke_hoach' => XeLuotRaVao::KE_HOACH_UNPLANNED])
                    ->andWhere(['!=', 'loai_xe', XeLuotRaVao::LOAI_XE_NGOAI])
                    ->andWhere([
                        'or',
                        ['between', 'thoi_gian_di', $startDateTime, $endDateTime],
                        ['and', ['thoi_gian_di' => null], ['between', 'thoi_gian_ve', $startDateTime, $endDateTime]]
                    ])
                    ->orderBy(['bien_so_xe' => SORT_ASC, 'thoi_gian_di' => SORT_ASC, 'id' => SORT_ASC]);
                break;
        }

        $trips = $query->all();

        // Gom nhóm theo xe (chỉ lấy phần tổng hợp kết quả vi phạm theo lần)
        $groupedData = [];
        foreach ($trips as $trip) {
            $bs = $trip->bien_so_xe ?: 'CHUA_RO';
            if (!isset($groupedData[$bs])) {
                $xe = $trip->xe;
                $hieuXe = $xe ? $xe->hieu_xe : '';
                $giaoVien = ($xe && $xe->giaoVien) ? $xe->giaoVien->ho_ten : ($trip->loai_xe === XeLuotRaVao::LOAI_XE_NGOAI ? 'Xe khách vãng lai' : 'Chưa phân công');
                $groupedData[$bs] = [
                    'bien_so' => $bs,
                    'hieu_xe' => $hieuXe,
                    'giao_vien' => $giaoVien,
                    'trips' => [],
                    'tong_phut' => 0,
                    'qua_dem_count' => 0,
                    'unplanned_count' => 0,
                ];
            }
            $groupedData[$bs]['trips'][] = $trip;
            if ($trip->so_phut_o_ngoai > 0) {
                $groupedData[$bs]['tong_phut'] += $trip->so_phut_o_ngoai;
            }
            if ($trip->qua_dem == XeLuotRaVao::QUA_DEM_CO) {
                $groupedData[$bs]['qua_dem_count']++;
            }
            if ($trip->trang_thai_ke_hoach === XeLuotRaVao::KE_HOACH_UNPLANNED) {
                $groupedData[$bs]['unplanned_count']++;
            }
        }

        $content = $this->renderPartial('_report_print', [
            'groupedData' => $groupedData,
            'loaiBaoCao' => $loaiBaoCao,
            'titleBaoCao' => $titleBaoCao,
            'khuVucCong' => $khuVucCong,
            'tenKhuVucDisplay' => $tenKhuVucDisplay,
            'tuNgay' => $tuNgay,
            'denNgay' => $denNgay,
            'tuNgayDisplay' => $tuNgayDisplay,
            'denNgayDisplay' => $denNgayDisplay,
            'startDateTime' => $startDateTime,
            'endDateTime' => $endDateTime,
        ]);

        return $this->asJson([
            'status' => 'success',
            'content' => $content,
        ]);
    }

    /**
     * Xuất file Excel báo cáo theo yêu cầu
     * Các loại báo cáo:
     * - XE_KHONG_KE_HOACH: Xe nội bộ đi không có kế hoạch, gom nhóm theo xe kèm danh sách thời gian đi - về.
     * - XE_QUA_DEM: Phương tiện lưu lại qua đêm (chứa khung giờ 00:00 - 05:00 sáng).
     * - XE_LA: Xe khách ngoài / vãng lai vào sân.
     * - TAT_CA: Tổng hợp toàn bộ lượt xe ra - vào bãi.
     * 
     * @return void
     */
    public function actionExportExcel()
    {
        $request = Yii::$app->request;
        $loaiBaoCao = $request->get('loai_bao_cao', 'XE_KHONG_KE_HOACH');
        $tuNgay = $request->get('tu_ngay', date('Y-m-01'));
        $denNgay = $request->get('den_ngay', date('Y-m-d'));
        $khuVucCong = $request->get('khu_vuc_cong', 'cong_can_tin');
        $tenKhuVucDisplay = ($khuVucCong === 'cong_san_cam_bien') ? 'CỔNG SÂN CẢM BIẾN' : 'CỔNG CĂN TIN';
        $gatePrefix = ($khuVucCong === 'cong_san_cam_bien') ? 'SanCamBien_' : 'CongCanTin_';

        if (empty($tuNgay)) {
            $tuNgay = date('Y-m-01');
        }
        if (empty($denNgay)) {
            $denNgay = date('Y-m-d');
        }

        $startDateTime = $tuNgay . ' 00:00:00';
        $endDateTime = $denNgay . ' 23:59:59';

        $tuNgayDisplay = date('d/m/Y', strtotime($tuNgay));
        $denNgayDisplay = date('d/m/Y', strtotime($denNgay));
        $thoiGianXuat = date('d/m/Y H:i:s');
        $currentUser = User::getCurrentUser();
        $nguoiXuat = ($currentUser && method_exists($currentUser, 'getHoTen')) ? ($currentUser->getHoTen() ?: $currentUser->username) : 'Hệ thống';

        $spreadsheet = new Spreadsheet();

        switch ($loaiBaoCao) {
            case 'XE_QUA_DEM':
                $fileNamePrefix = $gatePrefix . 'BaoCao_Xe_Luu_Lai_Qua_Dem';
                $this->exportXeQuaDem($spreadsheet, $tuNgay, $denNgay, $startDateTime, $endDateTime, $tuNgayDisplay, $denNgayDisplay, $thoiGianXuat, $nguoiXuat, $khuVucCong, $tenKhuVucDisplay);
                break;

            case 'XE_LA':
                $fileNamePrefix = $gatePrefix . 'BaoCao_Xe_Khach_Ngoai_Vao_San';
                $this->exportXeLa($spreadsheet, $tuNgay, $denNgay, $startDateTime, $endDateTime, $tuNgayDisplay, $denNgayDisplay, $thoiGianXuat, $nguoiXuat, $khuVucCong, $tenKhuVucDisplay);
                break;

            case 'TAT_CA':
                $fileNamePrefix = $gatePrefix . 'BaoCao_Tong_Hop_Luot_Xe';
                $this->exportTatCa($spreadsheet, $tuNgay, $denNgay, $startDateTime, $endDateTime, $tuNgayDisplay, $denNgayDisplay, $thoiGianXuat, $nguoiXuat, $khuVucCong, $tenKhuVucDisplay);
                break;

            case 'XE_KHONG_KE_HOACH':
            default:
                $fileNamePrefix = $gatePrefix . 'BaoCao_Xe_Di_Khong_Ke_Hoach';
                $this->exportXeKhongKeHoach($spreadsheet, $tuNgay, $denNgay, $startDateTime, $endDateTime, $tuNgayDisplay, $denNgayDisplay, $thoiGianXuat, $nguoiXuat, $khuVucCong, $tenKhuVucDisplay);
                break;
        }

        $fileName = $fileNamePrefix . '_' . date('Ymd_His') . '.xlsx';

        if (ob_get_length()) {
            ob_end_clean();
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    /**
     * Áp dụng tiêu đề báo cáo chuẩn
     */
    private function applyReportHeader($sheet, $title, $tuNgayDisplay, $denNgayDisplay, $thoiGianXuat, $nguoiXuat, $titleColor, $lastCol = 'H')
    {
        $sheet->setCellValue('A1', 'TRUNG TÂM GDNN & SHLX NGUYỄN TRÌNH');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(11)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FF1F4E79'));

        $sheet->setCellValue('A2', 'HỆ THỐNG GIÁM SÁT ANPR - QUẢN LÝ PHƯƠNG TIỆN RA VÀO');
        $sheet->getStyle('A2')->getFont()->setItalic(true)->setSize(9)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FF595959'));

        $sheet->mergeCells("A4:{$lastCol}4");
        $sheet->setCellValue('A4', mb_strtoupper($title, 'UTF-8'));
        $sheet->getStyle('A4')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 15,
                'color' => ['rgb' => $titleColor],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);
        $sheet->getRowDimension(4)->setRowHeight(26);

        $sheet->mergeCells("A5:{$lastCol}5");
        $sheet->setCellValue('A5', "Thời gian thống kê: Từ ngày {$tuNgayDisplay} đến ngày {$denNgayDisplay}");
        $sheet->getStyle('A5')->applyFromArray([
            'font' => [
                'italic' => true,
                'size' => 10.5,
                'color' => ['rgb' => '333333'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        $sheet->mergeCells("A6:{$lastCol}6");
        $sheet->setCellValue('A6', "Thời gian xuất báo cáo: {$thoiGianXuat}  |  Người lập: {$nguoiXuat}");
        $sheet->getStyle('A6')->applyFromArray([
            'font' => [
                'italic' => true,
                'size' => 9.5,
                'color' => ['rgb' => '666666'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);
    }

    /**
     * Định dạng header bảng
     */
    private function applyTableHeader($sheet, $cells, $row, $fillColor = '1F4E79')
    {
        foreach ($cells as $col => $title) {
            $sheet->setCellValue($col . $row, $title);
            $sheet->getStyle($col . $row)->applyFromArray([
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                    'size' => 10,
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => $fillColor],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'wrapText' => true,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'FFFFFF'],
                    ],
                ],
            ]);
        }
        $sheet->getRowDimension($row)->setRowHeight(25);
    }

    /**
     * Kẻ viền ô
     */
    private function applyRangeBorder($sheet, $range, $borderColor = 'D9D9D9')
    {
        $sheet->getStyle($range)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => $borderColor],
                ],
            ],
        ]);
    }

    /**
     * Xuất báo cáo xe không kế hoạch (Gom nhóm theo xe & danh sách thời gian đi - về)
     */
    private function exportXeKhongKeHoach($spreadsheet, $tuNgay, $denNgay, $startDateTime, $endDateTime, $tuNgayDisplay, $denNgayDisplay, $thoiGianXuat, $nguoiXuat, $khuVucCong = 'cong_can_tin', $tenKhuVucDisplay = 'CỔNG CĂN TIN')
    {
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Tong_Hop_Theo_Xe');
        $sheet->setShowGridLines(true);

        $this->applyReportHeader($sheet, 'BÁO CÁO XE NỘI BỘ ĐI KHÔNG LẬP KẾ HOẠCH - ' . $tenKhuVucDisplay, $tuNgayDisplay, $denNgayDisplay, $thoiGianXuat, $nguoiXuat, 'C00000', 'H');

        // BẢNG I: TỔNG HỢP THEO XE
        $sheet->setCellValue('A8', 'I. BẢNG TỔNG HỢP SỐ LƯỢT VI PHẠM THEO XE (' . $tenKhuVucDisplay . ')');
        $sheet->getStyle('A8')->applyFromArray([
            'font' => ['bold' => true, 'size' => 11, 'color' => ['rgb' => '1F4E79']],
        ]);

        $headersI = [
            'A' => 'STT',
            'B' => 'BIỂN SỐ XE',
            'C' => 'HIỆU XE / DÒNG XE',
            'D' => 'GIÁO VIÊN PHỤ TRÁCH',
            'E' => 'TỔNG SỐ LƯỢT ĐI',
            'F' => 'TỔNG THỜI GIAN NGOÀI',
            'G' => 'SỐ LẦN QUA ĐÊM',
            'H' => 'GHI CHÚ / ĐÁNH GIÁ',
        ];
        $this->applyTableHeader($sheet, $headersI, 9, 'C00000');

        $query = XeLuotRaVao::find()
            ->where(['is_deleted' => XeLuotRaVao::STATUS_ACTIVE])
            ->andWhere(['trang_thai_ke_hoach' => XeLuotRaVao::KE_HOACH_UNPLANNED])
            ->andWhere(['!=', 'loai_xe', XeLuotRaVao::LOAI_XE_NGOAI])
            ->andWhere([
                'or',
                ['between', 'thoi_gian_di', $startDateTime, $endDateTime],
                ['and', ['thoi_gian_di' => null], ['between', 'thoi_gian_ve', $startDateTime, $endDateTime]]
            ]);

        $this->applyGateFilter($query, $khuVucCong);

        $trips = $query->orderBy(['bien_so_xe' => SORT_ASC, 'thoi_gian_di' => SORT_ASC, 'id' => SORT_ASC])
            ->all();

        $groupedByVehicle = [];
        foreach ($trips as $trip) {
            $bs = $trip->bien_so_xe ?: 'CHUA_RO';
            if (!isset($groupedByVehicle[$bs])) {
                $xe = $trip->xe;
                $hieuXe = $xe ? $xe->hieu_xe : '';
                $giaoVien = ($xe && $xe->giaoVien) ? $xe->giaoVien->ho_ten : '';
                $groupedByVehicle[$bs] = [
                    'bien_so' => $bs,
                    'hieu_xe' => $hieuXe,
                    'giao_vien' => $giaoVien,
                    'trips' => [],
                    'tong_phut' => 0,
                ];
            }
            $groupedByVehicle[$bs]['trips'][] = $trip;
            if ($trip->so_phut_o_ngoai > 0) {
                $groupedByVehicle[$bs]['tong_phut'] += $trip->so_phut_o_ngoai;
            }
        }

        $row = 10;
        if (empty($groupedByVehicle)) {
            $sheet->mergeCells("A10:H10");
            $sheet->setCellValue("A10", "Không tìm thấy dữ liệu xe nội bộ đi không có kế hoạch trong khoảng thời gian này.");
            $sheet->getStyle("A10")->applyFromArray([
                'font' => ['italic' => true, 'color' => ['rgb' => '666666']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ]);
            $this->applyRangeBorder($sheet, "A10:H10");
            $row = 11;
        } else {
            $stt = 1;
            $grandTotalTrips = 0;
            $grandTotalPhut = 0;
            $grandTotalQuaDem = 0;

            foreach ($groupedByVehicle as $bs => $v) {
                $tripCount = count($v['trips']);
                $quaDemCount = count(array_filter($v['trips'], function($t) { return $t->qua_dem == 1; }));
                $grandTotalTrips += $tripCount;
                $grandTotalPhut += $v['tong_phut'];
                $grandTotalQuaDem += $quaDemCount;

                $danhGia = $tripCount >= 3 ? 'Cần nhắc nhở (≥ 3 lần)' : ($tripCount >= 2 ? 'Vi phạm 2 lần' : 'Vi phạm 1 lần');

                $sheet->setCellValue('A' . $row, $stt++);
                $sheet->setCellValue('B' . $row, $v['bien_so']);
                $sheet->setCellValue('C' . $row, $v['hieu_xe'] ?: '-');
                $sheet->setCellValue('D' . $row, $v['giao_vien'] ?: 'Chưa phân công');
                $sheet->setCellValue('E' . $row, $tripCount);
                $sheet->setCellValue('F' . $row, XeLuotRaVao::formatPhutToLabel($v['tong_phut']));
                $sheet->setCellValue('G' . $row, $quaDemCount);
                $sheet->setCellValue('H' . $row, $danhGia);

                $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('B' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('B' . $row)->getFont()->setBold(true);
                $sheet->getStyle('E' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('F' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('G' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $this->applyRangeBorder($sheet, "A{$row}:H{$row}");
                $row++;
            }

            // Dòng tổng cộng
            $sheet->mergeCells("A{$row}:D{$row}");
            $sheet->setCellValue("A{$row}", "TỔNG CỘNG:");
            $sheet->setCellValue("E{$row}", $grandTotalTrips);
            $sheet->setCellValue("F{$row}", XeLuotRaVao::formatPhutToLabel($grandTotalPhut));
            $sheet->setCellValue("G{$row}", $grandTotalQuaDem);
            $sheet->setCellValue("H{$row}", "");

            $sheet->getStyle("A{$row}:H{$row}")->applyFromArray([
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'F2F2F2'],
                ],
            ]);
            $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("E{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("F{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("G{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $this->applyRangeBorder($sheet, "A{$row}:H{$row}");
            $row++;
        }

        // BẢNG II: CHI TIẾT THEO TỪNG XE
        if (!empty($groupedByVehicle)) {
            $row += 2;
            $sheet->mergeCells("A{$row}:H{$row}");
            $sheet->setCellValue("A{$row}", "II. CHI TIẾT DANH SÁCH LƯỢT ĐI - VỀ THEO TỪNG XE");
            $sheet->getStyle("A{$row}")->applyFromArray([
                'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => '1F4E79']],
            ]);
            $sheet->getRowDimension($row)->setRowHeight(24);
            $row++;

            foreach ($groupedByVehicle as $bs => $v) {
                $tripCount = count($v['trips']);

                // Banner xe
                $sheet->mergeCells("A{$row}:H{$row}");
                $bannerText = "► BIỂN SỐ: " . $v['bien_so'] . ($v['hieu_xe'] ? " (" . $v['hieu_xe'] . ")" : "")
                    . "   |   GIÁO VIÊN: " . ($v['giao_vien'] ?: 'Chưa phân công')
                    . "   |   TỔNG CỘNG: {$tripCount} LƯỢT VI PHẠM"
                    . "   |   TỔNG THỜI GIAN NGOÀI: " . XeLuotRaVao::formatPhutToLabel($v['tong_phut']);
                $sheet->setCellValue("A{$row}", $bannerText);
                $sheet->getStyle("A{$row}")->applyFromArray([
                    'font' => ['bold' => true, 'size' => 10, 'color' => ['rgb' => '1F4E79']],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'D9E1F2'],
                    ],
                    'alignment' => [
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'indent' => 1,
                    ],
                ]);
                $sheet->getRowDimension($row)->setRowHeight(24);
                $this->applyRangeBorder($sheet, "A{$row}:H{$row}", "B4C6E7");
                $row++;

                // Sub-header
                $subHeaders = [
                    'A' => 'Lượt',
                    'B' => 'Thời gian đi (Mặt trước)',
                    'C' => 'Cổng xuất phát',
                    'D' => 'Thời gian về (Mặt sau)',
                    'E' => 'Cổng kết thúc',
                    'F' => 'Thời gian ở ngoài',
                    'G' => 'Lưu qua đêm',
                    'H' => 'Trạng thái chuyến đi',
                ];
                $this->applyTableHeader($sheet, $subHeaders, $row, '41719C');
                $row++;

                // Trip rows
                $idx = 1;
                $tripStart = $row;
                foreach ($v['trips'] as $trip) {
                    $tgDi = $trip->thoi_gian_di ? date('d/m/Y H:i:s', strtotime($trip->thoi_gian_di)) : 'N/A';
                    $tgVe = $trip->thoi_gian_ve ? date('d/m/Y H:i:s', strtotime($trip->thoi_gian_ve)) : 'Chưa ghi nhận';
                    $cgDi = $trip->camera_di ?: 'Mặt trước';
                    $cgVe = $trip->camera_ve ?: 'Mặt sau';
                    $tgNgoai = XeLuotRaVao::formatPhutToLabel($trip->so_phut_o_ngoai);
                    $isQuaDem = $trip->qua_dem == 1 ? 'CÓ QUA ĐÊM' : 'Không';
                    $trangThai = $trip->getTrangThaiLabel();

                    $sheet->setCellValue('A' . $row, $idx++);
                    $sheet->setCellValue('B' . $row, $tgDi);
                    $sheet->setCellValue('C' . $row, $cgDi);
                    $sheet->setCellValue('D' . $row, $tgVe);
                    $sheet->setCellValue('E' . $row, $cgVe);
                    $sheet->setCellValue('F' . $row, $tgNgoai);
                    $sheet->setCellValue('G' . $row, $isQuaDem);
                    $sheet->setCellValue('H' . $row, $trangThai);

                    $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('B' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('C' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('D' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('E' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('F' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('G' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('H' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                    if ($trip->qua_dem == 1) {
                        $sheet->getStyle('G' . $row)->getFont()->setBold(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FF7030A0'));
                    }

                    $row++;
                }
                $this->applyRangeBorder($sheet, "A{$tripStart}:H" . ($row - 1));
                $row++; // Cách dòng
            }
        }

        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // SHEET 2: DỮ LIỆU CHI TIẾT DẠNG BẢNG PHẲNG
        $sheet2 = $spreadsheet->createSheet();
        $sheet2->setTitle('Du_Lieu_Chi_Tiet');
        $sheet2->setShowGridLines(true);
        $this->applyReportHeader($sheet2, 'DANH SÁCH CHI TIẾT TỪNG CHUYẾN ĐI KHÔNG KẾ HOẠCH - ' . $tenKhuVucDisplay, $tuNgayDisplay, $denNgayDisplay, $thoiGianXuat, $nguoiXuat, 'C00000', 'L');

        $headersFlat = [
            'A' => 'STT',
            'B' => 'BIỂN SỐ XE',
            'C' => 'HIỆU XE',
            'D' => 'GIÁO VIÊN PHỤ TRÁCH',
            'E' => 'THỜI GIAN ĐI (MẶT TRƯỚC)',
            'F' => 'CỔNG XUẤT PHÁT',
            'G' => 'THỜI GIAN VỀ (MẶT SAU)',
            'H' => 'CỔNG KẾT THÚC',
            'I' => 'SỐ PHÚT Ở NGOÀI',
            'J' => 'THỜI GIAN NGOÀI (QUY ĐỔI)',
            'K' => 'LƯU QUA ĐÊM',
            'L' => 'TRẠNG THÁI CHUYẾN',
        ];
        $this->applyTableHeader($sheet2, $headersFlat, 8, 'C00000');

        $rowFlat = 9;
        if (empty($trips)) {
            $sheet2->mergeCells("A9:L9");
            $sheet2->setCellValue("A9", "Không có dữ liệu chuyến đi trong khoảng thời gian này.");
            $sheet2->getStyle("A9")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $this->applyRangeBorder($sheet2, "A9:L9");
        } else {
            $stt = 1;
            foreach ($trips as $trip) {
                $xe = $trip->xe;
                $hieuXe = $xe ? $xe->hieu_xe : '';
                $giaoVien = ($xe && $xe->giaoVien) ? $xe->giaoVien->ho_ten : '';
                $tgDi = $trip->thoi_gian_di ? date('d/m/Y H:i:s', strtotime($trip->thoi_gian_di)) : 'N/A';
                $tgVe = $trip->thoi_gian_ve ? date('d/m/Y H:i:s', strtotime($trip->thoi_gian_ve)) : 'Chưa ghi nhận';

                $sheet2->setCellValue('A' . $rowFlat, $stt++);
                $sheet2->setCellValue('B' . $rowFlat, $trip->bien_so_xe);
                $sheet2->setCellValue('C' . $rowFlat, $hieuXe ?: '-');
                $sheet2->setCellValue('D' . $rowFlat, $giaoVien ?: 'Chưa phân công');
                $sheet2->setCellValue('E' . $rowFlat, $tgDi);
                $sheet2->setCellValue('F' . $rowFlat, $trip->camera_di ?: 'Mặt trước');
                $sheet2->setCellValue('G' . $rowFlat, $tgVe);
                $sheet2->setCellValue('H' . $rowFlat, $trip->camera_ve ?: 'Mặt sau');
                $sheet2->setCellValue('I' . $rowFlat, $trip->so_phut_o_ngoai ?? 0);
                $sheet2->setCellValue('J' . $rowFlat, XeLuotRaVao::formatPhutToLabel($trip->so_phut_o_ngoai));
                $sheet2->setCellValue('K' . $rowFlat, $trip->qua_dem == 1 ? 'CÓ QUA ĐÊM' : 'Không');
                $sheet2->setCellValue('L' . $rowFlat, $trip->getTrangThaiLabel());

                $sheet2->getStyle('A' . $rowFlat)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet2->getStyle('B' . $rowFlat)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet2->getStyle('B' . $rowFlat)->getFont()->setBold(true);
                $sheet2->getStyle('E' . $rowFlat)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet2->getStyle('F' . $rowFlat)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet2->getStyle('G' . $rowFlat)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet2->getStyle('H' . $rowFlat)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet2->getStyle('I' . $rowFlat)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                $sheet2->getStyle('J' . $rowFlat)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet2->getStyle('K' . $rowFlat)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet2->getStyle('L' . $rowFlat)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                if ($trip->qua_dem == 1) {
                    $sheet2->getStyle('K' . $rowFlat)->getFont()->setBold(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FF7030A0'));
                }

                $rowFlat++;
            }
            $this->applyRangeBorder($sheet2, "A9:L" . ($rowFlat - 1));
        }

        foreach (range('A', 'L') as $col) {
            $sheet2->getColumnDimension($col)->setAutoSize(true);
        }

        // Active sheet là Sheet 1
        $spreadsheet->setActiveSheetIndex(0);
    }

    /**
     * Xuất báo cáo phương tiện lưu lại qua đêm
     */
    private function exportXeQuaDem($spreadsheet, $tuNgay, $denNgay, $startDateTime, $endDateTime, $tuNgayDisplay, $denNgayDisplay, $thoiGianXuat, $nguoiXuat, $khuVucCong = 'cong_can_tin', $tenKhuVucDisplay = 'CỔNG CĂN TIN')
    {
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Xe_Qua_Dem');
        $sheet->setShowGridLines(true);

        $this->applyReportHeader($sheet, 'BÁO CÁO PHƯƠNG TIỆN LƯU LẠI QUA ĐÊM (00:00 - 05:00) - ' . $tenKhuVucDisplay, $tuNgayDisplay, $denNgayDisplay, $thoiGianXuat, $nguoiXuat, '592D86', 'L');

        $headers = [
            'A' => 'STT',
            'B' => 'BIỂN SỐ XE',
            'C' => 'PHÂN LOẠI XE',
            'D' => 'HIỆU XE / THÔNG TIN',
            'E' => 'NGƯỜI QUẢN LÝ / LIÊN HỆ',
            'F' => 'THỜI GIAN BẮT ĐẦU / ĐI',
            'G' => 'CỔNG BẮT ĐẦU',
            'H' => 'THỜI GIAN KẾT THÚC / VỀ',
            'I' => 'CỔNG KẾT THÚC',
            'J' => 'THỜI GIAN LƯU LẠI',
            'K' => 'TRẠNG THÁI',
            'L' => 'ĐẶC ĐIỂM QUA ĐÊM',
        ];
        $this->applyTableHeader($sheet, $headers, 8, '592D86');

        $query = XeLuotRaVao::find()
            ->where(['is_deleted' => XeLuotRaVao::STATUS_ACTIVE])
            ->andWhere(['qua_dem' => XeLuotRaVao::QUA_DEM_CO])
            ->andWhere([
                'or',
                ['between', 'thoi_gian_di', $startDateTime, $endDateTime],
                ['between', 'thoi_gian_ve', $startDateTime, $endDateTime],
            ]);

        $this->applyGateFilter($query, $khuVucCong);

        $trips = $query->orderBy(['thoi_gian_di' => SORT_DESC, 'id' => SORT_DESC])
            ->all();

        $row = 9;
        if (empty($trips)) {
            $sheet->mergeCells("A9:L9");
            $sheet->setCellValue("A9", "Không có phương tiện lưu lại qua đêm trong khoảng thời gian này.");
            $sheet->getStyle("A9")->applyFromArray([
                'font' => ['italic' => true, 'color' => ['rgb' => '666666']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ]);
            $this->applyRangeBorder($sheet, "A9:L9");
        } else {
            $stt = 1;
            foreach ($trips as $trip) {
                $xe = $trip->xe;
                $hieuXe = $xe ? $xe->hieu_xe : ($trip->loai_xe === XeLuotRaVao::LOAI_XE_NGOAI ? 'Xe khách vãng lai' : '-');
                $giaoVien = ($xe && $xe->giaoVien) ? $xe->giaoVien->ho_ten : '-';
                $tgDi = $trip->thoi_gian_di ? date('d/m/Y H:i:s', strtotime($trip->thoi_gian_di)) : 'N/A';
                $tgVe = $trip->thoi_gian_ve ? date('d/m/Y H:i:s', strtotime($trip->thoi_gian_ve)) : 'Chưa ghi nhận';
                $dacDiem = $trip->loai_xe === XeLuotRaVao::LOAI_XE_NOI_BO ? 'Xe nội bộ qua đêm ngoài trường' : 'Xe khách lưu lại sân qua đêm';

                $sheet->setCellValue('A' . $row, $stt++);
                $sheet->setCellValue('B' . $row, $trip->bien_so_xe);
                $sheet->setCellValue('C' . $row, $trip->loai_xe === XeLuotRaVao::LOAI_XE_NOI_BO ? 'Xe nội bộ' : 'Xe khách ngoài');
                $sheet->setCellValue('D' . $row, $hieuXe);
                $sheet->setCellValue('E' . $row, $giaoVien);
                $sheet->setCellValue('F' . $row, $tgDi);
                $sheet->setCellValue('G' . $row, $trip->camera_di ?: '-');
                $sheet->setCellValue('H' . $row, $tgVe);
                $sheet->setCellValue('I' . $row, $trip->camera_ve ?: '-');
                $sheet->setCellValue('J' . $row, XeLuotRaVao::formatPhutToLabel($trip->so_phut_o_ngoai));
                $sheet->setCellValue('K' . $row, $trip->getTrangThaiLabel());
                $sheet->setCellValue('L' . $row, $dacDiem);

                $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('B' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('B' . $row)->getFont()->setBold(true);
                $sheet->getStyle('C' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('F' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('G' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('H' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('I' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('J' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('K' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $row++;
            }
            $this->applyRangeBorder($sheet, "A9:L" . ($row - 1));
        }

        foreach (range('A', 'L') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }

    /**
     * Xuất báo cáo xe lạ / xe khách vãng lai
     */
    private function exportXeLa($spreadsheet, $tuNgay, $denNgay, $startDateTime, $endDateTime, $tuNgayDisplay, $denNgayDisplay, $thoiGianXuat, $nguoiXuat, $khuVucCong = 'cong_can_tin', $tenKhuVucDisplay = 'CỔNG CĂN TIN')
    {
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Xe_Vang_Lai');
        $sheet->setShowGridLines(true);

        $this->applyReportHeader($sheet, 'BÁO CÁO XE KHÁCH NGOÀI / XE VÃNG LAI VÀO SÂN - ' . $tenKhuVucDisplay, $tuNgayDisplay, $denNgayDisplay, $thoiGianXuat, $nguoiXuat, '2F5597', 'J');

        $headers = [
            'A' => 'STT',
            'B' => 'BIỂN SỐ XE KHÁCH',
            'C' => 'THỜI GIAN VÀO (ĐUÔI XE)',
            'D' => 'CỔNG VÀO',
            'E' => 'THỜI GIAN RA (ĐẦU XE)',
            'F' => 'CỔNG RA',
            'G' => 'THỜI GIAN TRONG SÂN',
            'H' => 'LƯU QUA ĐÊM',
            'I' => 'TRẠNG THÁI',
            'J' => 'GHI CHÚ',
        ];
        $this->applyTableHeader($sheet, $headers, 8, '2F5597');

        $query = XeLuotRaVao::find()
            ->where(['is_deleted' => XeLuotRaVao::STATUS_ACTIVE])
            ->andWhere(['loai_xe' => XeLuotRaVao::LOAI_XE_NGOAI])
            ->andWhere([
                'or',
                ['between', 'thoi_gian_di', $startDateTime, $endDateTime],
                ['between', 'thoi_gian_ve', $startDateTime, $endDateTime],
            ]);

        $this->applyGateFilter($query, $khuVucCong);

        $trips = $query->orderBy(['thoi_gian_di' => SORT_DESC, 'id' => SORT_DESC])
            ->all();

        $row = 9;
        if (empty($trips)) {
            $sheet->mergeCells("A9:J9");
            $sheet->setCellValue("A9", "Không có phương tiện khách ngoài vào sân trong khoảng thời gian này.");
            $sheet->getStyle("A9")->applyFromArray([
                'font' => ['italic' => true, 'color' => ['rgb' => '666666']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ]);
            $this->applyRangeBorder($sheet, "A9:J9");
        } else {
            $stt = 1;
            foreach ($trips as $trip) {
                $tgVao = $trip->thoi_gian_di ? date('d/m/Y H:i:s', strtotime($trip->thoi_gian_di)) : 'N/A';
                $tgRa = $trip->thoi_gian_ve ? date('d/m/Y H:i:s', strtotime($trip->thoi_gian_ve)) : 'Đang trong sân';
                $ghiChu = $trip->qua_dem == 1 ? 'Lưu đêm tại bãi xe' : 'Khách vãng lai trong ngày';

                $sheet->setCellValue('A' . $row, $stt++);
                $sheet->setCellValue('B' . $row, $trip->bien_so_xe);
                $sheet->setCellValue('C' . $row, $tgVao);
                $sheet->setCellValue('D' . $row, $trip->camera_di ?: 'Mặt sau (Đuôi)');
                $sheet->setCellValue('E' . $row, $tgRa);
                $sheet->setCellValue('F' . $row, $trip->camera_ve ?: 'Mặt trước (Đầu)');
                $sheet->setCellValue('G' . $row, XeLuotRaVao::formatPhutToLabel($trip->so_phut_o_ngoai));
                $sheet->setCellValue('H' . $row, $trip->qua_dem == 1 ? 'CÓ QUA ĐÊM' : 'Không');
                $sheet->setCellValue('I' . $row, $trip->getTrangThaiLabel());
                $sheet->setCellValue('J' . $row, $ghiChu);

                $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('B' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('B' . $row)->getFont()->setBold(true);
                $sheet->getStyle('C' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('D' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('E' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('F' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('G' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('H' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('I' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                if ($trip->qua_dem == 1) {
                    $sheet->getStyle('H' . $row)->getFont()->setBold(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FF7030A0'));
                }

                $row++;
            }
            $this->applyRangeBorder($sheet, "A9:J" . ($row - 1));
        }

        foreach (range('A', 'J') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }

    /**
     * Xuất báo cáo tổng hợp toàn bộ lượt xe
     */
    private function exportTatCa($spreadsheet, $tuNgay, $denNgay, $startDateTime, $endDateTime, $tuNgayDisplay, $denNgayDisplay, $thoiGianXuat, $nguoiXuat, $khuVucCong = 'cong_can_tin', $tenKhuVucDisplay = 'CỔNG CĂN TIN')
    {
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Tong_Hop_Luot_Xe');
        $sheet->setShowGridLines(true);

        $this->applyReportHeader($sheet, 'BÁO CÁO TỔNG HỢP TOÀN BỘ LƯỢT XE RA - VÀO BÃI - ' . $tenKhuVucDisplay, $tuNgayDisplay, $denNgayDisplay, $thoiGianXuat, $nguoiXuat, '1F4E79', 'M');

        $headers = [
            'A' => 'STT',
            'B' => 'BIỂN SỐ XE',
            'C' => 'PHÂN LOẠI',
            'D' => 'KẾ HOẠCH',
            'E' => 'HIỆU XE',
            'F' => 'GIÁO VIÊN / QUẢN LÝ',
            'G' => 'THỜI GIAN BẮT ĐẦU',
            'H' => 'CỔNG BẮT ĐẦU',
            'I' => 'THỜI GIAN KẾT THÚC',
            'J' => 'CỔNG KẾT THÚC',
            'K' => 'THỜI GIAN THỰC TẾ',
            'L' => 'QUA ĐÊM',
            'M' => 'TRẠNG THÁI',
        ];
        $this->applyTableHeader($sheet, $headers, 8, '1F4E79');

        $query = XeLuotRaVao::find()
            ->where(['is_deleted' => XeLuotRaVao::STATUS_ACTIVE])
            ->andWhere([
                'or',
                ['between', 'thoi_gian_di', $startDateTime, $endDateTime],
                ['between', 'thoi_gian_ve', $startDateTime, $endDateTime],
            ]);

        $this->applyGateFilter($query, $khuVucCong);

        $trips = $query->orderBy(['thoi_gian_di' => SORT_DESC, 'id' => SORT_DESC])
            ->all();

        $row = 9;
        if (empty($trips)) {
            $sheet->mergeCells("A9:M9");
            $sheet->setCellValue("A9", "Không có dữ liệu lượt xe trong khoảng thời gian này.");
            $sheet->getStyle("A9")->applyFromArray([
                'font' => ['italic' => true, 'color' => ['rgb' => '666666']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ]);
            $this->applyRangeBorder($sheet, "A9:M9");
        } else {
            $stt = 1;
            foreach ($trips as $trip) {
                $xe = $trip->xe;
                $hieuXe = $xe ? $xe->hieu_xe : ($trip->loai_xe === XeLuotRaVao::LOAI_XE_NGOAI ? 'Xe khách' : '-');
                $giaoVien = ($xe && $xe->giaoVien) ? $xe->giaoVien->ho_ten : '-';
                $tgDi = $trip->thoi_gian_di ? date('d/m/Y H:i:s', strtotime($trip->thoi_gian_di)) : 'N/A';
                $tgVe = $trip->thoi_gian_ve ? date('d/m/Y H:i:s', strtotime($trip->thoi_gian_ve)) : 'Chưa ghi nhận';

                $sheet->setCellValue('A' . $row, $stt++);
                $sheet->setCellValue('B' . $row, $trip->bien_so_xe);
                $sheet->setCellValue('C' . $row, $trip->loai_xe === XeLuotRaVao::LOAI_XE_NOI_BO ? 'Xe nội bộ' : 'Xe ngoài');
                $sheet->setCellValue('D' . $row, $trip->getKeHoachLabel());
                $sheet->setCellValue('E' . $row, $hieuXe);
                $sheet->setCellValue('F' . $row, $giaoVien);
                $sheet->setCellValue('G' . $row, $tgDi);
                $sheet->setCellValue('H' . $row, $trip->camera_di ?: '-');
                $sheet->setCellValue('I' . $row, $tgVe);
                $sheet->setCellValue('J' . $row, $trip->camera_ve ?: '-');
                $sheet->setCellValue('K' . $row, XeLuotRaVao::formatPhutToLabel($trip->so_phut_o_ngoai));
                $sheet->setCellValue('L' . $row, $trip->qua_dem == 1 ? 'CÓ QUA ĐÊM' : 'Không');
                $sheet->setCellValue('M' . $row, $trip->getTrangThaiLabel());

                $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('B' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('B' . $row)->getFont()->setBold(true);
                $sheet->getStyle('C' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('D' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('G' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('H' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('I' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('J' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('K' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('L' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('M' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                if ($trip->qua_dem == 1) {
                    $sheet->getStyle('L' . $row)->getFont()->setBold(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FF7030A0'));
                }

                $row++;
            }
            $this->applyRangeBorder($sheet, "A9:M" . ($row - 1));
        }

        foreach (range('A', 'M') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }
}

