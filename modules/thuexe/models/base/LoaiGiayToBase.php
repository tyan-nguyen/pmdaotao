<?php

namespace app\modules\thuexe\models\base;

use Yii;
use app\models\PtxXeLoaiGiayTo;
use app\modules\thuexe\models\XeGiayTo;
use yii\helpers\ArrayHelper;

/**
 * Class LoaiGiayToBase
 * @package app\modules\thuexe\models\base
 */
class LoaiGiayToBase extends PtxXeLoaiGiayTo
{
    const CHECK_HET_HAN_CO = 1;
    const CHECK_HET_HAN_KHONG = 0;
    const DEFAULT_SO_NGAY_BAO_TRUOC = 30;

    /**
     * Lấy số ngày báo trước hạn (mặc định 30 ngày nếu chưa cấu hình)
     * @return int
     */
    public function getSoNgayBaoTruocVal()
    {
        return ($this->so_ngay_bao_truoc !== null && $this->so_ngay_bao_truoc !== '') 
            ? (int)$this->so_ngay_bao_truoc 
            : self::DEFAULT_SO_NGAY_BAO_TRUOC;
    }

    /**
     * Danh mục kiểm tra hết hạn
     * @return array
     */
    public static function getDmCheckHetHan()
    {
        return [
            self::CHECK_HET_HAN_CO => 'Có theo dõi hạn',
            self::CHECK_HET_HAN_KHONG => 'Không theo dõi hạn',
        ];
    }

    /**
     * Nhãn badge kiểm tra hết hạn
     * @return string
     */
    public function getCheckHetHanLabel()
    {
        if ($this->check_het_han == self::CHECK_HET_HAN_CO) {
            return '<span class="badge bg-primary">Có theo dõi</span>';
        }
        return '<span class="badge bg-secondary">Không giới hạn</span>';
    }

    /**
     * Danh sách loại giấy tờ key-value cho dropdown
     * @return array
     */
    public static function getListLoaiGiayTo()
    {
        return ArrayHelper::map(self::find()->orderBy(['ten_loai_giay_to' => SORT_ASC])->all(), 'id', 'ten_loai_giay_to');
    }

    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert)
    {
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
     * Gets query for [[XeGiayTos]].
     * @return \yii\db\ActiveQuery
     */
    public function getXeGiayTos()
    {
        return $this->hasMany(XeGiayTo::class, ['id_loai_giay_to' => 'id']);
    }
}
