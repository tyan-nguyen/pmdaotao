<?php

namespace app\modules\kholuutru\models;

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
 * @property Ke[] $khoKes
 * @property LuuKho[] $khoLuuKhos
 */
class Kho extends \app\models\KhoKho
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
            'ten_kho' => 'Tên Kho',
            'so_do_kho' => 'Sơ đồ Kho',
            'nguoi_tao' => 'Người tạo',
            'thoi_gian_tao' => 'Thời gian tạo',
        ];
    }

    /**
     * Gets query for [[KhoKes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKhoKes()
    {
        return $this->hasMany(Ke::class, ['id_kho' => 'id']);
    }

    /**
     * Gets query for [[KhoLuuKhos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKhoLuuKhos()
    {
        return $this->hasMany(LuuKho::class, ['id_kho' => 'id']);
    }
}
