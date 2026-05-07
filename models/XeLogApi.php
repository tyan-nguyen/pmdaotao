<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ptx_xe_log_api".
 *
 * @property int $id
 * @property string $ma_camera
 * @property string $ma_bien_so
 * @property string $thoi_gian
 */
class XeLogApi extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ptx_xe_log_api';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ma_camera', 'ma_bien_so'], 'required'],
            [['thoi_gian'], 'safe'],
            [['ma_camera', 'ma_bien_so'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ma_camera' => 'Ma Camera',
            'ma_bien_so' => 'Ma Bien So',
            'thoi_gian' => 'Thoi Gian',
        ];
    }
}
