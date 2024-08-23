<?php

namespace app\modules\giaovien\models;

use Yii;

/**
 * This is the model class for table "nv_hang_xe".
 *
 * @property int $id
 * @property string $ten_hang_xe
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property NvDay[] $nvDays
 */
class HangXe extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nv_hang_xe';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten_hang_xe'], 'required'],
            [['nguoi_tao'], 'integer'],
            [['thoi_gian_tao'], 'safe'],
            [['ten_hang_xe'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ten_hang_xe' => 'Ten Hang Xe',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
        ];
    }

    /**
     * Gets query for [[NvDays]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNvDays()
    {
        return $this->hasMany(Day::class, ['id_hang_xe' => 'id']);
    }
}
