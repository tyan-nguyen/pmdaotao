<?php

namespace app\modules\thuexe\services;

use Yii;
use app\models\PtxXe;
use app\models\GdTietHoc;
use app\modules\thuexe\models\LichThue;
use app\modules\thuexe\models\XeCameraLogs;
use app\modules\thuexe\models\XeLuotRaVao;
use app\modules\taisan\models\PhieuDeNghi;
use app\modules\taisan\models\base\PhieuDeNghiBase;
use app\modules\thuexe\models\LichDungXe;
use app\modules\thuexe\models\base\LichDungXeBase;

/**
 * Class XeCameraTripService
 * Dịch vụ xử lý ghép cặp sự kiện xe Đi - Về / Vào - Ra (Trip Matching Engine)
 * @package app\modules\thuexe\services
 */
class XeCameraTripService
{
    /** Dung sai cho phép xe vào sớm tối đa (phút) trước khi ca thuê bắt đầu */
    const TOLERANCE_EARLY_MINUTES = 15;

    /** Dung sai cho phép xe ra trễ tối đa (phút) sau khi ca thuê kết thúc */
    const TOLERANCE_LATE_MINUTES = 5;

    /**
     * Logic kiểm tra kế hoạch đi của xe tại Cổng Căn Tin theo quy trình 4 tầng:
     * - Tầng 1: Kiểm tra lịch dạy thực hành trong ngày tại bảng [gd_tiet_hoc].
     * - Tầng 2: Kiểm tra vé thuê xe hợp lệ tại bảng [ptx_lich_thue] (áp dụng dung sai vào sớm/ra trễ).
     * - Tầng 3: Kiểm tra phiếu đề nghị sửa xe / bảo dưỡng tại bảng [cp_phieu_de_nghi] (trang_thai là DA_DUYET hoặc HOAN_THANH, ngay_bat_dau <= timeStr <= ngay_hoan_thanh).
     * - Tầng 4: Kiểm tra lịch dùng xe nội bộ tại bảng [ptx_xe_lich_dung_xe] (trang_thai = ACTIVE, thoi_gian_bat_dau <= timeStr <= thoi_gian_ket_thuc).
     * Chỉ khi cả 4 tầng đều không thỏa mãn thì mới xác định là ĐI KHÔNG KẾ HOẠCH.
     *
     * @param string|null $bienSo
     * @param string|null $checkDate Định dạng 'Y-m-d' hoặc 'Y-m-d H:i:s' (mặc định là ngày hôm nay)
     * @return array [
     *     'thuoc_danh_sach_xe' => bool,
     *     'co_ke_hoach' => bool,
     *     'di_khong_ke_hoach' => bool,
     *     'xe' => PtxXe|null,
     *     'loai_ke_hoach' => string|null ('tiet_hoc', 'lich_thue', 'phieu_de_nghi', 'lich_dung_xe'),
     *     'chi_tiet_ke_hoach' => mixed,
     *     'lich_thue' => LichThue|null,
     *     'phieu_de_nghi' => PhieuDeNghi|null,
     *     'lich_dung_xe' => LichDungXe|null
     * ]
     */
    public static function kiemTraKeHoachXe($bienSo, $checkDate = null)
    {
        $bienSoClean = preg_replace('/[^A-Za-z0-9]/', '', (string)$bienSo);
        $bienSoClean = strtoupper($bienSoClean);

        if (empty($bienSoClean)) {
            return [
                'thuoc_danh_sach_xe' => false,
                'co_ke_hoach' => false,
                'di_khong_ke_hoach' => false,
                'xe' => null,
                'loai_ke_hoach' => null,
                'chi_tiet_ke_hoach' => null,
                'lich_thue' => null,
                'phieu_de_nghi' => null,
                'lich_dung_xe' => null,
            ];
        }

        // Tìm trong bảng [ptx_xe] xem có thuộc danh sách xe không (trường ma_bien_so)
        $xe = PtxXe::find()
            ->where(['ma_bien_so' => $bienSoClean])
            ->orWhere(['REPLACE(REPLACE(REPLACE(ma_bien_so, ".", ""), "-", ""), " ", "")' => $bienSoClean])
            ->orWhere(['REPLACE(REPLACE(REPLACE(bien_so_xe, ".", ""), "-", ""), " ", "")' => $bienSoClean])
            ->one();

        if (!$xe) {
            return [
                'thuoc_danh_sach_xe' => false,
                'co_ke_hoach' => false,
                'di_khong_ke_hoach' => false,
                'xe' => null,
                'loai_ke_hoach' => null,
                'chi_tiet_ke_hoach' => null,
                'lich_thue' => null,
                'phieu_de_nghi' => null,
                'lich_dung_xe' => null,
            ];
        }

        $timeStr = !empty($checkDate) ? date('Y-m-d H:i:s', strtotime($checkDate)) : date('Y-m-d H:i:s');
        $today = date('Y-m-d', strtotime($timeStr));

        $hasSchedule = false;
        $loaiKeHoach = null;
        $chiTietKeHoach = null;

        // ---------------------------------------------------------------------
        // 1. TẦNG 1: Kiểm tra lịch dạy thực hành trong bảng [gd_tiet_hoc]
        // ---------------------------------------------------------------------
        $hasTietHoc = GdTietHoc::find()
            ->where(['id_xe' => $xe->id])
            ->andWhere(['>=', 'thoi_gian_bd', $today . ' 00:00:00'])
            ->andWhere(['<=', 'thoi_gian_bd', $today . ' 23:59:59'])
            ->exists();

        if ($hasTietHoc) {
            $hasSchedule = true;
            $loaiKeHoach = 'tiet_hoc';
        }

        // ---------------------------------------------------------------------
        // 2. TẦNG 2: Nếu không có tiết dạy, kiểm tra tiếp Vé thuê xe [ptx_lich_thue]
        // ---------------------------------------------------------------------
        if (!$hasSchedule) {
            $checkLichThue = self::kiemTraLichThueXe($bienSoClean, $timeStr);
            if ($checkLichThue['co_ke_hoach']) {
                $hasSchedule = true;
                $loaiKeHoach = 'lich_thue';
                $chiTietKeHoach = $checkLichThue['lich_thue'];
            }
        }

        // ---------------------------------------------------------------------
        // 3. TẦNG 3: Nếu vẫn chưa có, kiểm tra Phiếu đề nghị sửa xe [cp_phieu_de_nghi]
        // Điều kiện: trang_thai IN ('DA_DUYET', 'HOAN_THANH') và ngay_bat_dau <= timeStr <= ngay_hoan_thanh
        // ---------------------------------------------------------------------
        if (!$hasSchedule) {
            $phieuDeNghi = PhieuDeNghi::find()
                ->where(['id_tham_chieu' => $xe->id, 'loai_tai_san' => PhieuDeNghiBase::LOAITAISAN_XE])
                ->andWhere(['in', 'trang_thai', [PhieuDeNghiBase::TRANGTHAI_DADUYET, PhieuDeNghiBase::TRANGTHAI_HOANTHANH]])
                ->andWhere(['<=', 'ngay_bat_dau', $timeStr])
                ->andWhere(['>=', 'ngay_hoan_thanh', $timeStr])
                ->orderBy(['id' => SORT_DESC])
                ->one();

            if ($phieuDeNghi) {
                $hasSchedule = true;
                $loaiKeHoach = 'phieu_de_nghi';
                $chiTietKeHoach = $phieuDeNghi;
            }
        }

        // ---------------------------------------------------------------------
        // 4. TẦNG 4: Nếu vẫn chưa có, kiểm tra Lịch dùng xe nội bộ [ptx_xe_lich_dung_xe]
        // Điều kiện: trang_thai = 'ACTIVE' và thoi_gian_bat_dau <= timeStr <= thoi_gian_ket_thuc
        // ---------------------------------------------------------------------
        if (!$hasSchedule) {
            $lichDungXe = LichDungXe::find()
                ->where(['id_xe' => $xe->id])
                ->andWhere(['trang_thai' => LichDungXeBase::TT_ACTIVE])
                ->andWhere(['<=', 'thoi_gian_bat_dau', $timeStr])
                ->andWhere(['>=', 'thoi_gian_ket_thuc', $timeStr])
                ->orderBy(['thoi_gian_bat_dau' => SORT_ASC])
                ->one();

            if ($lichDungXe) {
                $hasSchedule = true;
                $loaiKeHoach = 'lich_dung_xe';
                $chiTietKeHoach = $lichDungXe;
            }
        }

        // ---------------------------------------------------------------------
        // KẾT LUẬN: Nếu cả 4 tầng đều không thỏa mãn -> Xác định đi không kế hoạch
        // ---------------------------------------------------------------------
        return [
            'thuoc_danh_sach_xe' => true,
            'co_ke_hoach' => (bool)$hasSchedule,
            'di_khong_ke_hoach' => !(bool)$hasSchedule,
            'xe' => $xe,
            'loai_ke_hoach' => $loaiKeHoach,
            'chi_tiet_ke_hoach' => $chiTietKeHoach,
            'lich_thue' => ($loaiKeHoach === 'lich_thue') ? $chiTietKeHoach : null,
            'phieu_de_nghi' => ($loaiKeHoach === 'phieu_de_nghi') ? $chiTietKeHoach : null,
            'lich_dung_xe' => ($loaiKeHoach === 'lich_dung_xe') ? $chiTietKeHoach : null,
        ];
    }

