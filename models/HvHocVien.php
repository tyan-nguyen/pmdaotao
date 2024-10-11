<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hv_hoc_vien".
 *
 * @property int $id
  * @property int $id_hang
 * @property int $id_khoa_hoc
 * @property string $ho_ten
 * @property string $so_dien_thoai
 * @property string $so_cccd
 * @property string $ngay_sinh
 * @property string $trang_thai
 * @property string $check_hoc_phi
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property HvHoSoHocVien[] $hvHoSoHocViens
 * @property HvNopHocPhi[] $hvNopHocPhis
 * @property HvKhoaHoc $khoaHoc
 */
class HvHocVien extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hv_hoc_vien';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ho_ten', 'so_dien_thoai', 'so_cccd', 'trang_thai','id_hang'], 'required'],
            [['id_khoa_hoc', 'nguoi_tao'], 'integer'],
            [['ngay_cap_cccd', 'thoi_gian_tao','ngay_sinh'], 'safe'],
            [['ho_ten', 'so_dien_thoai', 'so_cccd', 'trang_thai'], 'string', 'max' => 255],
            [['check_hoc_phi'],'string','max'=>25],
            [['id_khoa_hoc'], 'exist', 'skipOnError' => true, 'targetClass' => HvKhoaHoc::class, 'targetAttribute' => ['id_khoa_hoc' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_khoa_hoc' => 'Id Khoa Hoc',
            'ho_ten' => 'Ho Ten',
            'so_dien_thoai' => 'So Dien Thoai',
            'so_cccd' => 'So Cccd',
             'ngay_sinh'=>'Ngày sinh',
            'trang_thai' => 'Trang Thai',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
            'id_hang'=>'Id Hang',
            'check_hoc_phi' =>'Trạng thái Học phí',
        ];
    }

    /**
     * Gets query for [[HvHoSoHocViens]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHvHoSoHocViens()
    {
        return $this->hasMany(KhoHoSo::class, ['id_hoc_vien' => 'id']);
    }

    /**
     * Gets query for [[HvNopHocPhis]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHvNopHocPhis()
    {
        return $this->hasMany(HvNopHocPhi::class, ['id_hoc_vien' => 'id']);
    }

    /**
     * Gets query for [[KhoaHoc]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKhoaHoc()
    {
        return $this->hasOne(HvKhoaHoc::class, ['id' => 'id_khoa_hoc']);
    }
    public function getHangDaoTao()
    {
        return $this->hasOne(HvHangDaoTao::class, ['id' => 'id_hang']);
    }
   
}
