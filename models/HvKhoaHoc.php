<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hv_khoa_hoc".
 *
 * @property int $id
 * @property int $id_hang
 * @property string $ten_khoa_hoc
 * @property string $ngay_bat_dau
 * @property string $ngay_ket_thuc
 * @property string|null $ghi_chu
 * @property string $trang_thai
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 * @property int|null $id_hoc_phi
 * @property int | $so_hoc_vien_khoa_hoc 
 * @property HvHangDaoTao $hang
 * @property HvHocVien[] $hvHocViens
 * @property HvTaiLieuKhoaHoc[] $hvTaiLieuKhoaHocs
 */
class HvKhoaHoc extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hv_khoa_hoc';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_hang', 'ten_khoa_hoc', 'ngay_bat_dau', 'ngay_ket_thuc', 'trang_thai'], 'required'],
            [['id_hang', 'nguoi_tao'], 'integer'],
            [['ngay_bat_dau', 'ngay_ket_thuc', 'thoi_gian_tao'], 'safe'],
            [['ghi_chu'], 'string'],
            [['ten_khoa_hoc', 'trang_thai'], 'string', 'max' => 255],
            [['id_hang'], 'exist', 'skipOnError' => true, 'targetClass' => HvHangDaoTao::class, 'targetAttribute' => ['id_hang' => 'id']],
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
            'ten_khoa_hoc' => 'Ten Khoa Hoc',
            'ngay_bat_dau' => 'Ngay Bat Dau',
            'ngay_ket_thuc' => 'Ngay Ket Thuc',
            'ghi_chu' => 'Ghi Chu',
            'trang_thai' => 'Trang Thai',
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
     * Gets query for [[HvHocViens]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHvHocViens()
    {
        return $this->hasMany(HvHocVien::class, ['id_khoa_hoc' => 'id']);
    }

    /**
     * Gets query for [[HvTaiLieuKhoaHocs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHvTaiLieuKhoaHocs()
    {
        return $this->hasMany(HvTaiLieuKhoaHoc::class, ['id_khoa_hoc' => 'id']);
    }
}
