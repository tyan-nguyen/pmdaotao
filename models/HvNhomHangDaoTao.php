<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hv_nhom_hang_dao_tao".
 *
 * @property int $id
 * @property string|null $ma_nhom_hang
 * @property string $ten_nhom_hang
 * @property int|null $stt
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 * @property string|null $ghi_chu
 */
class HvNhomHangDaoTao extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hv_nhom_hang_dao_tao';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ma_nhom_hang', 'stt', 'nguoi_tao', 'thoi_gian_tao', 'ghi_chu'], 'default', 'value' => null],
            [['ten_nhom_hang'], 'required'],
            [['stt', 'nguoi_tao'], 'integer'],
            [['thoi_gian_tao'], 'safe'],
            [['ghi_chu'], 'string'],
            [['ma_nhom_hang'], 'string', 'max' => 50],
            [['ten_nhom_hang'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ma_nhom_hang' => 'Ma Nhom Hang',
            'ten_nhom_hang' => 'Ten Nhom Hang',
            'stt' => 'Stt',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
            'ghi_chu' => 'Ghi Chu',
        ];
    }

}
