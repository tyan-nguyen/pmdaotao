<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hv_hoc_vien".
 *
 * @property int $id
 * @property int|null $id_khoa_hoc
 * @property int|null $id_hoc_phi
 * @property string $ho_ten
 * @property string $so_dien_thoai
 * @property string|null $so_cccd
 * @property string|null $ngay_het_han_cccd
 * @property string $trang_thai
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 * @property int|null $gioi_tinh
 * @property string|null $dia_chi
 * @property string|null $dia_chi_chi_tiet
 * @property int|null $id_xa
 * @property int|null $id_tinh
 * @property string|null $ngay_sinh
 * @property string|null $nguoi_lap_phieu
 * @property int|null $ma_so_phieu
 * @property int|null $so_lan_in_phieu
 * @property int $id_hang
 * @property string|null $check_hoc_phi
 * @property int|null $id_nhom
 * @property string|null $loai_dang_ky
 * @property string|null $noi_dang_ky
 * @property int|null $nguoi_duyet
 * @property string|null $trang_thai_duyet
 * @property string|null $ghi_chu
 * @property string|null $thoi_gian_hoan_thanh_ho_so
 * @property int|null $co_ho_so_thue
 * @property int|null $da_nhan_ao
 * @property string|null $size
 * @property string|null $ngay_nhan_ao
 * @property int|null $nguoi_giao_ao
 * @property int|null $da_nhan_tai_lieu
 * @property string|null $ngay_nhan_tai_lieu
 * @property int|null $nguoi_giao_tai_lieu
 * @property int|null $id_giao_vien
 * @property int|null $huy_ho_so
 * @property string|null $thoi_gian_huy_ho_so
 * @property string|null $ly_do_huy_ho_so
 * @property string|null $loai_ly_do
 * @property float|null $le_phi
 * @property int|null $da_nop_du
 *
 * @property GdGvHv[] $gdGvHvs
 * @property HvHangDaoTao $hang
 * @property HvHocPhi $hocPhi
 * @property HvHocVienBaoLuu[] $hvHocVienBaoLuus
 * @property HvHocVienDoiSatHach[] $hvHocVienDoiSatHaches
 * @property HvHocVienThayDoiHocPhi[] $hvHocVienThayDoiHocPhis
 * @property HvNopHocPhi[] $hvNopHocPhis
 * @property HvKhoaHoc $khoaHoc
 * @property HvNhom $nhom
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
            [['id_khoa_hoc', 'id_hoc_phi', 'so_cccd', 'ngay_het_han_cccd', 'nguoi_tao', 'thoi_gian_tao', 'gioi_tinh', 'dia_chi', 'dia_chi_chi_tiet', 'id_xa', 'id_tinh', 'ngay_sinh', 'nguoi_lap_phieu', 'ma_so_phieu', 'so_lan_in_phieu', 'check_hoc_phi', 'id_nhom', 'loai_dang_ky', 'noi_dang_ky', 'nguoi_duyet', 'trang_thai_duyet', 'ghi_chu', 'thoi_gian_hoan_thanh_ho_so', 'co_ho_so_thue', 'da_nhan_ao', 'size', 'ngay_nhan_ao', 'nguoi_giao_ao', 'da_nhan_tai_lieu', 'ngay_nhan_tai_lieu', 'nguoi_giao_tai_lieu', 'id_giao_vien', 'huy_ho_so', 'thoi_gian_huy_ho_so', 'ly_do_huy_ho_so', 'loai_ly_do', 'le_phi', 'da_nop_du'], 'default', 'value' => null],
            [['id_khoa_hoc', 'id_hoc_phi', 'nguoi_tao', 'gioi_tinh', 'id_xa', 'id_tinh', 'ma_so_phieu', 'so_lan_in_phieu', 'id_hang', 'id_nhom', 'nguoi_duyet', 'co_ho_so_thue', 'da_nhan_ao', 'nguoi_giao_ao', 'da_nhan_tai_lieu', 'nguoi_giao_tai_lieu', 'id_giao_vien', 'huy_ho_so', 'da_nop_du'], 'integer'],
            [['ho_ten', 'so_dien_thoai', 'trang_thai', 'id_hang'], 'required'],
            [['ngay_het_han_cccd', 'thoi_gian_tao', 'ngay_sinh', 'thoi_gian_hoan_thanh_ho_so', 'ngay_nhan_ao', 'ngay_nhan_tai_lieu', 'thoi_gian_huy_ho_so'], 'safe'],
            [['ghi_chu', 'ly_do_huy_ho_so'], 'string'],
            [['le_phi'], 'number'],
            [['ho_ten', 'so_dien_thoai', 'so_cccd', 'trang_thai', 'dia_chi'], 'string', 'max' => 255],
            [['dia_chi_chi_tiet'], 'string', 'max' => 250],
            [['nguoi_lap_phieu'], 'string', 'max' => 55],
            [['check_hoc_phi'], 'string', 'max' => 25],
            [['loai_dang_ky', 'trang_thai_duyet'], 'string', 'max' => 15],
            [['noi_dang_ky', 'size'], 'string', 'max' => 50],
            [['loai_ly_do'], 'string', 'max' => 20],
            [['id_hang'], 'exist', 'skipOnError' => true, 'targetClass' => HvHangDaoTao::class, 'targetAttribute' => ['id_hang' => 'id']],
            [['id_khoa_hoc'], 'exist', 'skipOnError' => true, 'targetClass' => HvKhoaHoc::class, 'targetAttribute' => ['id_khoa_hoc' => 'id']],
            [['id_nhom'], 'exist', 'skipOnError' => true, 'targetClass' => HvNhom::class, 'targetAttribute' => ['id_nhom' => 'id']],
            [['id_hoc_phi'], 'exist', 'skipOnError' => true, 'targetClass' => HvHocPhi::class, 'targetAttribute' => ['id_hoc_phi' => 'id']],
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
            'id_hoc_phi' => 'Id Hoc Phi',
            'ho_ten' => 'Ho Ten',
            'so_dien_thoai' => 'So Dien Thoai',
            'so_cccd' => 'So Cccd',
            'ngay_het_han_cccd' => 'Ngay Het Han Cccd',
            'trang_thai' => 'Trang Thai',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
            'gioi_tinh' => 'Gioi Tinh',
            'dia_chi' => 'Dia Chi',
            'dia_chi_chi_tiet' => 'Dia Chi Chi Tiet',
            'id_xa' => 'Id Xa',
            'id_tinh' => 'Id Tinh',
            'ngay_sinh' => 'Ngay Sinh',
            'nguoi_lap_phieu' => 'Nguoi Lap Phieu',
            'ma_so_phieu' => 'Ma So Phieu',
            'so_lan_in_phieu' => 'So Lan In Phieu',
            'id_hang' => 'Id Hang',
            'check_hoc_phi' => 'Check Hoc Phi',
            'id_nhom' => 'Id Nhom',
            'loai_dang_ky' => 'Loai Dang Ky',
            'noi_dang_ky' => 'Noi Dang Ky',
            'nguoi_duyet' => 'Nguoi Duyet',
            'trang_thai_duyet' => 'Trang Thai Duyet',
            'ghi_chu' => 'Ghi Chu',
            'thoi_gian_hoan_thanh_ho_so' => 'Thoi Gian Hoan Thanh Ho So',
            'co_ho_so_thue' => 'Co Ho So Thue',
            'da_nhan_ao' => 'Da Nhan Ao',
            'size' => 'Size',
            'ngay_nhan_ao' => 'Ngay Nhan Ao',
            'nguoi_giao_ao' => 'Nguoi Giao Ao',
            'da_nhan_tai_lieu' => 'Da Nhan Tai Lieu',
            'ngay_nhan_tai_lieu' => 'Ngay Nhan Tai Lieu',
            'nguoi_giao_tai_lieu' => 'Nguoi Giao Tai Lieu',
            'id_giao_vien' => 'Id Giao Vien',
            'huy_ho_so' => 'Huy Ho So',
            'thoi_gian_huy_ho_so' => 'Thoi Gian Huy Ho So',
            'ly_do_huy_ho_so' => 'Ly Do Huy Ho So',
            'loai_ly_do' => 'Loai Ly Do',
            'le_phi' => 'Le Phi',
            'da_nop_du' => 'Da Nop Du',
        ];
    }

    /**
     * Gets query for [[GdGvHvs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGdGvHvs()
    {
        return $this->hasMany(GdGvHv::class, ['id_hoc_vien' => 'id']);
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
     * Gets query for [[HocPhi]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHocPhi()
    {
        return $this->hasOne(HvHocPhi::class, ['id' => 'id_hoc_phi']);
    }

    /**
     * Gets query for [[HvHocVienBaoLuus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHvHocVienBaoLuus()
    {
        return $this->hasMany(HvHocVienBaoLuu::class, ['id_hoc_vien' => 'id']);
    }

    /**
     * Gets query for [[HvHocVienDoiSatHaches]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHvHocVienDoiSatHaches()
    {
        return $this->hasMany(HvHocVienDoiSatHach::class, ['id_hoc_vien' => 'id']);
    }

    /**
     * Gets query for [[HvHocVienThayDoiHocPhis]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHvHocVienThayDoiHocPhis()
    {
        return $this->hasMany(HvHocVienThayDoiHocPhi::class, ['id_hoc_vien' => 'id']);
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

    /**
     * Gets query for [[Nhom]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNhom()
    {
        return $this->hasOne(HvNhom::class, ['id' => 'id_nhom']);
    }

}
