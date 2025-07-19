<?php

namespace app\models;

use Yii;
use app\modules\banhang\models\KhachHang;

/**
 * This is the model class for table "kh_don_hang".
 *
 * @property int $id
 * @property int $id_khach_hang
 * @property int $so_don_hang
 * @property int|null $so_vao_so
 * @property int|null $nam
 * @property string|null $trang_thai
 * @property string $ngay_dat_hang
 * @property string|null $ngay_xuat
 * @property string $hinh_thuc_thanh_toan
 * @property int|null $so_lan_in
 * @property int|null $da_giao_hang
 * @property string|null $ngay_giao_hang
 * @property float|null $chi_phi_van_chuyen
 * @property string|null $ghi_chu
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 * @property int|null $edit_mode
 *
 * @property KhDonHangChiTiet[] $khDonHangChiTiets
 * @property KhKhachHang $khachHang
 */
class BanleDonHang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'banle_don_hang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['so_vao_so', 'nam', 'trang_thai', 'ngay_xuat', 'so_lan_in', 'da_giao_hang', 'ngay_giao_hang', 'chi_phi_van_chuyen', 'ghi_chu', 'nguoi_tao', 'thoi_gian_tao'], 'default', 'value' => null],
            [['id_khach_hang', 'so_don_hang', 'ngay_dat_hang', 'hinh_thuc_thanh_toan'], 'required'],
            [['id_khach_hang', 'so_don_hang', 'so_vao_so', 'nam', 'so_lan_in', 'da_giao_hang', 'nguoi_tao', 'edit_mode'], 'integer'],
            [['ngay_dat_hang', 'ngay_xuat', 'ngay_giao_hang', 'thoi_gian_tao'], 'safe'],
            [['chi_phi_van_chuyen'], 'number'],
            [['ghi_chu'], 'string'],
            [['trang_thai', 'hinh_thuc_thanh_toan'], 'string', 'max' => 20],
            [['id_khach_hang'], 'exist', 'skipOnError' => true, 'targetClass' => KhKhachHang::class, 'targetAttribute' => ['id_khach_hang' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_khach_hang' => 'Id Khach Hang',
            'so_don_hang' => 'So Don Hang',
            'so_vao_so' => 'So Vao So',
            'nam' => 'Nam',
            'trang_thai' => 'Trang Thai',
            'ngay_dat_hang' => 'Ngay Dat Hang',
            'ngay_xuat' => 'Ngay Xuat',
            'hinh_thuc_thanh_toan' => 'Hinh Thuc Thanh Toan',
            'so_lan_in' => 'So Lan In',
            'da_giao_hang' => 'Da Giao Hang',
            'ngay_giao_hang' => 'Ngay Giao Hang',
            'chi_phi_van_chuyen' => 'Chi Phi Van Chuyen',
            'ghi_chu' => 'Ghi Chu',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
            'edit_mode' => 'Edit mode'
        ];
    }

    /**
     * Gets query for [[KhDonHangChiTiets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKhDonHangChiTiets()
    {
        return $this->hasMany(KhDonHangChiTiet::class, ['id_don_hang' => 'id']);
    }

    /**
     * Gets query for [[KhachHang]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKhachHang()
    {
        return $this->hasOne(KhachHang::class, ['id' => 'id_khach_hang']);
    }

}