    /**
     * Logic kiểm tra lịch thuê xe tại Cổng Sân Cảm Biến (tìm xe nội bộ và lịch thuê trong ptx_lich_thue)
     * Kiểm tra giờ vào/ra có thuộc record nào trong bảng [ptx_lich_thue] không trong khoảng thoi_gian_bat_dau - thoi_gian_ket_thuc.
     * Cho phép dung sai xe vào sớm tối đa 15 phút và ra trễ tối đa 15 phút so với ca thuê.
     *
     * @param string|null $bienSo
     * @param string|null $checkTime Định dạng 'Y-m-d H:i:s' (mặc định là ngày giờ hiện tại)
     * @return array [
     *     'thuoc_danh_sach_xe' => bool,
     *     'co_ke_hoach' => bool,
     *     'di_khong_ke_hoach' => bool,
     *     'xe' => PtxXe|null,
     *     'lich_thue' => LichThue|null
     * ]
     */
    public static function kiemTraLichThueXe($bienSo, $checkTime = null)
    {
        $bienSoClean = preg_replace('/[^A-Za-z0-9]/', '', (string)$bienSo);
        $bienSoClean = strtoupper($bienSoClean);

        if (empty($bienSoClean)) {
            return [
                'thuoc_danh_sach_xe' => false,
                'co_ke_hoach' => false,
                'di_khong_ke_hoach' => false,
                'xe' => null,
                'lich_thue' => null,
            ];
        }

        // Tìm trong bảng [ptx_xe] xem có thuộc danh sách xe không
        $xe = PtxXe::find()
            ->where(['ma_bien_so' => $bienSoClean])
            ->orWhere(['REPLACE(REPLACE(REPLACE(ma_bien_so, ".", ""), "-", ""), " ", "")' => $bienSoClean])
            ->orWhere(['REPLACE(REPLACE(REPLACE(bien_so_xe, ".", ""), "-", ""), " ", "")' => $bienSoClean])
            ->one();

        if (!$xe) {
            return [
                'thuoc_danh_sach_xe' => false,
                'co_ke_hoach' => false,
                'di_khong_ke_hoach' => false,
                'xe' => null,
                'lich_thue' => null,
            ];
        }

        $timeStr = !empty($checkTime) ? date('Y-m-d H:i:s', strtotime($checkTime)) : date('Y-m-d H:i:s');
        $earlyMinutes = Yii::$app->params['camera_tolerance_early_minutes'] ?? self::TOLERANCE_EARLY_MINUTES;
        $lateMinutes = Yii::$app->params['camera_tolerance_late_minutes'] ?? self::TOLERANCE_LATE_MINUTES;

        // Dung sai: Cho phép xe vào sớm tối đa trước khi ca thuê bắt đầu
        $maxStartTime = date('Y-m-d H:i:s', strtotime($timeStr . " +{$earlyMinutes} minutes"));

        // Dung sai: Cho phép xe ra trễ tối đa sau khi ca thuê kết thúc
        $minEndTime = date('Y-m-d H:i:s', strtotime($timeStr . " -{$lateMinutes} minutes"));

        // Tìm lịch thuê trong [ptx_lich_thue] thỏa mãn khung giờ cho phép (bao gồm dung sai vào sớm / ra trễ)
        $lichThue = LichThue::find()
            ->where(['id_xe' => $xe->id])
            ->andWhere(['in', 'trang_thai', [LichThue::TT_LENLICH, LichThue::TT_XUATHOADON]])
            ->andWhere(['<=', 'thoi_gian_bat_dau', $maxStartTime])
            ->andWhere(['>=', 'thoi_gian_ket_thuc', $minEndTime])
            ->orderBy(['thoi_gian_bat_dau' => SORT_ASC])
            ->one();

        $hasSchedule = ($lichThue !== null);

        return [
            'thuoc_danh_sach_xe' => true,
            'co_ke_hoach' => $hasSchedule,
            'di_khong_ke_hoach' => !$hasSchedule,
            'xe' => $xe,
            'lich_thue' => $lichThue,
        ];
    }

