<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lh_lich_thi".
 *
 * @property int $id
 * @property int $id_khoa_hoc
 * @property int|null $id_nhom
 * @property int $id_phong_thi
 * @property int $id_giao_vien_gac
 * @property string $thoi_gian_thi
 * @property string|null $trang_thai
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property NvNhanVien $giaoVienGac
 * @property HvKhoaHoc $khoaHoc
 * @property HvNhom $nhom
 * @property LhPhongHoc $phongThi
 */
class LhLichThi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lh_lich_thi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_khoa_hoc', 'hoc_phan', 'id_phong_thi', 'id_giao_vien_gac', 'thoi_gian_thi'], 'required'],
            [['id_khoa_hoc', 'id_nhom', 'id_phong_thi', 'id_giao_vien_gac', 'nguoi_tao'], 'integer'],
            [['thoi_gian_thi', 'thoi_gian_tao'], 'safe'],
            [['id_giao_vien_gac'], 'exist', 'skipOnError' => true, 'targetClass' => NvNhanVien::class, 'targetAttribute' => ['id_giao_vien_gac' => 'id']],
            [['id_khoa_hoc'], 'exist', 'skipOnError' => true, 'targetClass' => HvKhoaHoc::class, 'targetAttribute' => ['id_khoa_hoc' => 'id']],
            [['id_nhom'], 'exist', 'skipOnError' => true, 'targetClass' => HvNhom::class, 'targetAttribute' => ['id_nhom' => 'id']],
            [['id_phong_thi'], 'exist', 'skipOnError' => true, 'targetClass' => LhPhongHoc::class, 'targetAttribute' => ['id_phong_thi' => 'id']],
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
            'id_nhom' => 'Id Nhom',
            'id_phong_thi' => 'Id Phong Thi',
            'id_giao_vien_gac' => 'Id Giao Vien Gac',
            'thoi_gian_thi' => 'Thoi Gian Thi',
            'trang_thai' => 'Trang Thai',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
        ];
    }

    /**
     * Gets query for [[GiaoVienGac]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGiaoVienGac()
    {
        return $this->hasOne(NvNhanVien::class, ['id' => 'id_giao_vien_gac']);
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
     * Gets query for [[Nhom]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNhom()
    {
        return $this->hasOne(HvNhom::class, ['id' => 'id_nhom']);
    }

    /**
     * Gets query for [[PhongThi]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPhongThi()
    {
        return $this->hasOne(LhPhongHoc::class, ['id' => 'id_phong_thi']);
    }
}
