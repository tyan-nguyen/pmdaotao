<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lh_lich_hoc".
 *
 * @property int $id
 * @property int $id_khoa_hoc
 * @property string|null $hoc_phan
 * @property int|null $id_nhom
 * @property int $id_phong
 * @property int $id_giao_vien
 * @property string $ngay
 * @property string|null $thu
 * @property int $tiet_bat_dau
 * @property int $tiet_ket_thuc
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property NvNhanVien $giaoVien
 * @property HvKhoaHoc $khoaHoc
 * @property LhPhongHoc $phong
 */
class LhLichHoc extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lh_lich_hoc';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_khoa_hoc', 'id_phong', 'id_giao_vien', 'ngay', 'tiet_bat_dau', 'tiet_ket_thuc'], 'required'],
            [['id_khoa_hoc', 'id_nhom', 'id_phong', 'id_giao_vien', 'tiet_bat_dau', 'tiet_ket_thuc', 'nguoi_tao'], 'integer'],
            [['ngay', 'thoi_gian_tao'], 'safe'],
            [['hoc_phan'], 'string', 'max' => 25],
            [['thu'], 'string', 'max' => 15],
            [['id_giao_vien'], 'exist', 'skipOnError' => true, 'targetClass' => NvNhanVien::class, 'targetAttribute' => ['id_giao_vien' => 'id']],
            [['id_nhom'], 'exist', 'skipOnError' => true, 'targetClass' => HvNhom::class, 'targetAttribute' => ['id_nhom' => 'id']],
            [['id_khoa_hoc'], 'exist', 'skipOnError' => true, 'targetClass' => HvKhoaHoc::class, 'targetAttribute' => ['id_khoa_hoc' => 'id']],
            [['id_phong'], 'exist', 'skipOnError' => true, 'targetClass' => LhPhongHoc::class, 'targetAttribute' => ['id_phong' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_khoa_hoc' => 'Id Khoa Hoc',
            'hoc_phan' => 'Hoc Phan',
            'id_nhom' => 'Nhom hoc',
            'id_phong' => 'Id Phong',
            'id_giao_vien' => 'Id Giao Vien',
            'ngay' => 'Ngay',
            'thu' => 'Thu',
            'tiet_bat_dau' => 'Tiet Bat Dau',
            'tiet_ket_thuc' => 'Tiet Ket Thuc',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
        ];
    }

    /**
     * Gets query for [[GiaoVien]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGiaoVien()
    {
        return $this->hasOne(NvNhanVien::class, ['id' => 'id_giao_vien']);
    }

    /**
     * Gets query for [[KhoaHoc]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKhoaHoc()
    {
        return $this->hasOne(HvKhoaHoc::class, ['id' => 'id_khoa_hoc']);
    }

    /**
     * Gets query for [[Phong]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPhong()
    {
        return $this->hasOne(LhPhongHoc::class, ['id' => 'id_phong']);
    }
}
