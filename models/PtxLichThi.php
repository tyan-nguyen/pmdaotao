<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ptx_lich_thi".
 *
 * @property int $id
 * @property string|null $phan_loai
 * @property string|null $ten_ky_thi
 * @property string $thoi_gian_bd
 * @property string $thoi_gian_kt
 * @property string|null $ghi_chu
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 */
class PtxLichThi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ptx_lich_thi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['phan_loai', 'ten_ky_thi', 'ghi_chu', 'nguoi_tao', 'thoi_gian_tao'], 'default', 'value' => null],
            [['thoi_gian_bd', 'thoi_gian_kt'], 'required'],
            [['thoi_gian_bd', 'thoi_gian_kt', 'thoi_gian_tao'], 'safe'],
            [['ghi_chu'], 'string'],
            [['nguoi_tao'], 'integer'],
            [['phan_loai'], 'string', 'max' => 20],
            [['ten_ky_thi'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'phan_loai' => 'Phan Loai',
            'ten_ky_thi' => 'Ten Ky Thi',
            'thoi_gian_bd' => 'Thoi Gian Bd',
            'thoi_gian_kt' => 'Thoi Gian Kt',
            'ghi_chu' => 'Ghi Chu',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
        ];
    }

}
