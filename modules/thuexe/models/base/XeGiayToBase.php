<?php

namespace app\modules\thuexe\models\base;

use Yii;
use app\models\PtxXeGiayTo;
use app\custom\CustomFunc;
use app\modules\thuexe\models\LoaiGiayTo;
use app\modules\thuexe\models\Xe;
use app\modules\user\models\User;

/**
 * Class XeGiayToBase
 * @package app\modules\thuexe\models\base
 */
class XeGiayToBase extends PtxXeGiayTo
{
    const MODEL_ID = 'giaytoxe';

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    const HAN_CON_HAN = 'CON_HAN';
    const HAN_SAP_HET = 'SAP_HET';
    const HAN_DA_HET = 'DA_HET';
    const HAN_KHONG_GIOI_HAN = 'KHONG_GIOI_HAN';
    const HAN_CHUA_CO = 'CHUA_CO';
    const HAN_KHONG_XET = 'KHONG_XET';

    /**
     * Danh mục hiệu lực
     * @return array
     */
    public static function getDmIsActive()
    {
        return [
            self::STATUS_ACTIVE => 'Có hiệu lực',
            self::STATUS_INACTIVE => 'Ngưng sử dụng',
        ];
    }

    /**
     * Badge nhãn hiệu lực
     * @return string
     */
    public function getIsActiveLabel()
    {
        if ($this->is_active == self::STATUS_ACTIVE) {
            return '<span class="badge bg-success">Hiệu lực</span>';
        }
        return '<span class="badge bg-secondary">Ngưng dùng</span>';
    }

    /**
     * Thống kê số lượng giấy tờ sắp hết hạn hoặc quá hạn của toàn hệ thống
     * @return array ['qua_han' => int, 'sap_het' => int, 'tong' => int]
     */
    public static function getThongKeHetHan()
    {
        $allActive = self::find()
            ->joinWith('loaiGiayTo')
            ->where([
                'ptx_xe_giay_to.is_active' => self::STATUS_ACTIVE,
                'ptx_xe_loai_giay_to.check_het_han' => LoaiGiayToBase::CHECK_HET_HAN_CO,
            ])
            ->all();

        $quaHan = 0;
        $sapHet = 0;

        foreach ($allActive as $doc) {
            $han = $doc->getTrangThaiHan();
            if ($han === self::HAN_DA_HET) {
                $quaHan++;
            } elseif ($han === self::HAN_SAP_HET) {
                $sapHet++;
            }
        }

        return [
            'qua_han' => $quaHan,
            'sap_het' => $sapHet,
            'tong' => $quaHan + $sapHet,
        ];
    }

    /**
     * Kiểm tra bản ghi này có phải là giấy tờ active mới nhất của loại giấy tờ này trên xe không
     * (search giấy tờ SORT_BY id DESC and is_active = 1)
     * @return bool
     */
    public function isLatestActive()
    {
        if ($this->is_active != self::STATUS_ACTIVE) {
            return false;
        }
        $latest = self::find()
            ->where([
                'id_xe' => $this->id_xe,
                'id_loai_giay_to' => $this->id_loai_giay_to,
                'is_active' => self::STATUS_ACTIVE,
            ])
            ->orderBy(['id' => SORT_DESC])
            ->one();

        return $latest && $latest->id == $this->id;
    }

