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
 * @property string|null $so_cccd
 * @property string $ngay_sinh
 * @property string $trang_thai
 * @property string $check_hoc_phi
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 * @property int|null $id_nhom
 * @property int|null $nguoi_duyet
 * @property string|null $trang_thai_duyet 
 * @property string|null $loai_dang_ky
 * @property string|null $ngay_het_han_cccd 
 * @property string|null $noi_dang_ky
 * @property int|null $ma_so_phieu 
 * @property int|null $so_lan_in_phieu
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
            [['ho_ten', 'so_dien_thoai','trang_thai','id_hang'], 'required'],
            [['id_khoa_hoc', 'nguoi_tao','id_nhom','nguoi_duyet','ma_so_phieu','so_lan_in_phieu'], 'integer'],
            [['ngay_cap_cccd', 'thoi_gian_tao','ngay_sinh','ngay_het_han_cccd'], 'safe'],
            [['ho_ten', 'so_dien_thoai', 'so_cccd', 'trang_thai','trâng_thai_duyet'], 'string', 'max' => 255],
            [['check_hoc_phi'],'string','max'=>25],
            [['loai_dang_ky'],'string','max'=>15],
            [['noi_dang_ky'],'string','max'=>50],
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
            'id_nhom'=>'Id Nhom',
            'loai_dang_ky'=>'Loại hình đăng ký',
            'nguoi_duyet'=>'Người duyệt',
            'trang_thai_duyet'=>'Trạng thái duyệt',
            'ngay_het_han_cccd'=>'Ngày hết hạn CCCD',
            'noi_dang_ky'=>'Nơi đăng ký',
            'ma_so_phieu'=>'Mã số phiếu',
            'so_lan_in_phieu'=>'Số lần in phiếu',
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
