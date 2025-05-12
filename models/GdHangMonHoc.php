<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gd_hang_mon_hoc".
 *
 * @property int $id
 * @property int $id_hang
 * @property int $id_mon
 * @property int|null $dang_hieu_luc
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property HvHangDaoTao $hang
 * @property GdMonHoc $mon
 */
class GdHangMonHoc extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gd_hang_mon_hoc';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dang_hieu_luc', 'nguoi_tao', 'thoi_gian_tao'], 'default', 'value' => null],
            [['id_hang', 'id_mon'], 'required'],
            [['id_hang', 'id_mon', 'dang_hieu_luc', 'nguoi_tao'], 'integer'],
            [['thoi_gian_tao'], 'safe'],
            [['id_hang'], 'exist', 'skipOnError' => true, 'targetClass' => HvHangDaoTao::class, 'targetAttribute' => ['id_hang' => 'id']],
            [['id_mon'], 'exist', 'skipOnError' => true, 'targetClass' => GdMonHoc::class, 'targetAttribute' => ['id_mon' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_hang' => 'Id Hang',
            'id_mon' => 'Id Mon',
            'dang_hieu_luc' => 'Dang Hieu Luc',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
        ];
    }

    /**
     * Gets query for [[Hang]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHang()
    {
        return $this->hasOne(HvHangDaoTao::class, ['id' => 'id_hang']);
    }

    /**
     * Gets query for [[Mon]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMon()
    {
        return $this->hasOne(GdMonHoc::class, ['id' => 'id_mon']);
    }

}
