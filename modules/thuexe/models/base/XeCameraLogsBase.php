<?php

namespace app\modules\thuexe\models\base;

use Yii;
use app\models\PtxXeCameraLogs;
use app\modules\thuexe\models\Xe;

/**
 * Class XeCameraLogsBase
 * @package app\modules\thuexe\models\base
 */
class XeCameraLogsBase extends PtxXeCameraLogs
{
    const CONG_CAN_TIN = 'CONG_CAN_TIN';
    const CONG_CANTIN = 'CONG_CAN_TIN';
    const CONG_SAN_CAM_BIEN = 'CONG_SAN_CAM_BIEN';

    const CAMERA_CONG_CAN_TIN = 'cong_can_tin';
    const CAMERA_CONG_CANTIN = 'cong_can_tin';
    const CAMERA_CONG_SAN_CAM_BIEN = 'cong_san_cam_bien';
    const CAMERA_CONG_SAN_CAM_BIEN_RA = 'cong_san_cam_bien_ra';
    const CAMERA_CONG_SAN_CAM_BIEN_VAO = 'cong_san_cam_bien_vao';

    const SU_KIEN_MAT_TRUOC = 'mat_truoc';
    const SU_KIEN_MAT_SAU = 'mat_sau';

    const STATUS_ACTIVE = 0;
    const STATUS_DELETED = 1;

    /**
     * Danh sách hằng số camera
     * @return array
     */
    public static function getDmCamera()
    {
        return [
            /* self::CAMERA_CONG_CAN_TIN => 'Cổng căn tin (cong_can_tin)',
            self::CAMERA_CONG_SAN_CAM_BIEN => 'Cổng sân cảm biến (cong_san_cam_bien)',
            'cong_cantin' => 'Cổng căn tin (cong_cantin)',
            self::CAMERA_CONG_SAN_CAM_BIEN_RA => 'Cổng sân cảm biến - Làn Ra (cong_san_cam_bien_ra)',
            self::CAMERA_CONG_SAN_CAM_BIEN_VAO => 'Cổng sân cảm biến - Làn Vào (cong_san_cam_bien_vao)', */
            self::CAMERA_CONG_CAN_TIN => 'Cổng căn tin', //cong_can_tin
            self::CAMERA_CONG_SAN_CAM_BIEN => 'Cổng sân cảm biến', //cong_san_cam_bien
            'cong_cantin' => 'Cổng căn tin', //cong_cantin
            self::CAMERA_CONG_SAN_CAM_BIEN_RA => 'Cổng sân cảm biến - Làn Ra', //cong_san_cam_bien_ra
            self::CAMERA_CONG_SAN_CAM_BIEN_VAO => 'Cổng sân cảm biến - Làn Vào', //cong_san_cam_bien_vao
        ];
    }

    /**
     * Danh sách các cổng kiểm soát
     * @return array
     */
    public static function getDmCong()
    {
        return [
            self::CONG_CAN_TIN => 'Cổng căn tin',
            self::CONG_SAN_CAM_BIEN => 'Cổng sân cảm biến',
        ];
    }

