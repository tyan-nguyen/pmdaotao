<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ptx_xe_giay_to".
 *
 * @property int $id
 * @property int $id_xe
 * @property int $id_loai_giay_to
 * @property int $is_active
 * @property string|null $ngay_bat_dau
 * @property string|null $ngay_ket_thuc
 * @property string|null $ghi_chu
 * @property string|null $thoi_gian_tao
 * @property int|null $nguoi_tao
 *
 * @property PtxXeLoaiGiayTo $loaiGiayTo
 * @property PtxXe $xe
 */
class PtxXeGiayTo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ptx_xe_giay_to';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_xe', 'id_loai_giay_to'], 'required'],
            [['id_xe', 'id_loai_giay_to', 'is_active', 'nguoi_tao'], 'integer'],
            [['ngay_bat_dau', 'ngay_ket_thuc', 'thoi_gian_tao'], 'safe'],
            [['ghi_chu'], 'string'],
            [['is_active'], 'default', 'value' => 1],
            [['id_loai_giay_to'], 'exist', 'skipOnError' => true, 'targetClass' => PtxXeLoaiGiayTo::class, 'targetAttribute' => ['id_loai_giay_to' => 'id']],
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
            'id_xe' => 'Xe',
            'id_loai_giay_to' => 'Loại Giấy Tờ',
            'is_active' => 'Hiệu Lực',
            'ngay_bat_dau' => 'Ngày Bắt Đầu',
            'ngay_ket_thuc' => 'Ngày Kết Thúc',
            'ghi_chu' => 'Ghi Chú',
            'thoi_gian_tao' => 'Thời Gian Tạo',
            'nguoi_tao' => 'Người Tạo',
        ];
    }

    /**
     * Gets query for [[LoaiGiayTo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLoaiGiayTo()
    {
        return $this->hasOne(PtxXeLoaiGiayTo::class, ['id' => 'id_loai_giay_to']);
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
