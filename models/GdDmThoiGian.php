<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gd_dm_thoi_gian".
 *
 * @property int $id
 * @property string $ten_thoi_gian
 * @property int $stt
 * @property string $thoi_gian_bd
 * @property string $thoi_gian_kt
 * @property float|null $so_gio
 * @property string|null $ghi_chu
 * @property int|null $active
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 */
class GdDmThoiGian extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gd_dm_thoi_gian';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['so_gio', 'ghi_chu', 'active', 'nguoi_tao', 'thoi_gian_tao'], 'default', 'value' => null],
            [['ten_thoi_gian', 'stt', 'thoi_gian_bd', 'thoi_gian_kt'], 'required'],
            [['stt', 'active', 'nguoi_tao'], 'integer'],
            [['thoi_gian_bd', 'thoi_gian_kt', 'thoi_gian_tao'], 'safe'],
            [['so_gio'], 'number'],
            [['ghi_chu'], 'string'],
            [['ten_thoi_gian'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ten_thoi_gian' => 'Ten Thoi Gian',
            'stt' => 'Stt',
            'thoi_gian_bd' => 'Thoi Gian Bd',
            'thoi_gian_kt' => 'Thoi Gian Kt',
            'so_gio' => 'So Gio',
            'ghi_chu' => 'Ghi Chu',
            'active' => 'Active',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
        ];
    }

}