    /**
     * Danh sách hằng số sự kiện
     * @return array
     */
    public static function getDmSuKien()
    {
        return [
            self::SU_KIEN_MAT_TRUOC => 'Mặt trước',
            self::SU_KIEN_MAT_SAU => 'Mặt sau',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['camera'], 'in', 'range' => array_keys(self::getDmCamera()), 'message' => '{attribute} không hợp lệ. Chỉ chấp nhận ' . implode(', ', array_keys(self::getDmCamera()))],
            [['su_kien'], 'in', 'range' => array_keys(self::getDmSuKien()), 'message' => '{attribute} không hợp lệ. Chỉ chấp nhận ' . implode(', ', array_keys(self::getDmSuKien()))],
        ]);
    }

    /**
     * Chuẩn hóa biển số xe thành mã xe (chỉ gồm chữ và số in hoa)
     * @param string|null $bienSo
     * @return string
     */
    public static function chuanHoaMaXe($bienSo)
    {
        if (empty($bienSo)) {
            return '';
        }
        return strtoupper(preg_replace('/[^a-zA-Z0-9]/', '', (string)$bienSo));
    }

    /**
     * Nhận diện và ánh xạ mã camera từ chuỗi hoặc ID số
     * @param mixed $input
     * @return string|null
     */
    public static function parseMaCamera($input)
    {
        if (empty($input)) {
            return null;
        }

        $str = strtolower(trim((string)$input));
        if (
            $str === self::CAMERA_CONG_CAN_TIN
            || $str === 'cong_cantin'
            || $str === self::CAMERA_CONG_SAN_CAM_BIEN
            || $str === self::CAMERA_CONG_SAN_CAM_BIEN_RA
            || $str === self::CAMERA_CONG_SAN_CAM_BIEN_VAO
            || $str === 'cong_san_cam_bien_va'
        ) {
            if ($str === 'cong_san_cam_bien_va') return self::CAMERA_CONG_SAN_CAM_BIEN_VAO;
            if ($str === 'cong_cantin') return self::CAMERA_CONG_CAN_TIN;
            return $str;
        }

        // Nếu gửi số nguyên: 1 -> Căn tin, 2 -> Sân cảm biến Ra (hoặc chung), 3 -> Sân cảm biến Vào
        if (is_numeric($input)) {
            $num = (int)$input;
            if ($num === 1) return self::CAMERA_CONG_CAN_TIN;
            if ($num === 2) return self::CAMERA_CONG_SAN_CAM_BIEN_RA;
            if ($num === 3) return self::CAMERA_CONG_SAN_CAM_BIEN_VAO;
            return self::CAMERA_CONG_SAN_CAM_BIEN;
        }

        // Tìm kiếm theo từ khóa nếu gửi tên camera
        if (str_contains($str, 'can tin') || str_contains($str, 'cantin') || str_contains($str, 'căn tin')) {
            return self::CAMERA_CONG_CAN_TIN;
        }
        if (str_contains($str, 'san') || str_contains($str, 'sân') || str_contains($str, 'cam_bien') || str_contains($str, 'cảm biến')) {
            if (str_contains($str, 'ra') || str_contains($str, 'out') || str_contains($str, 'exit')) {
                return self::CAMERA_CONG_SAN_CAM_BIEN_RA;
            }
            if (str_contains($str, 'vao') || str_contains($str, 'vào') || str_contains($str, 'in') || str_contains($str, 'entry') || str_ends_with($str, '_va') || str_ends_with($str, 'va')) {
                return self::CAMERA_CONG_SAN_CAM_BIEN_VAO;
            }
            return self::CAMERA_CONG_SAN_CAM_BIEN;
        }

        return (string)$input;
    }

    /**
     * Xác định Cổng và Chiều chuyển động (RA / VAO) từ thông tin camera và sự kiện
     * 
     * Quy tắc nghiệp vụ:
     * - Cổng Căn Tin (1 Camera):
     *   + Xe nội bộ: mat_truoc -> RA, mat_sau -> VAO
     *   + Xe lạ: mat_sau -> VAO, mat_truoc -> RA
     * - Cổng Sân Cảm Biến (2 Camera đều đọc mặt trước):
     *   + cong_san_cam_bien_ra -> luôn là RA (cho cả xe nội bộ và xe lạ)
     *   + cong_san_cam_bien_vao -> luôn là VAO (cho cả xe nội bộ và xe lạ)
     *   + cong_san_cam_bien (mã chung/1 cam): theo su_kien tương tự Căn Tin
     * 
     * @param string|null $camera
     * @param string|null $suKien
     * @param bool $isNoiBo
     * @return array ['cong' => string, 'chieu' => 'RA'|'VAO', 'ten_cong' => string, 'camera' => string]
     */
    public static function xacDinhCongVaChieu($camera, $suKien, $isNoiBo = true)
    {
        $cameraParsed = self::parseMaCamera($camera);
        $suKienNorm = ($suKien === self::SU_KIEN_MAT_SAU) ? self::SU_KIEN_MAT_SAU : self::SU_KIEN_MAT_TRUOC;

        if ($cameraParsed === self::CAMERA_CONG_CAN_TIN || $cameraParsed === 'cong_cantin') {
            $cong = self::CONG_CAN_TIN;
            $tenCong = 'Cổng căn tin';
            if ($isNoiBo) {
                $chieu = ($suKienNorm === self::SU_KIEN_MAT_TRUOC) ? 'RA' : 'VAO';
            } else {
                $chieu = ($suKienNorm === self::SU_KIEN_MAT_SAU) ? 'VAO' : 'RA';
            }
        } elseif ($cameraParsed === self::CAMERA_CONG_SAN_CAM_BIEN_RA) {
            $cong = self::CONG_SAN_CAM_BIEN;
            $tenCong = 'Cổng sân cảm biến (Làn Ra)';
            $chieu = 'RA';
        } elseif ($cameraParsed === self::CAMERA_CONG_SAN_CAM_BIEN_VAO || $cameraParsed === 'cong_san_cam_bien_va') {
            $cong = self::CONG_SAN_CAM_BIEN;
            $tenCong = 'Cổng sân cảm biến (Làn Vào)';
            $chieu = 'VAO';
        } else {
            // cong_san_cam_bien (mã chung)
            $cong = self::CONG_SAN_CAM_BIEN;
            $tenCong = 'Cổng sân cảm biến';
            if ($isNoiBo) {
                $chieu = ($suKienNorm === self::SU_KIEN_MAT_TRUOC) ? 'RA' : 'VAO';
            } else {
                $chieu = ($suKienNorm === self::SU_KIEN_MAT_SAU) ? 'VAO' : 'RA';
            }
        }

        return [
            'cong' => $cong,
            'chieu' => $chieu,
            'ten_cong' => $tenCong,
            'camera' => $cameraParsed ?: (string)$camera,
        ];
    }

    /**
     * Nhãn hiển thị của camera
     * @return string
     */
    public function getCameraLabel()
    {
        $list = self::getDmCamera();
        return $list[$this->camera] ?? $this->camera;
    }

    /**
     * Badge hiển thị của camera
     * @return string
     */
    public function getCameraBadge()
    {
        if (
            $this->camera === self::CAMERA_CONG_SAN_CAM_BIEN
            || $this->camera === self::CAMERA_CONG_SAN_CAM_BIEN_RA
            || $this->camera === self::CAMERA_CONG_SAN_CAM_BIEN_VAO
        ) {
            return '<span class="badge bg-primary">' . $this->getCameraLabel() . '</span>';
        } elseif ($this->camera === self::CAMERA_CONG_CANTIN) {
            return '<span class="badge bg-info">' . $this->getCameraLabel() . '</span>';
        }
        return '<span class="badge bg-secondary">' . ($this->camera ?: 'N/A') . '</span>';
    }


    /**
     * Nhãn hiển thị của sự kiện
     * @return string
     */
    public function getSuKienLabel()
    {
        $list = self::getDmSuKien();
        return $list[$this->su_kien] ?? $this->su_kien;
    }

    /**
     * Badge hiển thị của sự kiện
     * @return string
     */
    public function getSuKienBadge()
    {
        if ($this->su_kien === self::SU_KIEN_MAT_TRUOC) {
            return '<span class="badge bg-success">' . $this->getSuKienLabel() . '</span>';
        } elseif ($this->su_kien === self::SU_KIEN_MAT_SAU) {
            return '<span class="badge bg-warning text-dark">' . $this->getSuKienLabel() . '</span>';
        }
        return '<span class="badge bg-secondary">' . ($this->su_kien ?: 'N/A') . '</span>';
    }

    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            if ($this->nguoi_tao == null && isset(Yii::$app->user) && !Yii::$app->user->isGuest) {
                $this->nguoi_tao = Yii::$app->user->id;
            }
            if ($this->thoi_gian_tao == null) {
                $this->thoi_gian_tao = date('Y-m-d H:i:s');
            }
        }
        if (!empty($this->bien_so_xe) && empty($this->ma_xe)) {
            $this->ma_xe = self::chuanHoaMaXe($this->bien_so_xe);
        }
        return parent::beforeSave($insert);
    }

    /**
     * Quan hệ liên kết tới Xe (thông qua ma_xe = ma_bien_so)
     * @return \yii\db\ActiveQuery
     */
    public function getXe()
    {
        return $this->hasOne(Xe::class, ['ma_bien_so' => 'ma_xe']);
    }
}
