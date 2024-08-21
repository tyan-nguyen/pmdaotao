<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "nv_phong_ban".
 *
 * @property int $id
 * @property string $ten_phong_ban
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property NvNhanVien[] $nvNhanViens
 * @property NvTo[] $nvTos
 */
class NvPhongBan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nv_phong_ban';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten_phong_ban'], 'required'],
            [['nguoi_tao'], 'integer'],
            [['thoi_gian_tao'], 'safe'],
            [['ten_phong_ban'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ten_phong_ban' => 'Ten Phong Ban',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
        ];
    }

    /**
     * Gets query for [[NvNhanViens]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNvNhanViens()
    {
        return $this->hasMany(NvNhanVien::class, ['id_phong_ban' => 'id']);
    }

    /**
     * Gets query for [[NvTos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNvTos()
    {
        return $this->hasMany(NvTo::class, ['id_phong_ban' => 'id']);
    }
}
