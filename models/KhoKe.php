<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kho_ke".
 *
 * @property int $id
 * @property int $id_kho
 * @property string $ten_ke
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property KhoKho $kho
 * @property KhoLuuKho[] $khoLuuKhos
 * @property KhoNgan[] $khoNgans
 */
class KhoKe extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kho_ke';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_kho', 'ten_ke'], 'required'],
            [['id_kho', 'nguoi_tao'], 'integer'],
            [['thoi_gian_tao'], 'safe'],
            [['ten_ke'], 'string', 'max' => 255],
            [['id_kho'], 'exist', 'skipOnError' => true, 'targetClass' => KhoKho::class, 'targetAttribute' => ['id_kho' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_kho' => 'Id Kho',
            'ten_ke' => 'Ten Ke',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
        ];
    }

    /**
     * Gets query for [[Kho]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKho()
    {
        return $this->hasOne(KhoKho::class, ['id' => 'id_kho']);
    }

    /**
     * Gets query for [[KhoLuuKhos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKhoLuuKhos()
    {
        return $this->hasMany(KhoLuuKho::class, ['id_ke' => 'id']);
    }

    /**
     * Gets query for [[KhoNgans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKhoNgans()
    {
        return $this->hasMany(KhoNgan::class, ['id_ke' => 'id']);
    }
}
