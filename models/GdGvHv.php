<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gd_gv_hv".
 *
 * @property int $id
 * @property int $id_giao_vien
 * @property int $id_hoc_vien
 * @property int|null $da_hoan_thanh
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property NvNhanVien $giaoVien
 * @property HvHocVien $hocVien
 */
class GdGvHv extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gd_gv_hv';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nguoi_tao', 'thoi_gian_tao'], 'default', 'value' => null],
            [['id_giao_vien', 'id_hoc_vien'], 'required'],
            [['id_giao_vien', 'id_hoc_vien', 'nguoi_tao', 'da_hoan_thanh'], 'integer'],
            [['thoi_gian_tao'], 'safe'],
            [['id_giao_vien'], 'exist', 'skipOnError' => true, 'targetClass' => NvNhanVien::class, 'targetAttribute' => ['id_giao_vien' => 'id']],
            [['id_hoc_vien'], 'exist', 'skipOnError' => true, 'targetClass' => HvHocVien::class, 'targetAttribute' => ['id_hoc_vien' => 'id']],
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
            'id_hoc_vien' => 'Id Hoc Vien',
            'da_hoan_thanh' => 'Đã hoàn thành',
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
     * Gets query for [[HocVien]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHocVien()
    {
        return $this->hasOne(HvHocVien::class, ['id' => 'id_hoc_vien']);
    }

}
