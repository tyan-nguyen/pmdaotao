<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "banle_hang_hoa".
 *
 * @property int $id
 * @property int $id_loai_hang_hoa
 * @property string $ma_hang_hoa
 * @property string $ten_hang_hoa
 * @property string|null $ngay_san_xuat
 * @property float|null $so_luong
 * @property float $don_gia
 * @property string $dvt
 * @property string|null $xuat_xu
 * @property string|null $ghi_chu
 * @property int|null $co_ton_kho
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property HhHangHoaLichSu[] $hhHangHoaLichSus
 * @property KhDonHangChiTiet[] $khDonHangChiTiets
 * @property HhLoaiHangHoa $loaiHangHoa
 * @property NccChiTietDonHangNcc[] $nccChiTietDonHangNccs
 */
class BanleHangHoa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'banle_hang_hoa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ngay_san_xuat', 'so_luong', 'xuat_xu', 'ghi_chu', 'co_ton_kho', 'nguoi_tao', 'thoi_gian_tao'], 'default', 'value' => null],
            [['id_loai_hang_hoa', 'ma_hang_hoa', 'ten_hang_hoa', 'don_gia', 'dvt'], 'required'],
            [['id_loai_hang_hoa', 'co_ton_kho', 'nguoi_tao'], 'integer'],
            [['ngay_san_xuat', 'thoi_gian_tao'], 'safe'],
            [['so_luong', 'don_gia'], 'number'],
            [['ghi_chu'], 'string'],
            [['ma_hang_hoa'], 'string', 'max' => 50],
            [['ten_hang_hoa'], 'string', 'max' => 255],
            [['dvt', 'xuat_xu'], 'string', 'max' => 20],
            [['id_loai_hang_hoa'], 'exist', 'skipOnError' => true, 'targetClass' => HhLoaiHangHoa::class, 'targetAttribute' => ['id_loai_hang_hoa' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_loai_hang_hoa' => 'Id Loai Hang Hoa',
            'ma_hang_hoa' => 'Ma Hang Hoa',
            'ten_hang_hoa' => 'Ten Hang Hoa',
            'ngay_san_xuat' => 'Ngay San Xuat',
            'so_luong' => 'So Luong',
            'don_gia' => 'Don Gia',
            'dvt' => 'Dvt',
            'xuat_xu' => 'Xuat Xu',
            'ghi_chu' => 'Ghi Chu',
            'co_ton_kho' => 'Co Ton Kho',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
        ];
    }

    /**
     * Gets query for [[HhHangHoaLichSus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHhHangHoaLichSus()
    {
        return $this->hasMany(BanleHangHoaLichSu::class, ['id_hang_hoa' => 'id']);
    }

    /**
     * Gets query for [[KhDonHangChiTiets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKhDonHangChiTiets()
    {
        return $this->hasMany(KhDonHangChiTiet::class, ['id_hang_hoa' => 'id']);
    }

    /**
     * Gets query for [[LoaiHangHoa]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLoaiHangHoa()
    {
        return $this->hasOne(BanleLoaiHangHoa::class, ['id' => 'id_loai_hang_hoa']);
    }

    /**
     * Gets query for [[NccChiTietDonHangNccs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNccChiTietDonHangNccs()
    {
        return $this->hasMany(NccChiTietDonHangNcc::class, ['id_hang_hoa' => 'id']);
    }

}
