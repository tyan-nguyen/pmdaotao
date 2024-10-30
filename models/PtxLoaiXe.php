<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ptx_loai_xe".
 *
 * @property int $id
 * @property string $ten_loai_xe
 * @property string|null $ghi_chu
 * @property int|null $nguoi_tao
 * @property int|null $thoi_gian_tao
 *
 * @property PtxLoaiHinhThue[] $ptxLoaiHinhThues
 * @property PtxXe[] $ptxXes
 */
class PtxLoaiXe extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ptx_loai_xe';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten_loai_xe'], 'required'],
            [['ghi_chu'], 'string'],
            [['nguoi_tao', 'thoi_gian_tao'], 'integer'],
            [['ten_loai_xe'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ten_loai_xe' => 'Ten Loai Xe',
            'ghi_chu' => 'Ghi Chu',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
        ];
    }

    /**
     * Gets query for [[PtxLoaiHinhThues]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPtxLoaiHinhThues()
    {
        return $this->hasMany(PtxLoaiHinhThue::class, ['id_loai_xe' => 'id']);
    }

    /**
     * Gets query for [[PtxXes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPtxXes()
    {
        return $this->hasMany(PtxXe::class, ['id_loai_xe' => 'id']);
    }
}
