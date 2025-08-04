<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ptx_lich_thue".
 *
 * @property int $id
 * @property string|null $loai_giao_vien
 * @property int|null $id_giao_vien
 * @property string|null $loai_khach_hang
 * @property int|null $id_khach_hang
 * @property int $id_xe
 * @property string $thoi_gian_bat_dau
 * @property string $thoi_gian_ket_thuc
 * @property float|null $so_gio
 * @property float|null $don_gia
 * @property string|null $hinh_thuc_thanh_toan
 * @property string|null $trang_thai
 * @property string|null $ghi_chu
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property PtxXe $xe
 */
class PtxLichThue extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ptx_lich_thue';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['loai_giao_vien', 'id_giao_vien', 'loai_khach_hang', 'id_khach_hang', 'so_gio', 'don_gia', 'hinh_thuc_thanh_toan', 'trang_thai', 'ghi_chu', 'nguoi_tao', 'thoi_gian_tao'], 'default', 'value' => null],
            [['id_giao_vien', 'id_khach_hang', 'id_xe', 'nguoi_tao'], 'integer'],
            [['id_xe', 'thoi_gian_bat_dau', 'thoi_gian_ket_thuc'], 'required'],
            [['thoi_gian_bat_dau', 'thoi_gian_ket_thuc', 'thoi_gian_tao'], 'safe'],
            [['so_gio', 'don_gia'], 'number'],
            [['ghi_chu'], 'string'],
            [['loai_giao_vien', 'loai_khach_hang', 'hinh_thuc_thanh_toan', 'trang_thai'], 'string', 'max' => 20],
            [['id_xe'], 'exist', 'skipOnError' => true, 'targetClass' => PtxXe::class, 'targetAttribute' => ['id_xe' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'loai_giao_vien' => 'Loai Giao Vien',
            'id_giao_vien' => 'Id Giao Vien',
            'loai_khach_hang' => 'Loai Khach Hang',
            'id_khach_hang' => 'Id Khach Hang',
            'id_xe' => 'Id Xe',
            'thoi_gian_bat_dau' => 'Thoi Gian Bat Dau',
            'thoi_gian_ket_thuc' => 'Thoi Gian Ket Thuc',
            'so_gio' => 'So Gio',
            'don_gia' => 'Don Gia',
            'hinh_thuc_thanh_toan' => 'Hinh Thuc Thanh Toan',
            'trang_thai' => 'Trang Thai',
            'ghi_chu' => 'Ghi Chu',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
        ];
    }

    /**
     * Gets query for [[Xe]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getXe()
    {
        return $this->hasOne(PtxXe::class, ['id' => 'id_xe']);
    }

}
