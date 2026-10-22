<?php

namespace app\modules\thuexe\models\base;

use Yii;
use app\models\PtxXeLuotRaVao;
use app\modules\thuexe\models\Xe;
use app\modules\thuexe\models\XeCameraLogs;
use yii\helpers\Html;

/**
 * Class XeLuotRaVaoBase
 * @package app\modules\thuexe\models\base
 */
class XeLuotRaVaoBase extends PtxXeLuotRaVao
{
    const TRANG_THAI_HOAN_THANH = 'HOAN_THANH';
    const TRANG_THAI_DANG_O_NGOAI = 'DANG_O_NGOAI';
    const TRANG_THAI_DANG_TRONG_SAN = 'DANG_TRONG_SAN';
    const TRANG_THAI_LOI_DI_KHONG_VE = 'LOI_DI_KHONG_VE';
    const TRANG_THAI_LOI_VE_KHONG_DI = 'LOI_VE_KHONG_DI';
    const TRANG_THAI_LOI_VAO_KHONG_RA = 'LOI_VAO_KHONG_RA';
    const TRANG_THAI_LOI_RA_KHONG_VAO = 'LOI_RA_KHONG_VAO';

    const LOAI_XE_NOI_BO = 'NOI_BO';
    const LOAI_XE_NGOAI = 'XE_NGOAI';

    const KIEU_LUOT_DI_VE = 'DI_VE';
    const KIEU_LUOT_VAO_RA = 'VAO_RA';

    const KE_HOACH_APPROVED = 'APPROVED';
    const KE_HOACH_UNPLANNED = 'UNPLANNED';
    const KE_HOACH_INFO = 'INFO';

    const STATUS_ACTIVE = 0;
    const STATUS_DELETED = 1;

    const QUA_DEM_KHONG = 0;
    const QUA_DEM_CO = 1;

    /**
     * Danh mục qua đêm
     * @return array
     */
    public static function getDmQuaDem()
    {
        return [
            self::QUA_DEM_CO => 'Xe qua đêm',
            self::QUA_DEM_KHONG => 'Không qua đêm',
        ];
    }

    /**
     * Danh mục loại xe
     * @return array
     */
    public static function getDmLoaiXe()
    {
        return [
            self::LOAI_XE_NOI_BO => 'Xe nội bộ',
            self::LOAI_XE_NGOAI => 'Xe ngoài / Khách',
        ];
    }

    /**
     * Badge loại xe
     * @return string
     */
    public function getLoaiXeBadge()
    {
        if ($this->loai_xe === self::LOAI_XE_NOI_BO) {
            return '<span class="badge bg-primary">Xe nội bộ</span>';
        }
        return '<span class="badge bg-secondary">Xe ngoài</span>';
    }

    /**
     * Danh mục trạng thái chuyến đi
     * @return array
     */
    public static function getDmTrangThai()
    {
        return [
            self::TRANG_THAI_HOAN_THANH => 'Hoàn thành',
            self::TRANG_THAI_DANG_O_NGOAI => 'Đang ở ngoài',
            self::TRANG_THAI_DANG_TRONG_SAN => 'Đang trong sân',
            self::TRANG_THAI_LOI_DI_KHONG_VE => 'Lỗi: Đi không có về',
            self::TRANG_THAI_LOI_VE_KHONG_DI => 'Lỗi: Về không có lượt đi',
            self::TRANG_THAI_LOI_VAO_KHONG_RA => 'Lỗi: Vào chưa có lượt ra',
            self::TRANG_THAI_LOI_RA_KHONG_VAO => 'Lỗi: Ra không có lượt vào',
        ];
    }

    /**
     * Danh muc trang thai color
     * @return string[]
     */
    public static function getDmTrangThaiColor()
    {
        return [
            '' => '#ddd',
            self::TRANG_THAI_HOAN_THANH => 'var(--success)',
            self::TRANG_THAI_DANG_O_NGOAI => 'var(--warning)',
            self::TRANG_THAI_DANG_TRONG_SAN => 'var(--warning)',
            self::TRANG_THAI_LOI_DI_KHONG_VE => 'var(--warning)',
            self::TRANG_THAI_LOI_VE_KHONG_DI => 'var(--danger)',
            self::TRANG_THAI_LOI_VAO_KHONG_RA => 'var(--danger)',
            self::TRANG_THAI_LOI_RA_KHONG_VAO => 'var(--danger)',
        ];
    }

    /**
     * Danh mục trạng thái kế hoạch
     * @return array
     */
    public static function getDmKeHoach()
    {
        return [
            self::KE_HOACH_APPROVED => 'Xe có kế hoạch',
            self::KE_HOACH_UNPLANNED => 'Xe không kế hoạch',
            self::KE_HOACH_INFO => 'Xe khách ngoài',
        ];
    }

    /**
     * Nhãn trạng thái chuyến đi
     * @return string
     */
    public function getTrangThaiLabel()
    {
        $list = self::getDmTrangThai();
        return $list[$this->trang_thai] ?? $this->trang_thai;
    }

