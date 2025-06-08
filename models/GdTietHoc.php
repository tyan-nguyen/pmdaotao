<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gd_tiet_hoc".
 *
 * @property int $id
 * @property int $id_ke_hoach
 * @property int $id_hoc_vien
 * @property int $id_giao_vien
 * @property int $id_xe
 * @property int $id_mon_hoc
 * @property int $id_thoi_gian_hoc
 * @property float $so_gio
 * @property string $thoi_gian_bd
 * @property string $thoi_gian_kt
 * @property string|null $ghi_chu
 * @property float|null $so_km
 * @property string|null $trang_thai
 * @property string|null $trang_thai_duyet
 * @property string|null $ngay_duyet
 * @property int|null $id_nguoi_duyet
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property GdKeHoach $keHoach
 */
class GdTietHoc extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gd_tiet_hoc';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ghi_chu', 'so_km', 'trang_thai', 'trang_thai_duyet', 'ngay_duyet', 'id_nguoi_duyet', 'nguoi_tao', 'thoi_gian_tao'], 'default', 'value' => null],
            [['id_ke_hoach', 'id_hoc_vien', 'id_giao_vien', 'id_xe', 'id_mon_hoc', 'id_thoi_gian_hoc', 'so_gio', 'thoi_gian_bd', 'thoi_gian_kt'], 'required'],
            [['id_ke_hoach', 'id_hoc_vien', 'id_giao_vien', 'id_xe', 'id_mon_hoc', 'id_thoi_gian_hoc', 'id_nguoi_duyet', 'nguoi_tao'], 'integer'],
            [['so_gio', 'so_km'], 'number'],
            [['thoi_gian_bd', 'thoi_gian_kt', 'ngay_duyet', 'thoi_gian_tao'], 'safe'],
            [['ghi_chu'], 'string'],
            [['trang_thai', 'trang_thai_duyet'], 'string', 'max' => 20],
            [['id_ke_hoach'], 'exist', 'skipOnError' => true, 'targetClass' => GdKeHoach::class, 'targetAttribute' => ['id_ke_hoach' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_ke_hoach' => 'Id Ke Hoach',
            'id_hoc_vien' => 'Id Hoc Vien',
            'id_giao_vien' => 'Id Giao Vien',
            'id_xe' => 'Id Xe',
            'id_mon_hoc' => 'Id Mon Hoc',
            'id_thoi_gian_hoc' => 'Id Thoi Gian Hoc',
            'so_gio' => 'So Gio',
            'thoi_gian_bd' => 'Thoi Gian Bd',
            'thoi_gian_kt' => 'Thoi Gian Kt',
            'ghi_chu' => 'Ghi Chu',
            'so_km' => 'So Km',
            'trang_thai' => 'Trang Thai',
            'trang_thai_duyet' => 'Trang Thai Duyet',
            'ngay_duyet' => 'Ngay Duyet',
            'id_nguoi_duyet' => 'Id Nguoi Duyet',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
        ];
    }

    /**
     * Gets query for [[KeHoach]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKeHoach()
    {
        return $this->hasOne(GdKeHoach::class, ['id' => 'id_ke_hoach']);
    }

}
