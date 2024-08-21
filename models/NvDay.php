<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "nv_day".
 *
 * @property int $id
 * @property int $id_nhan_vien
 * @property int $id_hang_xe
 * @property int $ly_thuyet
 * @property int $thuc_hanh
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property NvHangXe $hangXe
 * @property NvNhanVien $nhanVien
 */
class NvDay extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nv_day';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_nhan_vien', 'id_hang_xe', 'ly_thuyet', 'thuc_hanh'], 'required'],
            [['id_nhan_vien', 'id_hang_xe', 'ly_thuyet', 'thuc_hanh', 'nguoi_tao'], 'integer'],
            [['thoi_gian_tao'], 'safe'],
            [['id_hang_xe'], 'exist', 'skipOnError' => true, 'targetClass' => NvHangXe::class, 'targetAttribute' => ['id_hang_xe' => 'id']],
            [['id_nhan_vien'], 'exist', 'skipOnError' => true, 'targetClass' => NvNhanVien::class, 'targetAttribute' => ['id_nhan_vien' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_nhan_vien' => 'Id Nhan Vien',
            'id_hang_xe' => 'Id Hang Xe',
            'ly_thuyet' => 'Ly Thuyet',
            'thuc_hanh' => 'Thuc Hanh',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
        ];
    }

    /**
     * Gets query for [[HangXe]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHangXe()
    {
        return $this->hasOne(NvHangXe::class, ['id' => 'id_hang_xe']);
    }

    /**
     * Gets query for [[NhanVien]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNhanVien()
    {
        return $this->hasOne(NvNhanVien::class, ['id' => 'id_nhan_vien']);
    }
}
