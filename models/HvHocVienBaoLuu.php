<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hv_hoc_vien_bao_luu".
 *
 * @property int $id
 * @property int $id_hoc_vien
 * @property int|null $id_hang
 * @property int|null $id_khoa
 * @property string|null $ngay_khai_giang
 * @property string|null $ngay_bat_dau
 * @property string|null $ngay_ket_thuc
 * @property float|null $hoc_phi_da_dong
 * @property string|null $ly_do
 * @property string|null $ghi_chu
 * @property string|null $thoi_gian_tao
 * @property int|null $nguoi_tao
 *
 * @property HvHangDaoTao $hang
 * @property HvHocVien $hocVien
 * @property HvKhoaHoc $khoa
 */
class HvHocVienBaoLuu extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hv_hoc_vien_bao_luu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_hang', 'id_khoa', 'ngay_khai_giang', 'ngay_bat_dau', 'ngay_ket_thuc', 'hoc_phi_da_dong', 'ly_do', 'ghi_chu', 'thoi_gian_tao', 'nguoi_tao'], 'default', 'value' => null],
            [['id_hoc_vien'], 'required'],
            [['id_hoc_vien', 'id_hang', 'id_khoa', 'nguoi_tao'], 'integer'],
            [['ngay_khai_giang', 'ngay_bat_dau', 'ngay_ket_thuc', 'thoi_gian_tao'], 'safe'],
            [['hoc_phi_da_dong'], 'number'],
            [['ly_do', 'ghi_chu'], 'string'],
            [['id_hoc_vien'], 'exist', 'skipOnError' => true, 'targetClass' => HvHocVien::class, 'targetAttribute' => ['id_hoc_vien' => 'id']],
            [['id_hang'], 'exist', 'skipOnError' => true, 'targetClass' => HvHangDaoTao::class, 'targetAttribute' => ['id_hang' => 'id']],
            [['id_khoa'], 'exist', 'skipOnError' => true, 'targetClass' => HvKhoaHoc::class, 'targetAttribute' => ['id_khoa' => 'id']],
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
            'id_khoa' => 'Id Khoa',
            'ngay_khai_giang' => 'Ngay Khai Giang',
            'ngay_bat_dau' => 'Ngay Bat Dau',
            'ngay_ket_thuc' => 'Ngay Ket Thuc',
            'hoc_phi_da_dong' => 'Hoc Phi Da Dong',
            'ly_do' => 'Ly Do',
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

    /**
     * Gets query for [[Khoa]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKhoa()
    {
        return $this->hasOne(HvKhoaHoc::class, ['id' => 'id_khoa']);
    }

}