    /**
     * Tự động đồng bộ và tái tính toán các lượt đi - về / vào - ra cho một xe cụ thể
     *
     * @param string|null $maXe
     * @return int Số lượng block chuyến đi được tạo ra
     */
    public static function syncVehicleTrips($maXe)
    {
        if (empty($maXe)) {
            return 0;
        }

        $cleanMaXe = XeCameraLogs::chuanHoaMaXe($maXe);
        if (empty($cleanMaXe)) {
            return 0;
        }

        // 1. Phân loại xe: Xe nội bộ hay Xe ngoài
        $checkCar = self::kiemTraKeHoachXe($cleanMaXe);
        $isNoiBo = $checkCar['thuoc_danh_sach_xe'];
        $internalCar = $checkCar['xe'];

        // 2. Xóa các block chuyến đi hiện tại của xe này trong bảng ptx_xe_luot_ra_vao
        XeLuotRaVao::deleteAll(['ma_xe' => $cleanMaXe]);

        // 3. Lấy tất cả logs còn hiệu lực (chưa bị xóa mềm) của xe theo thứ tự thời gian tăng dần
        $logs = XeCameraLogs::find()
            ->where(['ma_xe' => $cleanMaXe])
            ->andWhere(['or', ['is_deleted' => 0], ['is_deleted' => null]])
            ->orderBy(['thoi_gian' => SORT_ASC, 'id' => SORT_ASC])
            ->all();

        if (empty($logs)) {
            return 0;
        }

        $createdTripsCount = 0;
        /** @var array<string, XeLuotRaVao|null> $pendingByGate */
        $pendingByGate = [];

        foreach ($logs as $log) {
            // Xác định cổng kiểm soát và chiều chuyển động
            $congVaChieu = XeCameraLogs::xacDinhCongVaChieu($log->camera, $log->su_kien, $isNoiBo);
            $cong = $congVaChieu['cong'];
            $chieu = $congVaChieu['chieu'];

            if ($cong === XeCameraLogs::CONG_SAN_CAM_BIEN) {
                // =========================================================================
                // CHU TRÌNH SÂN CẢM BIẾN (VAO: Vào sân tập -> RA: Rời khỏi sân)
                // =========================================================================
                if ($chieu === 'VAO') {
                    // Sự kiện VÀO SÂN CẢM BIẾN (cong_san_cam_bien_vao)
                    if ($isNoiBo) {
                        $logPlan = $log->trang_thai_ke_hoach;
                        if (empty($logPlan) || $logPlan === XeLuotRaVao::KE_HOACH_INFO) {
                            $rentalCheck = self::kiemTraLichThueXe($cleanMaXe, $log->thoi_gian);
                            $logPlan = $rentalCheck['co_ke_hoach'] ? XeLuotRaVao::KE_HOACH_APPROVED : XeLuotRaVao::KE_HOACH_UNPLANNED;
                            if ($log->hasAttribute('trang_thai_ke_hoach') && $log->trang_thai_ke_hoach !== $logPlan) {
                                $log->trang_thai_ke_hoach = $logPlan;
                                $log->save(false);
                            }
                        }
                    } else {
                        $logPlan = XeLuotRaVao::KE_HOACH_INFO;
                        if ($log->hasAttribute('trang_thai_ke_hoach') && $log->trang_thai_ke_hoach !== $logPlan) {
                            $log->trang_thai_ke_hoach = $logPlan;
                            $log->save(false);
                        }
                    }

                    // Nếu tại Sân cảm biến đang có 1 phiên vào chưa ra, xe lại vào tiếp -> Chốt lỗi phiên cũ!
                    if (isset($pendingByGate[$cong]) && $pendingByGate[$cong] !== null) {
                        $pendingByGate[$cong]->trang_thai = XeLuotRaVao::TRANG_THAI_LOI_VAO_KHONG_RA;
                        $pendingByGate[$cong]->save(false);
                        $createdTripsCount++;
                    }

                    // Mở lượt vào mới tại Sân cảm biến (kieu_luot = VAO_RA)
                    $newTrip = new XeLuotRaVao();
                    $newTrip->ma_xe = $cleanMaXe;
                    $newTrip->bien_so_xe = $log->bien_so_xe ?: $cleanMaXe;
                    $newTrip->id_xe = $internalCar ? $internalCar->id : null;
                    $newTrip->loai_xe = $isNoiBo ? XeLuotRaVao::LOAI_XE_NOI_BO : XeLuotRaVao::LOAI_XE_NGOAI;
                    $newTrip->kieu_luot = XeLuotRaVao::KIEU_LUOT_VAO_RA;
                    $newTrip->log_di_id = $log->id; // Log 1: Vào sân
                    $newTrip->camera_di = $log->camera;
                    $newTrip->thoi_gian_di = $log->thoi_gian;
                    $newTrip->trang_thai_ke_hoach = $logPlan;
                    $newTrip->trang_thai = XeLuotRaVao::TRANG_THAI_DANG_TRONG_SAN;

                    $pendingByGate[$cong] = $newTrip;
                } elseif ($chieu === 'RA') {
                    // Sự kiện RỜI KHỎI SÂN CẢM BIẾN (cong_san_cam_bien_ra)
                    if (isset($pendingByGate[$cong]) && $pendingByGate[$cong] !== null) {
                        // CÙNG CỔNG SÂN CẢM BIẾN -> Ghép cặp thành công!
                        $trip = $pendingByGate[$cong];
                        $trip->log_ve_id = $log->id; // Log 2: Ra khỏi sân
                        $trip->camera_ve = $log->camera;
                        $trip->thoi_gian_ve = $log->thoi_gian;

                        // Tính số phút ở trong sân = thoi_gian_ra - thoi_gian_vao
                        $tsVao = strtotime($trip->thoi_gian_di);
                        $tsRa = strtotime($log->thoi_gian);
                        $soPhut = max(0, (int)round(($tsRa - $tsVao) / 60));

                        $trip->so_phut_o_ngoai = $soPhut; // Thời gian lưu lại trong sân cảm biến
                        $trip->thoi_gian_o_ngoai_label = XeLuotRaVao::formatPhutToLabel($soPhut);
                        $trip->trang_thai = XeLuotRaVao::TRANG_THAI_HOAN_THANH;
                        $trip->save(false);

                        $createdTripsCount++;
                        $pendingByGate[$cong] = null;
                    } else {
                        // Ra khỏi sân cảm biến mà chưa có lượt vào
                        $orphanTrip = new XeLuotRaVao();
                        $orphanTrip->ma_xe = $cleanMaXe;
                        $orphanTrip->bien_so_xe = $log->bien_so_xe ?: $cleanMaXe;
                        $orphanTrip->id_xe = $internalCar ? $internalCar->id : null;
                        $orphanTrip->loai_xe = $isNoiBo ? XeLuotRaVao::LOAI_XE_NOI_BO : XeLuotRaVao::LOAI_XE_NGOAI;
                        $orphanTrip->kieu_luot = XeLuotRaVao::KIEU_LUOT_VAO_RA;
                        $orphanTrip->log_ve_id = $log->id;
                        $orphanTrip->camera_ve = $log->camera;
                        $orphanTrip->thoi_gian_ve = $log->thoi_gian;
                        $orphanTrip->trang_thai_ke_hoach = $isNoiBo ? XeLuotRaVao::KE_HOACH_APPROVED : XeLuotRaVao::KE_HOACH_INFO;
                        $orphanTrip->trang_thai = XeLuotRaVao::TRANG_THAI_LOI_RA_KHONG_VAO;
                        $orphanTrip->save(false);

                        $createdTripsCount++;
                    }
                }
            } else {
                // =========================================================================
                // CHU TRÌNH CỔNG CĂN TIN (VÀ CÁC CỔNG NGOÀI KHÁC)
                // =========================================================================
                if ($isNoiBo) {
                    // XE NỘI BỘ: RA: Đi ra ngoài trường -> VAO: Trở về bãi
                    if ($chieu === 'RA') {
                        // Sự kiện ĐI RA KHỎI TRƯỜNG
                        $logPlan = $log->trang_thai_ke_hoach;
                        if (empty($logPlan) || $logPlan === XeLuotRaVao::KE_HOACH_INFO) {
                            $planCheck = self::kiemTraKeHoachXe($cleanMaXe, $log->thoi_gian);
                            $logPlan = $planCheck['co_ke_hoach'] ? XeLuotRaVao::KE_HOACH_APPROVED : XeLuotRaVao::KE_HOACH_UNPLANNED;
                            if ($log->hasAttribute('trang_thai_ke_hoach') && $log->trang_thai_ke_hoach !== $logPlan) {
                                $log->trang_thai_ke_hoach = $logPlan;
                                $log->save(false);
                            }
                        }

                        // Nếu tại cổng này đang có 1 phiên chờ về mà chưa về, xe lại tiếp tục đi ra -> Chốt lỗi phiên cũ!
                        if (isset($pendingByGate[$cong]) && $pendingByGate[$cong] !== null) {
                            $pendingByGate[$cong]->trang_thai = XeLuotRaVao::TRANG_THAI_LOI_DI_KHONG_VE;
                            $pendingByGate[$cong]->save(false);
                            $createdTripsCount++;
                        }

                        // Mở lượt đi mới tại cổng căn tin (kieu_luot = DI_VE)
                        $newTrip = new XeLuotRaVao();
                        $newTrip->ma_xe = $cleanMaXe;
                        $newTrip->bien_so_xe = $log->bien_so_xe ?: $cleanMaXe;
                        $newTrip->id_xe = $internalCar ? $internalCar->id : null;
                        $newTrip->loai_xe = XeLuotRaVao::LOAI_XE_NOI_BO;
                        $newTrip->kieu_luot = XeLuotRaVao::KIEU_LUOT_DI_VE;
                        $newTrip->log_di_id = $log->id;
                        $newTrip->camera_di = $log->camera;
                        $newTrip->thoi_gian_di = $log->thoi_gian;
                        $newTrip->trang_thai_ke_hoach = $logPlan;
                        $newTrip->trang_thai = XeLuotRaVao::TRANG_THAI_DANG_O_NGOAI;

                        $pendingByGate[$cong] = $newTrip;
                    } elseif ($chieu === 'VAO') {
                        // Sự kiện VỀ BÃI
                        if ($log->hasAttribute('trang_thai_ke_hoach') && $log->trang_thai_ke_hoach === XeLuotRaVao::KE_HOACH_INFO) {
                            $log->trang_thai_ke_hoach = XeLuotRaVao::KE_HOACH_APPROVED;
                            $log->save(false);
                        }

                        if (isset($pendingByGate[$cong]) && $pendingByGate[$cong] !== null) {
                            // CÙNG CỔNG -> Ghép cặp thành công!
                            $trip = $pendingByGate[$cong];
                            $trip->log_ve_id = $log->id;
                            $trip->camera_ve = $log->camera;
                            $trip->thoi_gian_ve = $log->thoi_gian;

                            // Tính số phút ở ngoài = thoi_gian_ve - thoi_gian_di
                            $tsDi = strtotime($trip->thoi_gian_di);
                            $tsVe = strtotime($log->thoi_gian);
                            $soPhut = max(0, (int)round(($tsVe - $tsDi) / 60));

                            $trip->so_phut_o_ngoai = $soPhut;
                            $trip->thoi_gian_o_ngoai_label = XeLuotRaVao::formatPhutToLabel($soPhut);
                            $trip->trang_thai = XeLuotRaVao::TRANG_THAI_HOAN_THANH;
                            $trip->save(false);

                            $createdTripsCount++;
                            $pendingByGate[$cong] = null;
                        } else {
                            // Xe về bãi mà không có lượt đi
                            $orphanTrip = new XeLuotRaVao();
                            $orphanTrip->ma_xe = $cleanMaXe;
                            $orphanTrip->bien_so_xe = $log->bien_so_xe ?: $cleanMaXe;
                            $orphanTrip->id_xe = $internalCar ? $internalCar->id : null;
                            $orphanTrip->loai_xe = XeLuotRaVao::LOAI_XE_NOI_BO;
                            $orphanTrip->kieu_luot = XeLuotRaVao::KIEU_LUOT_DI_VE;
                            $orphanTrip->log_ve_id = $log->id;
                            $orphanTrip->camera_ve = $log->camera;
                            $orphanTrip->thoi_gian_ve = $log->thoi_gian;
                            $orphanTrip->trang_thai = XeLuotRaVao::TRANG_THAI_LOI_VE_KHONG_DI;
                            $orphanTrip->save(false);

                            $createdTripsCount++;
                        }
                    }
                } else {
                    // XE NGOÀI TẠI CỔNG CĂN TIN: VAO vào trường -> RA rời trường
                    // Đảm bảo log của xe ngoài có trang_thai_ke_hoach là INFO
                    if ($log->hasAttribute('trang_thai_ke_hoach') && $log->trang_thai_ke_hoach !== XeLuotRaVao::KE_HOACH_INFO) {
                        $log->trang_thai_ke_hoach = XeLuotRaVao::KE_HOACH_INFO;
                        $log->save(false);
                    }

                    if ($chieu === 'VAO') {
                        // Sự kiện XE LẠ VÀO TRƯỜNG
                        if (isset($pendingByGate[$cong]) && $pendingByGate[$cong] !== null) {
                            $pendingByGate[$cong]->trang_thai = XeLuotRaVao::TRANG_THAI_LOI_VAO_KHONG_RA;
                            $pendingByGate[$cong]->save(false);
                            $createdTripsCount++;
                        }

                        $newTrip = new XeLuotRaVao();
                        $newTrip->ma_xe = $cleanMaXe;
                        $newTrip->bien_so_xe = $log->bien_so_xe ?: $cleanMaXe;
                        $newTrip->id_xe = null;
                        $newTrip->loai_xe = XeLuotRaVao::LOAI_XE_NGOAI;
                        $newTrip->kieu_luot = XeLuotRaVao::KIEU_LUOT_VAO_RA;
                        $newTrip->log_di_id = $log->id; // Log 1: Vào
                        $newTrip->camera_di = $log->camera;
                        $newTrip->thoi_gian_di = $log->thoi_gian;
                        $newTrip->trang_thai_ke_hoach = XeLuotRaVao::KE_HOACH_INFO;
                        $newTrip->trang_thai = XeLuotRaVao::TRANG_THAI_DANG_TRONG_SAN;

                        $pendingByGate[$cong] = $newTrip;
                    } elseif ($chieu === 'RA') {
                        // Sự kiện XE LẠ RỜI TRƯỜNG
                        if (isset($pendingByGate[$cong]) && $pendingByGate[$cong] !== null) {
                            $trip = $pendingByGate[$cong];
                            $trip->log_ve_id = $log->id; // Log 2: Ra
                            $trip->camera_ve = $log->camera;
                            $trip->thoi_gian_ve = $log->thoi_gian;

                            $tsVao = strtotime($trip->thoi_gian_di);
                            $tsRa = strtotime($log->thoi_gian);
                            $soPhut = max(0, (int)round(($tsRa - $tsVao) / 60));

                            $trip->so_phut_o_ngoai = $soPhut;
                            $trip->thoi_gian_o_ngoai_label = XeLuotRaVao::formatPhutToLabel($soPhut);
                            $trip->trang_thai = XeLuotRaVao::TRANG_THAI_HOAN_THANH;
                            $trip->save(false);

                            $createdTripsCount++;
                            $pendingByGate[$cong] = null;
                        } else {
                            $orphanTrip = new XeLuotRaVao();
                            $orphanTrip->ma_xe = $cleanMaXe;
                            $orphanTrip->bien_so_xe = $log->bien_so_xe ?: $cleanMaXe;
                            $orphanTrip->id_xe = null;
                            $orphanTrip->loai_xe = XeLuotRaVao::LOAI_XE_NGOAI;
                            $orphanTrip->kieu_luot = XeLuotRaVao::KIEU_LUOT_VAO_RA;
                            $orphanTrip->log_ve_id = $log->id;
                            $orphanTrip->camera_ve = $log->camera;
                            $orphanTrip->thoi_gian_ve = $log->thoi_gian;
                            $orphanTrip->trang_thai_ke_hoach = XeLuotRaVao::KE_HOACH_INFO;
                            $orphanTrip->trang_thai = XeLuotRaVao::TRANG_THAI_LOI_RA_KHONG_VAO;
                            $orphanTrip->save(false);

                            $createdTripsCount++;
                        }
                    }
                }
            }
        }

        // Lưu các chuyến còn đang dở dang ở các cổng
        foreach ($pendingByGate as $gateKey => $pTrip) {
            if ($pTrip !== null) {
                $pTrip->save(false);
                $createdTripsCount++;
            }
        }

        return $createdTripsCount;
    }

