<?php

namespace app\modules\hocvien\models\base;
use app\custom\CustomFunc;
use Yii;

use app\modules\hocvien\models\KhoaHoc;
use app\modules\hocvien\models\HangDaoTao;
use app\modules\hocvien\models\NopHocPhi;
use app\modules\khoahoc\models\NhomHoc;
/**
 * This is the model class for table "hv_hoc_vien".
 *
 * @property int $id
 * @property int $id_khoa_hoc
 * @property string $ho_ten
 * @property string $so_dien_thoai
 * @property string $so_cccd
 * @property string $ngay_sinh
 * @property string $trang_thai
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 * @property string $ngay_sinh
 * @property string $check_hoc_phi
 * @property int|null $id_nhom
 * @property string|null $trang_thai_duyet 
 * @property HvHoSoHocVien[] $hvHoSoHocViens
 * @property HvNopHocPhi[] $hvNopHocPhis
 * @property HvKhoaHoc $khoaHoc
* @property int|null $nguoi_duyet
 * @property string|null $loai_dang_ky
 */
class HocVienBase extends \app\models\HvHocVien
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hv_hoc_vien';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            /*[['id_hang', 'ho_ten', 'so_cccd','id_hang'], 'required'],*/
            [['id_hang', 'ho_ten', 'id_hang'], 'required'],
            [['id_khoa_hoc', 'nguoi_tao','gioi_tinh','id_hang','id_nhom','nguoi_duyet'], 'integer'],
            [['thoi_gian_tao','ngay_sinh'], 'safe'],
            [['ho_ten', 'so_dien_thoai', 'so_cccd', 'trang_thai','dia_chi','trang_thai_duyet'], 'string', 'max' => 255],
            [['check_hoc_phi'],'string','max'=>25],
            [['nguoi_lap_phieu'],'string','max'=>55],
            [['loai_dang_ky'],'string','max'=>15],
            [['id_khoa_hoc'], 'exist', 'skipOnError' => true, 'targetClass' => KhoaHoc::class, 'targetAttribute' => ['id_khoa_hoc' => 'id']],
            [['id_nhom'], 'exist', 'skipOnError' => true, 'targetClass' => NhomHoc::class, 'targetAttribute' => ['id_nhom' => 'id']],
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
            'id_hang'=>'Hạng đào tạo ',
            'ho_ten' => 'Họ tên',
            'ngay_sinh'=>'Ngày sinh',
            'so_dien_thoai' => 'Số điện thoại',
            'so_cccd' => 'Số Căn cước công dân',
            'gioi_tinh'=>'Giới tính',
            'dia_chi'=>'Địa chỉ',
            'trang_thai' => 'Trạng thái',
            'nguoi_tao' => 'Người tạo',
            'thoi_gian_tao' => 'Thời gian tạo',
            'nguoi_lap_phieu' => 'Người lặp phiếu',
            'check_hoc_phi' => 'Học phí',
            'id_nhom'=>'Nhóm',
            'loai_dang_ky'=>'Loại hình đăng ký',
            'nguoi_duyet'=>'Người duyệt',
            'trang_thai_duyet'=>'Trạng thái duyệt',
        ];
    }

    /**
     * Gets query for [[HvHoSoHocViens]].
     *
     * @return \yii\db\ActiveQuery
     */
 

    /**
     * Gets query for [[HvNopHocPhis]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHvNopHocPhis()
    {
        return $this->hasMany(NopHocPhi::class, ['id_hoc_vien' => 'id']);
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
    public function getHangDaoTao()
    {
        return $this->hasOne(HangDaoTao::class, ['id' => 'id_hang']);
    }
    public function getNhom()
    {
        return $this->hasOne(NhomHoc::class, ['id' => 'id_nhom']);
    }
    public function getNgaySinh(){
        return CustomFunc::convertYMDToDMY($this->ngay_sinh);
    }

}