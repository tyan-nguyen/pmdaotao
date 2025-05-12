<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gd_ke_hoach".
 *
 * @property int $id
 * @property int $id_giao_vien
 * @property string $ngay_thuc_hien
 * @property string|null $ghi_chu
 * @property string|null $trang_thai_duyet
 * @property int|null $id_nguoi_duyet
 * @property string|null $noi_dung_duyet
 * @property string|null $thoi_gian_duyet
 * @property string|null $thoi_gian_tao
 * @property int|null $nguoi_tao
 *
 * @property GdTietHoc[] $gdTietHocs
 */
class GdKeHoach extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gd_ke_hoach';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ghi_chu', 'trang_thai_duyet', 'id_nguoi_duyet', 'noi_dung_duyet', 'thoi_gian_duyet', 'thoi_gian_tao', 'nguoi_tao'], 'default', 'value' => null],
            [['id_giao_vien', 'ngay_thuc_hien'], 'required'],
            [['id_giao_vien', 'id_nguoi_duyet', 'nguoi_tao'], 'integer'],
            [['ngay_thuc_hien', 'thoi_gian_duyet', 'thoi_gian_tao'], 'safe'],
            [['ghi_chu', 'noi_dung_duyet'], 'string'],
            [['trang_thai_duyet'], 'string', 'max' => 20],
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
            'ngay_thuc_hien' => 'Ngay Thuc Hien',
            'ghi_chu' => 'Ghi Chu',
            'trang_thai_duyet' => 'Trang Thai Duyet',
            'id_nguoi_duyet' => 'Id Nguoi Duyet',
            'noi_dung_duyet' => 'Noi Dung Duyet',
            'thoi_gian_duyet' => 'Thoi Gian Duyet',
            'thoi_gian_tao' => 'Thoi Gian Tao',
            'nguoi_tao' => 'Nguoi Tao',
        ];
    }

    /**
     * Gets query for [[GdTietHocs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGdTietHocs()
    {
        return $this->hasMany(GdTietHoc::class, ['id_ke_hoach' => 'id']);
    }

}
