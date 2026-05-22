<?php

namespace app\modules\taisan\models\base;

use app\models\CpDotTongHop;
use Yii;

/**
 * This is the model class for table "cp_dot_tong_hop".
 *
 * @property int $id
 * @property string $code
 * @property string|null $ngay_tong_hop
 * @property string|null $trang_thai_thanh_toan
 * @property string|null $ngay_thanh_toan
 * @property string|null $ghi_chu
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property CpPhieuDeNghi[] $cpPhieuDeNghis
 */
class DotTongHopBase extends CpDotTongHop
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ngay_thanh_toan', 'ghi_chu', 'nguoi_tao'], 'default', 'value' => null],
            [['trang_thai_thanh_toan'], 'default', 'value' => 'CHUA_THANH_TOAN'],
            [['code'], 'required'],
            [['ngay_tong_hop', 'ngay_thanh_toan', 'thoi_gian_tao'], 'safe'],
            [['ghi_chu'], 'string'],
            [['nguoi_tao'], 'integer'],
            [['code'], 'string', 'max' => 50],
            [['trang_thai_thanh_toan'], 'string', 'max' => 20],
            [['code'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Mã đợt tổng hợp',
            'ngay_tong_hop' => 'Ngày tổng hợp',
            'trang_thai_thanh_toan' => 'Trạng thái thanh toán',
            'ngay_thanh_toan' => 'Ngày thanh toán',
            'ghi_chu' => 'Ghi chú',
            'nguoi_tao' => 'Người tạo',
            'thoi_gian_tao' => 'Thời gian tạo',
        ];
    }

    //hàm beforeSave, set nguoi_tao
    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
        }
        return parent::beforeSave($insert);
    }

    /**
     * Gets query for [[CpPhieuDeNghis]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCpPhieuDeNghis()
    {
        return $this->hasMany(PhieuDeNghiBase::class, ['id_dot_tong_hop' => 'id']);
    }
}