    /**
     * Tái tạo và tính toán lại toàn bộ các lượt đi - về / vào - ra từ logs của tất cả các xe
     *
     * @param string|null $tuNgay
     * @param string|null $denNgay
     * @return array Thống kê kết quả
     */
    public static function rebuildAllTrips($tuNgay = null, $denNgay = null)
    {
        // 1. Lấy danh sách tất cả các xe có phát sinh log
        $query = XeCameraLogs::find()
            ->select(['ma_xe'])
            ->distinct()
            ->where(['or', ['is_deleted' => 0], ['is_deleted' => null]]);

        if (!empty($tuNgay)) {
            $query->andWhere(['>=', 'thoi_gian', $tuNgay . ' 00:00:00']);
        }
        if (!empty($denNgay)) {
            $query->andWhere(['<=', 'thoi_gian', $denNgay . ' 23:59:59']);
        }

        $vehicles = $query->asArray()->all();

        $totalVehicles = 0;
        $totalTrips = 0;

        foreach ($vehicles as $item) {
            $maXe = $item['ma_xe'];
            if (!empty($maXe)) {
                $trips = self::syncVehicleTrips($maXe);
                $totalTrips += $trips;
                $totalVehicles++;
            }
        }

        return [
            'success' => true,
            'total_vehicles' => $totalVehicles,
            'total_trips' => $totalTrips,
            'message' => "Đã đồng bộ lại thành công {$totalTrips} lượt xe của {$totalVehicles} phương tiện."
        ];
    }
}
