<?php

namespace app\modules\hocvien\models;

use Yii;

/**
 * This is the model class for table "hv_hoc_phi".
 *
 * @property int $id
 * @property int $id_hang
 * @property float $hoc_phi
 * @property string $ngay_ap_dung
 * @property string $ngay_ket_thuc
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property HvHangDaoTao $hang
 */
class HocPhi extends \app\models\HvHocPhi
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hv_hoc_phi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_hang', 'hoc_phi', 'ngay_ap_dung', 'ngay_ket_thuc'], 'required'],
            [['id_hang', 'nguoi_tao'], 'integer'],
            [['hoc_phi'], 'number'],
            [['ngay_ap_dung', 'ngay_ket_thuc', 'thoi_gian_tao'], 'safe'],
            [['id_hang'], 'exist', 'skipOnError' => true, 'targetClass' => HangDaoTao::class, 'targetAttribute' => ['id_hang' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_hang' => 'Id Hang',
            'hoc_phi' => 'Hoc Phi',
            'ngay_ap_dung' => 'Ngay Ap Dung',
            'ngay_ket_thuc' => 'Ngay Ket Thuc',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
        ];
    }

    /**
     * Gets query for [[Hang]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHang()
    {
        return $this->hasOne(HangDaoTao::class, ['id' => 'id_hang']);
    }
}
