<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "nv_to".
 *
 * @property int $id
 * @property int|null $id_phong_ban
 * @property string $ten_to
 *
 * @property NvNhanVien[] $nvNhanViens
 * @property NvPhongBan $phongBan
 */
class NvTo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nv_to';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_phong_ban'], 'integer'],
            [['ten_to'], 'required'],
            [['ten_to'], 'string', 'max' => 255],
            [['id_phong_ban'], 'exist', 'skipOnError' => true, 'targetClass' => NvPhongBan::class, 'targetAttribute' => ['id_phong_ban' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_phong_ban' => 'Id Phong Ban',
            'ten_to' => 'Ten To',
        ];
    }

    /**
     * Gets query for [[NvNhanViens]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNvNhanViens()
    {
        return $this->hasMany(NvNhanVien::class, ['id_to' => 'id']);
    }

    /**
     * Gets query for [[PhongBan]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPhongBan()
    {
        return $this->hasOne(NvPhongBan::class, ['id' => 'id_phong_ban']);
    }
}
