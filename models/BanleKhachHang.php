<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "banle_khach_hang".
 *
 * @property int $id
 * @property int|null $id_loai_khach_hang
 * @property string $ho_ten
 * @property string|null $so_dien_thoai
 * @property string|null $dia_chi
 * @property string|null $thoi_gian_tao
 * @property int|null $nguoi_tao
 *
 * @property BanleLoaiKhachHang $loaiKhachHang
 */
class BanleKhachHang extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'banle_khach_hang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_loai_khach_hang', 'so_dien_thoai', 'dia_chi', 'thoi_gian_tao', 'nguoi_tao'], 'default', 'value' => null],
            [['id_loai_khach_hang', 'nguoi_tao'], 'integer'],
            [['ho_ten'], 'required'],
            [['thoi_gian_tao'], 'safe'],
            [['ho_ten'], 'string', 'max' => 200],
            [['so_dien_thoai'], 'string', 'max' => 50],
            [['dia_chi'], 'string', 'max' => 250],
            [['id_loai_khach_hang'], 'exist', 'skipOnError' => true, 'targetClass' => BanleLoaiKhachHang::class, 'targetAttribute' => ['id_loai_khach_hang' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_loai_khach_hang' => 'Id Loai Khach Hang',
            'ho_ten' => 'Ho Ten',
            'so_dien_thoai' => 'So Dien Thoai',
            'dia_chi' => 'Dia Chi',
            'thoi_gian_tao' => 'Thoi Gian Tao',
            'nguoi_tao' => 'Nguoi Tao',
        ];
    }

    /**
     * Gets query for [[LoaiKhachHang]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLoaiKhachHang()
    {
        return $this->hasOne(BanleLoaiKhachHang::class, ['id' => 'id_loai_khach_hang']);
    }

}
