<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dm_tinh".
 *
 * @property int $id
 * @property int|null $ma_tinh
 * @property string $loai
 * @property string $ten_tinh
 * @property string $ten_tinh_full
 * @property string|null $ghi_chu
 * @property int $stt
 *
 * @property DmXa[] $dmXas
 */
class DmTinh extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dm_tinh';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ma_tinh', 'ghi_chu'], 'default', 'value' => null],
            [['ma_tinh', 'stt'], 'integer'],
            [['loai', 'ten_tinh', 'ten_tinh_full', 'stt'], 'required'],
            [['ghi_chu'], 'string'],
            [['loai'], 'string', 'max' => 20],
            [['ten_tinh', 'ten_tinh_full'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ma_tinh' => 'Ma Tinh',
            'loai' => 'Loai',
            'ten_tinh' => 'Ten Tinh',
            'ten_tinh_full' => 'Ten Tinh Full',
            'ghi_chu' => 'Ghi Chu',
            'stt' => 'Stt',
        ];
    }

    /**
     * Gets query for [[DmXas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDmXas()
    {
        return $this->hasMany(DmXa::class, ['id_tinh' => 'id']);
    }

}
