<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hv_hang_dao_tao".
 *
 * @property int $id
 * @property string $ten_hang
 * @property string|null $ghi_chu
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property HvHocPhi[] $hvHocPhis
 * @property HvKhoaHoc[] $hvKhoaHocs
 */
class HvHangDaoTao extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hv_hang_dao_tao';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten_hang'], 'required'],
            [['ghi_chu'], 'string'],
            [['nguoi_tao'], 'integer'],
            [['thoi_gian_tao'], 'safe'],
            [['ten_hang'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ten_hang' => 'Ten Hang',
            'ghi_chu' => 'Ghi Chu',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
        ];
    }

    /**
     * Gets query for [[HvHocPhis]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHvHocPhis()
    {
        return $this->hasMany(HvHocPhi::class, ['id_hang' => 'id']);
    }

    /**
     * Gets query for [[HvKhoaHocs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHvKhoaHocs()
    {
        return $this->hasMany(HvKhoaHoc::class, ['id_hang' => 'id']);
    }
}
