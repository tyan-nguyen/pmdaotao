<?php

namespace app\modules\lichhoc\models\base;

use Yii;
use app\modules\nhanvien\models\NhanVien;
use app\modules\khoahoc\models\KhoaHoc;
use app\modules\lichhoc\models\PhongHoc;
use app\modules\khoahoc\models\NhomHoc;
use app\modules\lichhoc\models\LichHoc;

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
class LichHocBase extends \app\models\LhLichHoc
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
            [['id_giao_vien'], 'exist', 'skipOnError' => true, 'targetClass' => NhanVien::class, 'targetAttribute' => ['id_giao_vien' => 'id']],
            [['id_nhom'], 'exist', 'skipOnError' => true, 'targetClass' => NhomHoc::class, 'targetAttribute' => ['id_nhom' => 'id']],
            [['id_khoa_hoc'], 'exist', 'skipOnError' => true, 'targetClass' => KhoaHoc::class, 'targetAttribute' => ['id_khoa_hoc' => 'id']],
            [['id_phong'], 'exist', 'skipOnError' => true, 'targetClass' => PhongHoc::class, 'targetAttribute' => ['id_phong' => 'id']],
           
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
            'hoc_phan' => 'Học phần',
            'id_nhom' => 'Nhóm học',
            'id_phong' => 'Phòng học',
            'id_giao_vien' => 'Giáo viên giảng dạy',
            'ngay' => 'Ngày',
            'thu' => 'Thứ',
            'tiet_bat_dau' => 'Tiết bắt đầu',
            'tiet_ket_thuc' => 'Tiết kết thúc',
            'nguoi_tao' => 'Người tạo',
            'thoi_gian_tao' => 'Thời gian tạo',
        ];
    }

    /**
     * Gets query for [[GiaoVien]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGiaoVien()
    {
        return $this->hasOne(NhanVien::class, ['id' => 'id_giao_vien']);
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
     * Gets query for [[Phong]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPhong()
    {
        return $this->hasOne(PhongHoc::class, ['id' => 'id_phong']);
    }

    public function getNhomHoc()
    {
        return $this->hasOne(NhomHoc::class, ['id' => 'id_nhom']);
    }
}
