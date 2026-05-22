<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cp_phieu_de_nghi".
 *
 * @property int $id
 * @property int|null $so_phieu
 * @property int|null $so_vao_so
 * @property int|null $nam
 * @property string|null $loai_phieu
 * @property string|null $loai_tai_san
 * @property int $id_tham_chieu
 * @property int|null $nguoi_de_nghi
 * @property string|null $loai_yeu_cau
 * @property int|null $so_km_luc_yeu_cau
 * @property string $noi_dung_de_nghi
 * @property string|null $ngay_bat_dau
 * @property string|null $ngay_hoan_thanh
 * @property string|null $trang_thai
 * @property string|null $thoi_gian_gui_duyet
 * @property int|null $nguoi_duyet
 * @property string|null $ngay_duyet
 * @property string|null $ghi_chu_duyet
 * @property int|null $phieu_co_chi_tiet
 * @property float|null $tong_tien_du_kien
 * @property float|null $tong_tien_thuc_te
 * @property int|null $id_dot_tong_hop
 * @property int|null $da_thanh_toan
 * @property string|null $ngay_thanh_toan
 * @property string|null $hinh_thuc_thanh_toan
 * @property int|null $nguoi_thanh_toan
 * @property string|null $loai_thanh_toan thanh toan le hay theo dot
 * @property int|null $so_lan_in
 * @property int|null $edit_mode
 * @property string|null $thoi_gian_tao
 * @property int|null $nguoi_tao
 *
 * @property CpPhieuChiTiet[] $cpPhieuChiTiets
 * @property CpDotTongHop $dotTongHop
 */
class CpPhieuDeNghi extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cp_phieu_de_nghi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['so_phieu', 'so_vao_so', 'nam', 'loai_phieu', 'loai_tai_san', 'nguoi_de_nghi', 'loai_yeu_cau', 'so_km_luc_yeu_cau', 'ngay_bat_dau', 'ngay_hoan_thanh', 'thoi_gian_gui_duyet', 'nguoi_duyet', 'ngay_duyet', 'ghi_chu_duyet', 'phieu_co_chi_tiet', 'id_dot_tong_hop', 'ngay_thanh_toan', 'hinh_thuc_thanh_toan', 'nguoi_thanh_toan', 'loai_thanh_toan', 'so_lan_in', 'edit_mode', 'nguoi_tao'], 'default', 'value' => null],
            [['trang_thai'], 'default', 'value' => 'NHAP'],
            [['tong_tien_thuc_te'], 'default', 'value' => 0.00],
            [['da_thanh_toan'], 'default', 'value' => 0],
            [['so_phieu', 'so_vao_so', 'nam', 'id_tham_chieu', 'nguoi_de_nghi', 'so_km_luc_yeu_cau', 'nguoi_duyet', 'phieu_co_chi_tiet', 'id_dot_tong_hop', 'da_thanh_toan', 'nguoi_thanh_toan', 'so_lan_in', 'edit_mode', 'nguoi_tao'], 'integer'],
            [['id_tham_chieu', 'noi_dung_de_nghi'], 'required'],
            [['noi_dung_de_nghi', 'ghi_chu_duyet'], 'string'],
            [['ngay_bat_dau', 'ngay_hoan_thanh', 'thoi_gian_gui_duyet', 'ngay_duyet', 'ngay_thanh_toan', 'thoi_gian_tao'], 'safe'],
            [['tong_tien_du_kien', 'tong_tien_thuc_te'], 'number'],
            [['loai_phieu', 'loai_tai_san', 'loai_yeu_cau', 'trang_thai', 'hinh_thuc_thanh_toan', 'loai_thanh_toan'], 'string', 'max' => 20],
            [['id_dot_tong_hop'], 'exist', 'skipOnError' => true, 'targetClass' => CpDotTongHop::class, 'targetAttribute' => ['id_dot_tong_hop' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'so_phieu' => 'So Phieu',
            'so_vao_so' => 'So Vao So',
            'nam' => 'Nam',
            'loai_phieu' => 'Loai Phieu',
            'loai_tai_san' => 'Loai Tai San',
            'id_tham_chieu' => 'Id Tham Chieu',
            'nguoi_de_nghi' => 'Nguoi De Nghi',
            'loai_yeu_cau' => 'Loai Yeu Cau',
            'so_km_luc_yeu_cau' => 'So Km Luc Yeu Cau',
            'noi_dung_de_nghi' => 'Noi Dung De Nghi',
            'ngay_bat_dau' => 'Ngay Bat Dau',
            'ngay_hoan_thanh' => 'Ngay Hoan Thanh',
            'trang_thai' => 'Trang Thai',
            'thoi_gian_gui_duyet' => 'Thoi Gian Gui Duyet',
            'nguoi_duyet' => 'Nguoi Duyet',
            'ngay_duyet' => 'Ngay Duyet',
            'ghi_chu_duyet' => 'Ghi Chu Duyet',
            'phieu_co_chi_tiet' => 'Phieu Co Chi Tiet',
            'tong_tien_du_kien' => 'Tong Tien Du Kien',
            'tong_tien_thuc_te' => 'Tong Tien Thuc Te',
            'id_dot_tong_hop' => 'Id Dot Tong Hop',
            'da_thanh_toan' => 'Da Thanh Toan',
            'ngay_thanh_toan' => 'Ngay Thanh Toan',
            'hinh_thuc_thanh_toan' => 'Hinh Thuc Thanh Toan',
            'nguoi_thanh_toan' => 'Nguoi Thanh Toan',
            'loai_thanh_toan' => 'Loai Thanh Toan',
            'so_lan_in' => 'So Lan In',
            'edit_mode' => 'Edit Mode',
            'thoi_gian_tao' => 'Thoi Gian Tao',
            'nguoi_tao' => 'Nguoi Tao',
        ];
    }

    /**
     * Gets query for [[CpPhieuChiTiets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCpPhieuChiTiets()
    {
        return $this->hasMany(CpPhieuChiTiet::class, ['id_phieu_de_nghi' => 'id']);
    }

    /**
     * Gets query for [[DotTongHop]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDotTongHop()
    {
        return $this->hasOne(CpDotTongHop::class, ['id' => 'id_dot_tong_hop']);
    }

}
