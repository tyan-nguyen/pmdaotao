<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gd_mon_hoc".
 *
 * @property int $id
 * @property string|null $ma_mon
 * @property string|null $ten_mon
 * @property string|null $ten_mon_sub
 * @property float|null $so_gio_qd
 * @property float|null $so_gio_tt
 * @property string|null $ghi_chu
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property GdHangMonHoc[] $gdHangMonHocs
 * @property GdTietHoc[] $gdTietHocs
 */
class GdMonHoc extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gd_mon_hoc';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ma_mon', 'ten_mon', 'ten_mon_sub', 'so_gio_qd', 'so_gio_tt', 'ghi_chu', 'nguoi_tao', 'thoi_gian_tao'], 'default', 'value' => null],
            [['so_gio_qd', 'so_gio_tt'], 'number'],
            [['ghi_chu'], 'string'],
            [['nguoi_tao'], 'integer'],
            [['thoi_gian_tao'], 'safe'],
            [['ma_mon'], 'string', 'max' => 20],
            [['ten_mon', 'ten_mon_sub'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ma_mon' => 'Ma Mon',
            'ten_mon' => 'Ten Mon',
            'ten_mon_sub' => 'Ten Mon Sub',
            'so_gio_qd' => 'So Gio Qd',
            'so_gio_tt' => 'So Gio Tt',
            'ghi_chu' => 'Ghi Chu',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
        ];
    }

    /**
     * Gets query for [[GdHangMonHocs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGdHangMonHocs()
    {
        return $this->hasMany(GdHangMonHoc::class, ['id_mon' => 'id']);
    }

    /**
     * Gets query for [[GdTietHocs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGdTietHocs()
    {
        return $this->hasMany(GdTietHoc::class, ['id_mon_hoc' => 'id']);
    }

}