    /**
     * Badge màu trạng thái chuyến đi
     * @return string
     */
    public function getTrangThaiBadge()
    {
        switch ($this->trang_thai) {
            case self::TRANG_THAI_HOAN_THANH:
                return '<span class="badge bg-success"><i class="fa fa-check-circle me-1"></i> Hoàn thành</span>';
            case self::TRANG_THAI_DANG_O_NGOAI:
                return '<span class="badge bg-warning text-dark"><i class="fa fa-clock-o me-1"></i> Đang ở ngoài</span>';
            case self::TRANG_THAI_DANG_TRONG_SAN:
                return '<span class="badge bg-info text-dark"><i class="fa fa-clock-o me-1"></i> Đang trong sân</span>';
            case self::TRANG_THAI_LOI_DI_KHONG_VE:
                return '<span class="badge bg-danger"><i class="fa fa-exclamation-triangle me-1"></i> Lỗi: Đi không có về</span>';
            case self::TRANG_THAI_LOI_VE_KHONG_DI:
                return '<span class="badge bg-danger"><i class="fa fa-exclamation-circle me-1"></i> Lỗi: Về không có lượt đi</span>';
            case self::TRANG_THAI_LOI_VAO_KHONG_RA:
                return '<span class="badge bg-danger"><i class="fa fa-exclamation-triangle me-1"></i> Lỗi: Vào chưa có lượt ra</span>';
            case self::TRANG_THAI_LOI_RA_KHONG_VAO:
                return '<span class="badge bg-danger"><i class="fa fa-exclamation-circle me-1"></i> Lỗi: Ra không có lượt vào</span>';
            default:
                return '<span class="badge bg-secondary">' . ($this->trang_thai ?: 'N/A') . '</span>';
        }
    }

    /**
     * Nhãn kế hoạch lúc đi
     * @return string
     */
    public function getKeHoachLabel()
    {
        $list = self::getDmKeHoach();
        return $list[$this->trang_thai_ke_hoach] ?? ($this->trang_thai_ke_hoach ?: 'Chưa xác định');
    }

    /**
     * Badge kế hoạch lúc đi
     * @return string
     */
    public function getKeHoachBadge()
    {
        switch ($this->trang_thai_ke_hoach) {
            case self::KE_HOACH_APPROVED:
                return '<span class="badge bg-success">Có kế hoạch</span>';
            case self::KE_HOACH_UNPLANNED:
                return '<span class="badge bg-secondary">Không kế hoạch</span>';
            case self::KE_HOACH_INFO:
                return '<span class="badge bg-info">Xe ngoài</span>';
            default:
                return '<span class="badge bg-light text-dark">N/A</span>';
        }
    }

    public function getSuKienIcon()
    {
        switch ($this->trang_thai_ke_hoach) {
            case self::KE_HOACH_APPROVED:
                return '';
            case self::KE_HOACH_UNPLANNED:
                return Html::img('/libs/images/icons/red-card.gif', ['width' => '22', 'title' => 'ĐI KHÔNG KẾ HOẠCH']);
            case self::KE_HOACH_INFO:
                return '';
            default:
                return '';
        }
    }

    /**
     * Quy đổi số phút ra chuỗi định dạng
     * @param int|null $soPhut
     * @return string
     */
    public static function formatPhutToLabel($soPhut)
    {
        if ($soPhut === null || $soPhut < 0) {
            return '';
        }
        $hours = floor($soPhut / 60);
        $minutes = $soPhut % 60;

        $timeStr = sprintf('%d:%02d', $hours, $minutes);
        if ($hours > 0 && $minutes > 0) {
            $desc = "{$hours} giờ {$minutes} phút";
        } elseif ($hours > 0) {
            $desc = "{$hours} giờ";
        } else {
            $desc = "{$minutes} phút";
        }

        //return "{$timeStr} ({$desc})";
        return "{$timeStr}";
    }

    /**
     * Alias getter for so_phut_o_ngoai
     * @return int|null
     */
    public function getThoi_gian_o_ngoai_phut()
    {
        return $this->so_phut_o_ngoai;
    }

    /**
     * Quan hệ tới model Xe nội bộ
     * @return \yii\db\ActiveQuery
     */
    public function getXe()
    {
        if (!empty($this->id_xe)) {
            return $this->hasOne(Xe::class, ['id' => 'id_xe']);
        }
        return $this->hasOne(Xe::class, ['ma_bien_so' => 'ma_xe']);
    }

    /**
     * get loiạ xe theo id_xe
     */
    public function getLoaiXe()
    {
        if ($this->id_xe) {
            return '<span class="badge bg-primary">' . $this->xe->labelPhanLoaiXe . '</span>';
        } else {
            return '<span class="badge bg-info">Xe khách</span>';
        }
    }

    /**
     * Quan hệ tới log Đi (Mặt trước)
     * @return \yii\db\ActiveQuery
     */
    public function getLogDi()
    {
        return $this->hasOne(XeCameraLogs::class, ['id' => 'log_di_id']);
    }

