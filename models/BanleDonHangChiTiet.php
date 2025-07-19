<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kh_don_hang_chi_tiet".
 *
 * @property int $id
 * @property int $id_don_hang
 * @property int $id_hang_hoa
 * @property float $so_luong
 * @property float|null $don_gia
 * @property float $chiet_khau
 * @property float $thanh_tien
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 * @property string|null $ghi_chu
 *
 * @property KhDonHang $donHang
 * @property HhHangHoa $hangHoa
 */
class BanleDonHangChiTiet extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'banle_don_hang_chi_tiet';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['don_gia', 'nguoi_tao', 'thoi_gian_tao', 'ghi_chu'], 'default', 'value' => null],
            [['id_don_hang', 'id_hang_hoa', 'so_luong', 'chiet_khau', 'thanh_tien'], 'required'],
            [['id_don_hang', 'id_hang_hoa', 'nguoi_tao'], 'integer'],
            [['so_luong', 'don_gia', 'chiet_khau', 'thanh_tien'], 'number'],
            [['thoi_gian_tao'], 'safe'],
            [['ghi_chu'], 'string'],
            [['id_don_hang'], 'exist', 'skipOnError' => true, 'targetClass' => BanleDonHang::class, 'targetAttribute' => ['id_don_hang' => 'id']],
            [['id_hang_hoa'], 'exist', 'skipOnError' => true, 'targetClass' => BanleHangHoa::class, 'targetAttribute' => ['id_hang_hoa' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_don_hang' => 'Id Don Hang',
            'id_hang_hoa' => 'Id Hang Hoa',
            'so_luong' => 'So Luong',
            'don_gia' => 'Don Gia',
            'chiet_khau' => 'Chiet Khau',
            'thanh_tien' => 'Thanh Tien',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
            'ghi_chu' => 'Ghi Chu',
        ];
    }

    /**
     * Gets query for [[DonHang]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDonHang()
    {
        return $this->hasOne(BanleDonHang::class, ['id' => 'id_don_hang']);
    }

    /**
     * Gets query for [[HangHoa]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHangHoa()
    {
        return $this->hasOne(BanleHangHoa::class, ['id' => 'id_hang_hoa']);
    }

}
