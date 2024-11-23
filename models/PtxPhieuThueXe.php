<?php

namespace app\models;

use Yii;

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
 * @property string|null $buoi
 *
 * @property PtxLoaiHinhThue $loaiHinhThue
 * @property PtxXe $xe
 */
class PtxPhieuThueXe extends \yii\db\ActiveRecord
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
            [['trang_thai','buoi'], 'string', 'max' => 25],
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
            'ngay_thue_xe' => 'Ngay Thue Xe',
            'id_hoc_vien' => 'Id Hoc Vien',
            'ho_ten_nguoi_thue' => 'Ho Ten Nguoi Thue',
            'so_cccd_nguoi_thue' => 'So Cccd Nguoi Thue',
            'dia_chi_nguoi_thue' => 'Dia Chi Nguoi Thue',
            'so_dien_thoai_nguoi_thue' => 'So Dien Thoai Nguoi Thue',
            'id_xe' => 'Id Xe',
            'id_loai_hinh_thue' => 'Id Loai Hinh Thue',
            'thoi_gian_bat_dau_thue' => 'Thoi Gian Bat Dau Thue',
            'thoi_gian_tra_xe_du_kien' => 'Thoi Gian Tra Xe Du Kien',
            'chi_phi_thue_du_kien' => 'Chi Phi Thue Du Kien',
            'thoi_gian_tra_xe' => 'Thoi Gian Tra Xe',
            'chi_phi_thue_phat_sinh' => 'Chi Phí Phát Sinh',
            'id_nhan_vien_cho_thue' => 'Id Nhan Vien Cho Thue',
            'noi_dung_thue' => 'Noi Dung Thue',
            'ngay_tra_xe' => 'Ngay Tra Xe',
            'tinh_trang_xe_khi_tra' => 'Tinh Trang Xe Khi Tra',
            'id_nhan_vien_ky_tra' => 'Id Nhan Vien Ky Tra',
            'id_nguoi_gui' => 'Id Nguoi Gui',
            'thoi_gian_gui' => 'Thoi Gian Gui',
            'ghi_chu_nguoi_gui' => 'Ghi Chu Nguoi Gui',
            'id_nguoi_duyet' => 'Id Nguoi Duyet',
            'thoi_gian_duyet' => 'Thoi Gian Duyet',
            'ghi_chu_nguoi_duyet' => 'Ghi Chu Nguoi Duyet',
            'trang_thai' => 'Trang Thai',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
            'buoi'=>'Buoi',
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
