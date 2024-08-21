<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kho_hop".
 *
 * @property int $id
 * @property int $id_ngan
 * @property string $ten_hop
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property KhoLuuKho[] $khoLuuKhos
 * @property KhoNgan $ngan
 */
class KhoHop extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kho_hop';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_ngan', 'ten_hop'], 'required'],
            [['id_ngan', 'nguoi_tao'], 'integer'],
            [['thoi_gian_tao'], 'safe'],
            [['ten_hop'], 'string', 'max' => 255],
            [['id_ngan'], 'exist', 'skipOnError' => true, 'targetClass' => KhoNgan::class, 'targetAttribute' => ['id_ngan' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_ngan' => 'Id Ngan',
            'ten_hop' => 'Ten Hop',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
        ];
    }

    /**
     * Gets query for [[KhoLuuKhos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKhoLuuKhos()
    {
        return $this->hasMany(KhoLuuKho::class, ['id_hop' => 'id']);
    }

    /**
     * Gets query for [[Ngan]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNgan()
    {
        return $this->hasOne(KhoNgan::class, ['id' => 'id_ngan']);
    }
}
