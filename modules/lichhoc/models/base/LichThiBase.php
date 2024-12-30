<?php

namespace app\modules\lichhoc\models\base;

use Yii;
use app\modules\nhanvien\models\NhanVien;
use app\modules\khoahoc\models\KhoaHoc;
use app\modules\khoahoc\models\NhomHoc;
use app\modules\lichhoc\models\PhongHoc;

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
 * @property NhanVien $giaoVienGac
 * @property KhoaHoc $khoaHoc
 * @property Nhom $nhom
 * @property PhongHoc $phongThi
 */
class LichThiBase extends \app\models\LhLichThi 
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
            [['id_khoa_hoc', 'id_phong_thi', 'id_giao_vien_gac', 'thoi_gian_thi'], 'required'],
            [['id_khoa_hoc', 'id_nhom', 'id_phong_thi', 'id_giao_vien_gac', 'nguoi_tao'], 'integer'],
            [['thoi_gian_thi', 'thoi_gian_tao'], 'safe'],
            [['id_giao_vien_gac'], 'exist', 'skipOnError' => true, 'targetClass' => NhanVien::class, 'targetAttribute' => ['id_giao_vien_gac' => 'id']],
            [['id_khoa_hoc'], 'exist', 'skipOnError' => true, 'targetClass' => KhoaHoc::class, 'targetAttribute' => ['id_khoa_hoc' => 'id']],
            [['id_nhom'], 'exist', 'skipOnError' => true, 'targetClass' => NhomHoc::class, 'targetAttribute' => ['id_nhom' => 'id']],
            [['id_phong_thi'], 'exist', 'skipOnError' => true, 'targetClass' => PhongHoc::class, 'targetAttribute' => ['id_phong_thi' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_khoa_hoc' => 'Khóa học',
            'id_nhom' => 'Nhóm',
            'id_phong_thi' => 'Phòng thi',
            'id_giao_vien_gac' => 'Cán bộ coi thi',
            'thoi_gian_thi' => 'Thời gian thi',
            'trang_thai' => 'Trạng thái',
            'nguoi_tao' => 'Người tạo',
            'thoi_gian_tao' => 'Thời gian tạo',
        ];
    }

    /**
     * Gets query for [[GiaoVienGac]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGiaoVien()
    {
        return $this->hasOne(NhanVien::class, ['id' => 'id_giao_vien_gac']);
    }

    /**
     * Gets query for [[KhoaHoc]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKhoaHoc()
    {
        return $this->hasOne(KhoaHoc::class, ['id' => 'id_khoa_hoc']);
    }

    /**
     * Gets query for [[Nhom]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNhom()
    {
        return $this->hasOne(NhomHoc::class, ['id' => 'id_nhom']);
    }

    /**
     * Gets query for [[PhongThi]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPhongThi()
    {
        return $this->hasOne(PhongHoc::class, ['id' => 'id_phong_thi']);
    }
}
