<?php

namespace app\modules\kholuutru\models;

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
 * @property Kho $kho
 * @property LuuKho[] $khoLuuKhos
 * @property Ngan[] $khoNgans
 */
class Ke extends \app\models\KhoKe
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
            [['id_kho'], 'exist', 'skipOnError' => true, 'targetClass' => Kho::class, 'targetAttribute' => ['id_kho' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_kho' => 'Kho',
            'ten_ke' => 'Tên Kệ',
            'nguoi_tao' => 'Người tạo',
            'thoi_gian_tao' => 'Thời gian tạo',
        ];
    }

    /**
     * Gets query for [[Kho]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKho()
    {
        return $this->hasOne(Kho::class, ['id' => 'id_kho']);
    }

    /**
     * Gets query for [[KhoLuuKhos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKhoLuuKhos()
    {
        return $this->hasMany(LuuKho::class, ['id_ke' => 'id']);
    }

    /**
     * Gets query for [[KhoNgans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKhoNgans()
    {
        return $this->hasMany(Ngan::class, ['id_ke' => 'id']);
    }
}
