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
 *
 * @property HvHangDaoTao $hang
 * @property HvHocPhi $hocPhi
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
            [['id_khoa_hoc', 'id_hoc_phi', 'so_cccd', 'ngay_het_han_cccd', 'nguoi_tao', 'thoi_gian_tao', 'gioi_tinh', 'dia_chi', 'ngay_sinh', 'nguoi_lap_phieu', 'ma_so_phieu', 'so_lan_in_phieu', 'check_hoc_phi', 'id_nhom', 'loai_dang_ky', 'noi_dang_ky', 'nguoi_duyet', 'trang_thai_duyet', 'ghi_chu', 'thoi_gian_hoan_thanh_ho_so', 'co_ho_so_thue', 'da_nhan_ao', 'size'], 'default', 'value' => null],
            [['id_khoa_hoc', 'id_hoc_phi', 'nguoi_tao', 'gioi_tinh', 'ma_so_phieu', 'so_lan_in_phieu', 'id_hang', 'id_nhom', 'nguoi_duyet', 'co_ho_so_thue', 'da_nhan_ao'], 'integer'],
            [['ho_ten', 'so_dien_thoai', 'trang_thai', 'id_hang'], 'required'],
            [['ngay_het_han_cccd', 'thoi_gian_tao', 'ngay_sinh', 'thoi_gian_hoan_thanh_ho_so'], 'safe'],
            [['ghi_chu'], 'string'],
            [['ho_ten', 'so_dien_thoai', 'so_cccd', 'trang_thai', 'dia_chi'], 'string', 'max' => 255],
            [['nguoi_lap_phieu'], 'string', 'max' => 55],
            [['check_hoc_phi'], 'string', 'max' => 25],
            [['loai_dang_ky', 'trang_thai_duyet'], 'string', 'max' => 15],
            [['noi_dang_ky', 'size'], 'string', 'max' => 50],
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
     * Gets query for [[HocPhi]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHocPhi()
    {
        return $this->hasOne(HvHocPhi::class, ['id' => 'id_hoc_phi']);
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
