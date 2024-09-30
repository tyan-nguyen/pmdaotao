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
            'id_hang' => 'Hạng',
            'hoc_phi' => 'Học Phí',
            'ngay_ap_dung' => 'Ngày áp dụng',
            'ngay_ket_thuc' => 'Ngày kết thúc',
            'nguoi_tao' => 'Người tạo',
            'thoi_gian_tao' => 'Thời gian tạo',
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
