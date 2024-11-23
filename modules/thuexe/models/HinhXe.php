<?php

namespace app\modules\thuexe\models;

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
class HinhXe extends \app\models\PtxHinhXe
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
            'id_xe' => 'Xe',
            'hinh_anh' => 'Hình xe',
            'nguoi_tao' => 'Người tạo',
            'thoi_gian_tao' => 'Thời gian tạo',
        ];
    }
    public function beforeSave($insert)
    {        
        if ($this->isNewRecord) {
            $this->nguoi_tao = Yii::$app->user->identity->id;
            $this->thoi_gian_tao = date('Y-m-d H:i:s'); 
        }
        return parent::beforeSave($insert);
    }
}
