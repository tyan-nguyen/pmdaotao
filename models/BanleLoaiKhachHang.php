<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "banle_loai_khach_hang".
 *
 * @property int $id
 * @property string $ten_loai_khach_hang
 * @property string|null $ghi_chu
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property BanleKhachHang[] $banleKhachHangs
 */
class BanleLoaiKhachHang extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'banle_loai_khach_hang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ghi_chu', 'nguoi_tao', 'thoi_gian_tao'], 'default', 'value' => null],
            [['ten_loai_khach_hang'], 'required'],
            [['ghi_chu'], 'string'],
            [['nguoi_tao'], 'integer'],
            [['thoi_gian_tao'], 'safe'],
            [['ten_loai_khach_hang'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ten_loai_khach_hang' => 'Ten Loai Khach Hang',
            'ghi_chu' => 'Ghi Chu',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
        ];
    }

    /**
     * Gets query for [[BanleKhachHangs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBanleKhachHangs()
    {
        return $this->hasMany(BanleKhachHang::class, ['id_loai_khach_hang' => 'id']);
    }

}