    /**
     * Quan hệ tới log Về (Mặt sau)
     * @return \yii\db\ActiveQuery
     */
    public function getLogVe()
    {
        return $this->hasOne(XeCameraLogs::class, ['id' => 'log_ve_id']);
    }

    /**
     * Tên cổng/camera lượt đi (hoặc vào)
     * @return string
     */
    public function getTenCameraDi()
    {
        if (empty($this->camera_di)) {
            return '';
        }
        $dm = XeCameraLogs::getDmCamera();
        return $dm[$this->camera_di] ?? $this->camera_di;
    }

    /**
     * Tên cổng/camera lượt về (hoặc ra)
     * @return string
     */
    public function getTenCameraVe()
    {
        if (empty($this->camera_ve)) {
            return '';
        }
        $dm = XeCameraLogs::getDmCamera();
        return $dm[$this->camera_ve] ?? $this->camera_ve;
    }

    /**
     * Badge hiển thị xe qua đêm
     * @return string
     */
    public function getQuaDemBadge()
    {
        if ($this->qua_dem) {
            // return '<span class="badge bg-purple"><i class="fa fa-moon-o me-1"></i>Qua đêm</span>';
            return Html::img('/libs/images/icons/night.gif', ['width' => '20', 'title' => 'XE QUA ĐÊM']);
        }
        return '';
    }

    /**
     * Thuật toán kiểm tra chuyến xe có qua đêm hay không
     * Quy tắc:
     * - Phiên đi về có chứa khoảng thời gian 00:00 - 05:00 sáng.
     * - Nếu xuất phát trong khoảng 00-05h của cùng ngày thì không tính, chỉ tính qua ngày sau (nếu có).
     *
     * @param string|null $thoiGianDi
     * @param string|null $thoiGianVe
     * @param string|null $trangThai
     * @return bool
     */
    public static function kiemTraQuaDem($thoiGianDi, $thoiGianVe, $trangThai = null)
    {
        if (empty($thoiGianDi)) {
            return false;
        }

        $tsStart = strtotime($thoiGianDi);
        // Nếu chưa có thời gian về (đang ở ngoài hoặc đang trong sân), lấy thời gian hiện tại
        $tsEnd = !empty($thoiGianVe) ? strtotime($thoiGianVe) : time();

        if ($tsEnd <= $tsStart) {
            return false;
        }

        $dateStart = date('Y-m-d', $tsStart);
        $dateEnd = date('Y-m-d', $tsEnd);

        // Nếu bắt đầu và kết thúc cùng 1 ngày lịch:
        // Do xuất phát trong 00-05h cùng ngày không tính, nên phiên trọn vẹn trong 1 ngày KHÔNG qua đêm
        if ($dateStart === $dateEnd) {
            return false;
        }

        // Nếu phiên kéo dài sang ngày hôm sau hoặc nhiều ngày sau:
        // Kiểm tra xem phiên [tsStart, tsEnd] có chứa mốc nửa đêm (00:00) của ngày kế tiếp hay không
        $currentDate = strtotime('+1 day', strtotime($dateStart));
        $endDateTs = strtotime($dateEnd);

        while ($currentDate <= $endDateTs) {
            $nightStart = strtotime(date('Y-m-d 00:00:00', $currentDate));
            if ($tsEnd >= $nightStart) {
                return true;
            }
            $currentDate = strtotime('+1 day', $currentDate);
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert)
    {
        $now = date('Y-m-d H:i:s');
        if ($this->isNewRecord) {
            if (empty($this->created_at)) {
                $this->created_at = $now;
            }
        }
        $this->updated_at = $now;

        // Tự động tìm xe nội bộ nếu chưa gán id_xe
        if (empty($this->id_xe) && !empty($this->ma_xe)) {
            $car = Xe::find()->where(['ma_bien_so' => $this->ma_xe])->one();
            if ($car) {
                $this->id_xe = $car->id;
            }
        }

        // Tự động thiết lập loai_xe và kieu_luot nếu chưa có
        if (empty($this->loai_xe)) {
            if (!empty($this->id_xe)) {
                $this->loai_xe = self::LOAI_XE_NOI_BO;
                $this->kieu_luot = self::KIEU_LUOT_DI_VE;
            } else {
                $this->loai_xe = self::LOAI_XE_NGOAI;
                $this->kieu_luot = self::KIEU_LUOT_VAO_RA;
            }
        }

        // Tự động cập nhật nhãn thời gian ở ngoài nếu có số phút
        if ($this->so_phut_o_ngoai !== null && empty($this->thoi_gian_o_ngoai_label)) {
            $this->thoi_gian_o_ngoai_label = self::formatPhutToLabel($this->so_phut_o_ngoai);
        }

        // Tự động tính toán trạng thái qua đêm
        $this->qua_dem = self::kiemTraQuaDem($this->thoi_gian_di, $this->thoi_gian_ve, $this->trang_thai)
            ? self::QUA_DEM_CO
            : self::QUA_DEM_KHONG;

        return parent::beforeSave($insert);
    }
}
