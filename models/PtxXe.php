<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ptx_xe".
 *
 * @property int $id
 * @property string|null $ma_so
 * @property int $id_loai_xe
 * @property string|null $phan_loai
 * @property string|null $hieu_xe
 * @property string|null $bien_so_xe
 * @property string|null $ma_bien_so
 * @property string|null $tinh_trang_xe
 * @property string|null $trang_thai
 * @property string|null $ghi_chu
 * @property string|null $so_khung
 * @property string|null $so_may
 * @property string|null $ngay_dang_kiem
 * @property string|null $mau_sac
 * @property string|null $dac_diem
 * @property int|null $la_xe_cu
 * @property float|null $so_tien
 * @property string|null $nha_cung_cap
 * @property string|null $so_hoa_don
 * @property string|null $so_hop_dong
 * @property int|null $id_giao_vien
 * @property int|null $nguoi_tao
 * @property string|null $thoi_gian_tao
 * @property int|null $stt
 *
 * @property GdGvXe[] $gdGvXes
 * @property PtxLoaiXe $loaiXe
 * @property PtxLichThue[] $ptxLichThues
 * @property PtxPhieuThueXe[] $ptxPhieuThueXes
 */
class PtxXe extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ptx_xe';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ma_so', 'phan_loai', 'hieu_xe', 'bien_so_xe', 'ma_bien_so', 'tinh_trang_xe', 'trang_thai', 'ghi_chu', 'so_khung', 'so_may', 'ngay_dang_kiem', 'mau_sac', 'dac_diem', 'la_xe_cu', 'so_tien', 'nha_cung_cap', 'so_hoa_don', 'so_hop_dong', 'id_giao_vien', 'nguoi_tao', 'thoi_gian_tao', 'stt'], 'default', 'value' => null],
            [['id_loai_xe'], 'required'],
            [['id_loai_xe', 'la_xe_cu', 'id_giao_vien', 'nguoi_tao', 'stt'], 'integer'],
            [['tinh_trang_xe', 'ghi_chu', 'dac_diem'], 'string'],
            [['ngay_dang_kiem', 'thoi_gian_tao'], 'safe'],
            [['so_tien'], 'number'],
            [['ma_so', 'phan_loai'], 'string', 'max' => 20],
            [['hieu_xe', 'bien_so_xe', 'ma_bien_so'], 'string', 'max' => 50],
            [['trang_thai'], 'string', 'max' => 25],
            [['so_khung', 'so_may', 'mau_sac', 'nha_cung_cap', 'so_hoa_don', 'so_hop_dong'], 'string', 'max' => 250],
            [['id_loai_xe'], 'exist', 'skipOnError' => true, 'targetClass' => PtxLoaiXe::class, 'targetAttribute' => ['id_loai_xe' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ma_so' => 'Ma So',
            'id_loai_xe' => 'Id Loai Xe',
            'phan_loai' => 'Phan Loai',
            'hieu_xe' => 'Hieu Xe',
            'bien_so_xe' => 'Bien So Xe',
            'ma_bien_so' => 'Ma Bien So',
            'tinh_trang_xe' => 'Tinh Trang Xe',
            'trang_thai' => 'Trang Thai',
            'ghi_chu' => 'Ghi Chu',
            'so_khung' => 'So Khung',
            'so_may' => 'So May',
            'ngay_dang_kiem' => 'Ngay Dang Kiem',
            'mau_sac' => 'Mau Sac',
            'dac_diem' => 'Dac Diem',
            'la_xe_cu' => 'La Xe Cu',
            'so_tien' => 'So Tien',
            'nha_cung_cap' => 'Nha Cung Cap',
            'so_hoa_don' => 'So Hoa Don',
            'so_hop_dong' => 'So Hop Dong',
            'id_giao_vien' => 'Id Giao Vien',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
            'stt' => 'Stt',
        ];
    }

    /**
     * Gets query for [[GdGvXes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGdGvXes()
    {
        return $this->hasMany(GdGvXe::class, ['id_xe' => 'id']);
    }

    /**
     * Gets query for [[LoaiXe]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLoaiXe()
    {
        return $this->hasOne(PtxLoaiXe::class, ['id' => 'id_loai_xe']);
    }

    /**
     * Gets query for [[PtxLichThues]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPtxLichThues()
    {
        return $this->hasMany(PtxLichThue::class, ['id_xe' => 'id']);
    }

    /**
     * Gets query for [[PtxPhieuThueXes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPtxPhieuThueXes()
    {
        return $this->hasMany(PtxPhieuThueXe::class, ['id_xe' => 'id']);
    }

}
