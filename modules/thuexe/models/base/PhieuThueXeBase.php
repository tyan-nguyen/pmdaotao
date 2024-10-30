<?php

namespace app\modules\thuexe\models\base;

use Yii;
use app\models\PtxXe;
use app\models\PtxLoaiHinhThue;
/**
 * This is the model class for table "ptx_phieu_thue_xe".
 *
 * @property int $id
 * @property string|null $ngay_thue_xe
 * @property int|null $id_hoc_vien
 * @property string|null $ho_ten_nguoi_thue
 * @property string|null $so_cccd_nguoi_thue
 * @property string|null $dia_chi_nguoi_thue
 * @property string|null $so_dien_thoai_nguoi_thue
 * @property int $id_xe
 * @property int|null $id_loai_hinh_thue
 * @property string|null $thoi_gian_bat_dau_thue
 * @property string|null $thoi_gian_tra_xe_du_kien
 * @property float|null $chi_phi_thue_du_kien
 * @property string|null $thoi_gian_tra_xe
 * @property float|null $chi_phi_thue_phat_sinh
 * @property int|null $id_nhan_vien_cho_thue
 * @property string|null $noi_dung_thue
 * @property string|null $ngay_tra_xe
 * @property string|null $tinh_trang_xe_khi_tra
 * @property int|null $id_nhan_vien_ky_tra
 * @property int|null $id_nguoi_gui
 * @property string|null $thoi_gian_gui
 * @property string|null $ghi_chu_nguoi_gui
 * @property int|null $id_nguoi_duyet
 * @property string|null $thoi_gian_duyet
 * @property string|null $ghi_chu_nguoi_duyet
 * @property string|null $trang_thai
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 *
 * @property PtxLoaiHinhThue $loaiHinhThue
 * @property PtxXe $xe
 */
class PhieuThueXeBase extends \app\models\PtxPhieuThueXe
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ptx_phieu_thue_xe';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ngay_thue_xe', 'thoi_gian_bat_dau_thue', 'thoi_gian_tra_xe_du_kien', 'thoi_gian_tra_xe', 'ngay_tra_xe', 'thoi_gian_gui', 'thoi_gian_duyet', 'ghi_chu_nguoi_duyet', 'thoi_gian_tao'], 'safe'],
            [['id_hoc_vien', 'id_xe', 'id_loai_hinh_thue', 'id_nhan_vien_cho_thue', 'id_nhan_vien_ky_tra', 'id_nguoi_gui', 'id_nguoi_duyet', 'nguoi_tao'], 'integer'],
            [['id_xe'], 'required'],
            [['chi_phi_thue_du_kien', 'chi_phi_thue_phat_sinh'], 'number'],
            [['noi_dung_thue', 'tinh_trang_xe_khi_tra', 'ghi_chu_nguoi_gui'], 'string'],
            [['ho_ten_nguoi_thue', 'so_cccd_nguoi_thue', 'dia_chi_nguoi_thue', 'so_dien_thoai_nguoi_thue'], 'string', 'max' => 255],
            [['trang_thai'], 'string', 'max' => 25],
            [['id_xe'], 'exist', 'skipOnError' => true, 'targetClass' => PtxXe::class, 'targetAttribute' => ['id_xe' => 'id']],
            [['id_loai_hinh_thue'], 'exist', 'skipOnError' => true, 'targetClass' => PtxLoaiHinhThue::class, 'targetAttribute' => ['id_loai_hinh_thue' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ngay_thue_xe' => 'Ngày Thuê Xe',
            'id_hoc_vien' => 'Học Viên',
            'ho_ten_nguoi_thue' => 'Họ Tên Người Thuê',
            'so_cccd_nguoi_thue' => 'Số CCCD Người Thuê',
            'dia_chi_nguoi_thue' => 'Địa Chỉ Người Thuê',
            'so_dien_thoai_nguoi_thue' => 'Số Điện Thoại Người Thuê',
            'id_xe' => 'Xe Thuê',
            'id_loai_hinh_thue' => 'Loại Hình Thuê',
            'thoi_gian_bat_dau_thue' => 'Thời Gian Bắt Đầu Thuê',
            'thoi_gian_tra_xe_du_kien' => 'Thời Gian Trả Xe Dự Kiến',
            'chi_phi_thue_du_kien' => 'Chi Phí Thuê',
            'thoi_gian_tra_xe' => 'Thời Gian Trả Xe',
            'chi_phi_thue_phat_sinh' => 'Chi Phí Thuê Phát Sinh',
            'id_nhan_vien_cho_thue' => 'Nhân Viên Phụ Trách',
            'noi_dung_thue' => 'Nội Dung Thuê',
            'ngay_tra_xe' => 'Ngày Trả Xe',
            'tinh_trang_xe_khi_tra' => 'Tình Trạng Khi Trả',
            'id_nhan_vien_ky_tra' => 'Nhân Viên Ký Trả',
            'id_nguoi_gui' => 'Người Gửi',
            'thoi_gian_gui' => 'Thời Gian Gửi',
            'ghi_chu_nguoi_gui' => 'Ghi Chú Người Gửi',
            'id_nguoi_duyet' => 'Người Duyệt',
            'thoi_gian_duyet' => 'Thời Gian Duyệt',
            'ghi_chu_nguoi_duyet' => 'Ghi Chú Người Duyệt',
            'trang_thai' => 'Trạng Thái',
            'nguoi_tao' => 'Nguười Tạo',
            'thoi_gian_tao' => 'Thời Gian Tạo',
        ];
    }

    /**
     * Gets query for [[LoaiHinhThue]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLoaiHinhThue()
    {
        return $this->hasOne(PtxLoaiHinhThue::class, ['id' => 'id_loai_hinh_thue']);
    }

    /**
     * Gets query for [[Xe]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getXe()
    {
        return $this->hasOne(PtxXe::class, ['id' => 'id_xe']);
    }
}
