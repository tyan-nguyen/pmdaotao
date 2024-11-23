<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ptx_hinh_xe".
 *
 * @property int $id
 * @property int $id_xe
 * @property string $hinh_anh
 * @property int $nguoi_tao
 * @property string $thoi_gian_tao
 */
class PtxHinhXe extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ptx_hinh_xe';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_xe', 'hinh_anh', 'nguoi_tao', 'thoi_gian_tao'], 'required'],
            [['id', 'id_xe', 'nguoi_tao'], 'integer'],
            [['hinh_anh'], 'string'],
            [['thoi_gian_tao'], 'safe'],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_xe' => 'Id Xe',
            'hinh_anh' => 'Hinh Anh',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
        ];
    }
}
