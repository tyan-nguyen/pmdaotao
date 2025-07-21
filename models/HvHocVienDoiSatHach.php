<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hv_hoc_vien_doi_sat_hach".
 *
 * @property int $id
 * @property int $id_hoc_vien
 * @property int $id_hang
 * @property string $ngay_thi_cu
 * @property string|null $ly_do_doi_lich
 * @property string|null $ngay_thi_moi
 * @property int|null $da_xu_ly
 * @property string|null $ghi_chu
 * @property string|null $thoi_gian_tao
 * @property int|null $nguoi_tao
 *
 * @property HvHangDaoTao $hang
 * @property HvHocVien $hocVien
 */
class HvHocVienDoiSatHach extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hv_hoc_vien_doi_sat_hach';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ly_do_doi_lich', 'ngay_thi_moi', 'da_xu_ly', 'ghi_chu', 'thoi_gian_tao', 'nguoi_tao'], 'default', 'value' => null],
            [['id_hoc_vien', 'id_hang', 'ngay_thi_cu'], 'required'],
            [['id_hoc_vien', 'id_hang', 'da_xu_ly', 'nguoi_tao'], 'integer'],
            [['ngay_thi_cu', 'ngay_thi_moi', 'thoi_gian_tao'], 'safe'],
            [['ly_do_doi_lich', 'ghi_chu'], 'string'],
            [['id_hoc_vien'], 'exist', 'skipOnError' => true, 'targetClass' => HvHocVien::class, 'targetAttribute' => ['id_hoc_vien' => 'id']],
            [['id_hang'], 'exist', 'skipOnError' => true, 'targetClass' => HvHangDaoTao::class, 'targetAttribute' => ['id_hang' => 'id']],
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
            'id_hang' => 'Id Hang',
            'ngay_thi_cu' => 'Ngay Thi Cu',
            'ly_do_doi_lich' => 'Ly Do Doi Lich',
            'ngay_thi_moi' => 'Ngay Thi Moi',
            'da_xu_ly' => 'Da Xu Ly',
            'ghi_chu' => 'Ghi Chu',
            'thoi_gian_tao' => 'Thoi Gian Tao',
            'nguoi_tao' => 'Nguoi Tao',
        ];
    }

    /**
     * Gets query for [[Hang]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHang()
    {
        return $this->hasOne(HvHangDaoTao::class, ['id' => 'id_hang']);
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
