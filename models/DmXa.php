<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dm_xa".
 *
 * @property int $id
 * @property int $id_tinh
 * @property int $ma_tinh
 * @property int|null $ma_xa
 * @property string $loai Xã/Phường
 * @property string $ten_xa
 * @property string $ten_xa_full
 * @property string|null $ghi_chu
 * @property int $stt
 *
 * @property DmTinh $tinh
 */
class DmXa extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dm_xa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ma_xa', 'ghi_chu'], 'default', 'value' => null],
            [['id_tinh', 'ma_tinh', 'loai', 'ten_xa', 'ten_xa_full', 'stt'], 'required'],
            [['id_tinh', 'ma_tinh', 'ma_xa', 'stt'], 'integer'],
            [['ghi_chu'], 'string'],
            [['loai'], 'string', 'max' => 20],
            [['ten_xa', 'ten_xa_full'], 'string', 'max' => 100],
            [['id_tinh'], 'exist', 'skipOnError' => true, 'targetClass' => DmTinh::class, 'targetAttribute' => ['id_tinh' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_tinh' => 'Id Tinh',
            'ma_tinh' => 'Ma Tinh',
            'ma_xa' => 'Ma Xa',
            'loai' => 'Loai',
            'ten_xa' => 'Ten Xa',
            'ten_xa_full' => 'Ten Xa Full',
            'ghi_chu' => 'Ghi Chu',
            'stt' => 'Stt',
        ];
    }

    /**
     * Gets query for [[Tinh]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTinh()
    {
        return $this->hasOne(DmTinh::class, ['id' => 'id_tinh']);
    }

}