    /**
     * Tính trạng thái thời hạn của giấy tờ
     * - Nếu is_active != 1: không xét hạn
     * - Nếu loại giấy tờ có check_het_han = 0: không thời hạn
     * - Nếu check_het_han = 1: kiểm tra tiếp giấy tờ mới nhất có is_active = 1 (id DESC).
     *   + Nếu bản ghi này cũ hơn bản ghi active mới nhất: hiển thị "Đã hết hạn"
     *   + Nếu là bản ghi mới nhất: kiểm tra ngày hết hạn so với so_ngay_bao_truoc của loại giấy tờ
     * @return string
     */
    public function getTrangThaiHan()
    {
        // 1. Nếu không kích hoạt, không xét hạn
        if ($this->is_active != self::STATUS_ACTIVE) {
            return self::HAN_KHONG_XET;
        }

        // 2. Nếu loại giấy tờ không theo dõi hạn
        if ($this->loaiGiayTo && $this->loaiGiayTo->check_het_han == LoaiGiayToBase::CHECK_HET_HAN_KHONG) {
            return self::HAN_KHONG_GIOI_HAN;
        }

        // 3. Nếu check_het_han = 1, tìm giấy tờ active mới nhất
        if ($this->id_xe && $this->id_loai_giay_to) {
            $latest = self::find()
                ->where([
                    'id_xe' => $this->id_xe,
                    'id_loai_giay_to' => $this->id_loai_giay_to,
                    'is_active' => self::STATUS_ACTIVE,
                ])
                ->orderBy(['id' => SORT_DESC])
                ->one();

            // Nếu đây không phải bản ghi active mới nhất (đã có bản ghi active sau thay thế)
            if (!$this->isNewRecord && $latest && $latest->id != $this->id) {
                return self::HAN_DA_HET;
            }
        }

        // 4. Kiểm tra ngày hết hạn của bản ghi mới nhất
        if (empty($this->ngay_ket_thuc)) {
            return self::HAN_CHUA_CO;
        }

        $now = strtotime(date('Y-m-d'));
        $hetHan = strtotime(date('Y-m-d', strtotime($this->ngay_ket_thuc)));

        if ($hetHan < $now) {
            return self::HAN_DA_HET;
        }

        // Cảnh báo trước theo so_ngay_bao_truoc của loại giấy tờ (mặc định 30 ngày)
        $soNgayBaoTruoc = $this->loaiGiayTo ? $this->loaiGiayTo->getSoNgayBaoTruocVal() : LoaiGiayToBase::DEFAULT_SO_NGAY_BAO_TRUOC;
        $warningTime = strtotime("+{$soNgayBaoTruoc} days", $now);
        if ($hetHan <= $warningTime) {
            return self::HAN_SAP_HET;
        }

        return self::HAN_CON_HAN;
    }

    /**
     * Badge hiển thị trạng thái hạn
     * @return string
     */
    public function getTrangThaiHanLabel()
    {
        $status = $this->getTrangThaiHan();
        switch ($status) {
            case self::HAN_DA_HET:
                return '<span class="badge bg-danger"><i class="fa fa-times-circle"></i> Đã hết hạn</span>';
            case self::HAN_SAP_HET:
                $soNgay = $this->loaiGiayTo ? $this->loaiGiayTo->getSoNgayBaoTruocVal() : LoaiGiayToBase::DEFAULT_SO_NGAY_BAO_TRUOC;
                return '<span class="badge bg-warning text-dark" title="Cảnh báo trước ' . $soNgay . ' ngày"><i class="fa fa-exclamation-triangle"></i> Sắp hết hạn</span>';
            case self::HAN_CON_HAN:
                return '<span class="badge bg-success"><i class="fa fa-check-circle"></i> Còn hạn</span>';
            case self::HAN_KHONG_GIOI_HAN:
                return '<span class="badge bg-info">Không thời hạn</span>';
            case self::HAN_KHONG_XET:
                return '<span class="badge bg-secondary">Không xét</span>';
            case self::HAN_CHUA_CO:
                return '<span class="badge bg-secondary">Chưa có ngày hết hạn</span>';
            default:
                return '<span class="badge bg-secondary">Chưa xác định</span>';
        }
    }

    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert)
    {
        $this->ngay_bat_dau = CustomFunc::convertDMYToYMD($this->ngay_bat_dau);
        $this->ngay_ket_thuc = CustomFunc::convertDMYToYMD($this->ngay_ket_thuc);

        if ($this->isNewRecord) {
            if ($this->nguoi_tao == null) {
                $this->nguoi_tao = Yii::$app->user->id ?? null;
            }
            if ($this->thoi_gian_tao == null) {
                $this->thoi_gian_tao = date('Y-m-d H:i:s');
            }
        }
        return parent::beforeSave($insert);
    }

    /**
     * Gets query for [[LoaiGiayTo]].
     * @return \yii\db\ActiveQuery
     */
    public function getLoaiGiayTo()
    {
        return $this->hasOne(LoaiGiayTo::class, ['id' => 'id_loai_giay_to']);
    }

    /**
     * Gets query for [[Xe]].
     * @return \yii\db\ActiveQuery
     */
    public function getXe()
    {
        return $this->hasOne(Xe::class, ['id' => 'id_xe']);
    }

    /**
     * Gets query for [[NguoiTao]].
     * @return \yii\db\ActiveQuery
     */
    public function getNguoiTao()
    {
        return $this->hasOne(User::class, ['id' => 'nguoi_tao']);
    }
}
