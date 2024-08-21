<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kho_kho".
 *
 * @property int $id
 * @property string $ten_kho
 * @property string|null $so_do_kho
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property KhoKe[] $khoKes
 * @property KhoLuuKho[] $khoLuuKhos
 */
class KhoKho extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kho_kho';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten_kho'], 'required'],
            [['nguoi_tao'], 'integer'],
            [['thoi_gian_tao'], 'safe'],
            [['ten_kho', 'so_do_kho'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ten_kho' => 'Ten Kho',
            'so_do_kho' => 'So Do Kho',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
        ];
    }

    /**
     * Gets query for [[KhoKes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKhoKes()
    {
        return $this->hasMany(KhoKe::class, ['id_kho' => 'id']);
    }

    /**
     * Gets query for [[KhoLuuKhos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKhoLuuKhos()
    {
        return $this->hasMany(KhoLuuKho::class, ['id_kho' => 'id']);
    }
}
