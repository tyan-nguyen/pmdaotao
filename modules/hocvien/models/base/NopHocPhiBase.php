<?php

namespace app\modules\hocvien\models\base;

use Yii;
use app\modules\hocvien\models\HocVien;
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
class NopHocPhi extends \app\models\HvNopHocPhi
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
            [['bien_lai'], 'string', 'max' => 255],
            [['id_hoc_vien'], 'exist', 'skipOnError' => true, 'targetClass' => HocVien::class, 'targetAttribute' => ['id_hoc_vien' => 'id']],
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
            'so_tien_nop' => 'So Tien Nop',
            'ngay_nop' => 'Ngay Nop',
            'nguoi_thu' => 'Nguoi Thu',
            'bien_lai' => 'Bien Lai',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
        ];
    }

    /**
     * Gets query for [[HocVien]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHocVien()
    {
        return $this->hasOne(HocVien::class, ['id' => 'id_hoc_vien']);
    }
}
