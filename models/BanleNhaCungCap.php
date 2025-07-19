<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "banle_nha_cung_cap".
 *
 * @property int $id
 * @property string $ten_nha_cung_cap
 * @property string $so_dien_thoai
 * @property string|null $dia_chi
 * @property int|null $tong_hop_cong_no
 * @property int|null $da_thanh_toan
 * @property int|null $con_lai
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property NccCongNoNhaCungCap[] $nccCongNoNhaCungCaps
 * @property NccDonHangNhaCungCap[] $nccDonHangNhaCungCaps
 */
class BanleNhaCungCap extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'banle_nha_cung_cap';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten_nha_cung_cap', 'so_dien_thoai'], 'required'],
            [['tong_hop_cong_no', 'da_thanh_toan', 'con_lai', 'nguoi_tao'], 'integer'],
            [['thoi_gian_tao'], 'safe'],
            [['ten_nha_cung_cap', 'dia_chi'], 'string', 'max' => 255],
            [['so_dien_thoai'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ten_nha_cung_cap' => 'Ten Nha Cung Cap',
            'so_dien_thoai' => 'So Dien Thoai',
            'dia_chi' => 'Dia Chi',
            'tong_hop_cong_no' => 'Tong Hop Cong No',
            'da_thanh_toan' => 'Da Thanh Toan',
            'con_lai' => 'Con Lai',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
        ];
    }

    /**
     * Gets query for [[NccCongNoNhaCungCaps]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNccCongNoNhaCungCaps()
    {
        return $this->hasMany(NccCongNoNhaCungCap::class, ['id_nha_cung_cap' => 'id']);
    }

    /**
     * Gets query for [[NccDonHangNhaCungCaps]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNccDonHangNhaCungCaps()
    {
        return $this->hasMany(NccDonHangNhaCungCap::class, ['id_nha_cung_cap' => 'id']);
    }
}
