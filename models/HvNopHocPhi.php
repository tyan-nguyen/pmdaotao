<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hv_nop_hoc_phi".
 *
 * @property int $id
 * @property int $id_hoc_vien
 * @property float $so_tien_nop
 * @property string $ngay_nop
 * @property int $nguoi_thu
 * @property string $bien_lai
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property HvHocVien $hocVien
 */
class HvNopHocPhi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hv_nop_hoc_phi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_hoc_vien', 'so_tien_nop', 'ngay_nop', 'nguoi_thu', 'bien_lai'], 'required'],
            [['id_hoc_vien', 'nguoi_thu', 'nguoi_tao'], 'integer'],
            [['so_tien_nop'], 'number'],
            [['ngay_nop', 'thoi_gian_tao'], 'safe'],
            [['bien_lai'], 'string'],
            [['id_hoc_vien'], 'exist', 'skipOnError' => true, 'targetClass' => HvHocVien::class, 'targetAttribute' => ['id_hoc_vien' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_hoc_vien' => 'Id Hoc Vien',
            'so_tien_nop' => 'Số tiền nộp',
            'ngay_nop' => 'Ngày nộp',
            'nguoi_thu' => 'Nguười thu',
            'bien_lai' => 'Biên lai',
            'nguoi_tao' => 'Người tạo',
            'thoi_gian_tao' => 'Thời gian tạo',
        ];
    }

    /**
     * Gets query for [[HocVien]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHocVien()
    {
        return $this->hasOne(HvHocVien::class, ['id' => 'id_hoc_vien']);
    }
}
