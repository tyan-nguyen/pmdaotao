<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gd_gv_xe".
 *
 * @property int $id
 * @property int $id_giao_vien
 * @property int $id_xe
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property NvNhanVien $giaoVien
 * @property PtxXe $xe
 */
class GdGvXe extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gd_gv_xe';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nguoi_tao', 'thoi_gian_tao'], 'default', 'value' => null],
            [['id_giao_vien', 'id_xe'], 'required'],
            [['id_giao_vien', 'id_xe', 'nguoi_tao'], 'integer'],
            [['thoi_gian_tao'], 'safe'],
            [['id_giao_vien'], 'exist', 'skipOnError' => true, 'targetClass' => NvNhanVien::class, 'targetAttribute' => ['id_giao_vien' => 'id']],
            [['id_xe'], 'exist', 'skipOnError' => true, 'targetClass' => PtxXe::class, 'targetAttribute' => ['id_xe' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_giao_vien' => 'Id Giao Vien',
            'id_xe' => 'Id Xe',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
        ];
    }

    /**
     * Gets query for [[GiaoVien]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGiaoVien()
    {
        return $this->hasOne(NvNhanVien::class, ['id' => 'id_giao_vien']);
    }

    /**
     * Gets query for [[Xe]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getXe()
    {
        return $this->hasOne(PtxXe::class, ['id' => 'id_xe']);
    }

}
