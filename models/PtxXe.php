<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ptx_xe".
 *
 * @property int $id
 * @property int $id_loai_xe
 * @property string|null $hieu_xe
 * @property string|null $bien_so_xe
 * @property string|null $tinh_trang_xe
 * @property string|null $trang_thai
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property PtxLoaiXe $loaiXe
 * @property PtxPhieuThueXe[] $ptxPhieuThueXes
 */
class PtxXe extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ptx_xe';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_loai_xe'], 'required'],
            [['id_loai_xe', 'nguoi_tao'], 'integer'],
            [['tinh_trang_xe'], 'string'],
            [['thoi_gian_tao'], 'safe'],
            [['hieu_xe', 'bien_so_xe'], 'string', 'max' => 50],
            [['trang_thai'], 'string', 'max' => 25],
            [['id_loai_xe'], 'exist', 'skipOnError' => true, 'targetClass' => PtxLoaiXe::class, 'targetAttribute' => ['id_loai_xe' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_loai_xe' => 'Id Loai Xe',
            'hieu_xe' => 'Hieu Xe',
            'bien_so_xe' => 'Bien So Xe',
            'tinh_trang_xe' => 'Tinh Trang Xe',
            'trang_thai' => 'Trang Thai',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
        ];
    }

    /**
     * Gets query for [[LoaiXe]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLoaiXe()
    {
        return $this->hasOne(PtxLoaiXe::class, ['id' => 'id_loai_xe']);
    }

    /**
     * Gets query for [[PtxPhieuThueXes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPtxPhieuThueXes()
    {
        return $this->hasMany(PtxPhieuThueXe::class, ['id_xe' => 'id']);
    }
}
