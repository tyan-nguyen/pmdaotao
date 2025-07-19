<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "banle_dvt".
 *
 * @property int $id
 * @property string $ten_dvt
 * @property string|null $ghi_chu
 * @property int|null $nguoi_tao
 * @property int|null $thoi_gian_tao
 */
class BanleDvt extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'banle_dvt';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ghi_chu', 'nguoi_tao', 'thoi_gian_tao'], 'default', 'value' => null],
            [['ten_dvt'], 'required'],
            [['ghi_chu'], 'string'],
            [['nguoi_tao', 'thoi_gian_tao'], 'integer'],
            [['ten_dvt'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ten_dvt' => 'Ten Dvt',
            'ghi_chu' => 'Ghi Chu',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
        ];
    }

}
