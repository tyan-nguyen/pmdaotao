<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gd_gv_xe_history".
 *
 * @property int $id
 * @property int $id_giao_vien
 * @property int $id_xe
 * @property string $time_start
 * @property string $time_end
 * @property string $date_created
 * @property int $user_created
 * @property string|null $note
 *
 * @property NvNhanVien $giaoVien
 * @property PtxXe $xe
 */
class GdGvXeHistory extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gd_gv_xe_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['note'], 'default', 'value' => null],
            [['id_giao_vien', 'id_xe', 'time_start', 'time_end', 'date_created', 'user_created'], 'required'],
            [['id_giao_vien', 'id_xe', 'user_created'], 'integer'],
            [['time_start', 'time_end', 'date_created'], 'safe'],
            [['note'], 'string'],
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
            'time_start' => 'Time Start',
            'time_end' => 'Time End',
            'date_created' => 'Date Created',
            'user_created' => 'User Created',
            'note' => 'Note',
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
