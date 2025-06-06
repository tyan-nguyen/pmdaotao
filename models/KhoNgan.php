<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kho_ngan".
 *
 * @property int $id
 * @property int $id_ke
 * @property string $ten_ngan
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property KhoKe $ke
 * @property KhoHop[] $khoHops
 * @property KhoLuuKho[] $khoLuuKhos
 */
class KhoNgan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kho_ngan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_ke', 'ten_ngan'], 'required'],
            [['id_ke', 'nguoi_tao'], 'integer'],
            [['thoi_gian_tao'], 'safe'],
            [['ten_ngan'], 'string', 'max' => 255],
            [['id_ke'], 'exist', 'skipOnError' => true, 'targetClass' => KhoKe::class, 'targetAttribute' => ['id_ke' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_ke' => 'Id Ke',
            'ten_ngan' => 'Ten Ngan',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
        ];
    }

    /**
     * Gets query for [[Ke]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKe()
    {
        return $this->hasOne(KhoKe::class, ['id' => 'id_ke']);
    }

    /**
     * Gets query for [[KhoHops]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKhoHops()
    {
        return $this->hasMany(KhoHop::class, ['id_ngan' => 'id']);
    }

    /**
     * Gets query for [[KhoLuuKhos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKhoLuuKhos()
    {
        return $this->hasMany(KhoLuuKho::class, ['id_ngan' => 'id']);
    }
}
