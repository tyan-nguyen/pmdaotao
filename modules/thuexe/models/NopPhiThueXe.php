<?php

namespace app\modules\thuexe\models;

use Yii;

/**
 * This is the model class for table "ptx_nop_phi_thue_xe".
 *
 * @property int $id
 * @property int|null $id_phieu_thue_xe
 * @property int|null $id_hoc_vien
 * @property string|null $ho_ten_nguoi_thue
 * @property string|null $so_cccd_nguoi_thue
 * @property string|null $dia_chi_nguoi_thue
 * @property string|null $so_dien_thoai_nguoi_thue
 * @property float|null $so_tien_nop
 * @property int|null $nguoi_thu
 * @property string|null $bien_lai
 * @property string|null $ngay_nop
 * @property int|null $nguoi_tao
 * @property int|null $thoi_gian_tao
 */
class NopPhiThueXe extends \app\models\PtxNopPhiThueXe
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ptx_nop_phi_thue_xe';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_phieu_thue_xe', 'id_hoc_vien', 'nguoi_thu', 'nguoi_tao', 'thoi_gian_tao'], 'integer'],
            [['so_tien_nop'], 'number'],
            [['ngay_nop'], 'safe'],
            [['ho_ten_nguoi_thue'], 'string', 'max' => 50],
            [['so_cccd_nguoi_thue'], 'string', 'max' => 15],
            [['dia_chi_nguoi_thue', 'bien_lai'], 'string', 'max' => 255],
            [['so_dien_thoai_nguoi_thue'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_phieu_thue_xe' => 'Id Phieu Thue Xe',
            'id_hoc_vien' => 'Id Hoc Vien',
            'ho_ten_nguoi_thue' => 'Ho Ten Nguoi Thue',
            'so_cccd_nguoi_thue' => 'So Cccd Nguoi Thue',
            'dia_chi_nguoi_thue' => 'Dia Chi Nguoi Thue',
            'so_dien_thoai_nguoi_thue' => 'So Dien Thoai Nguoi Thue',
            'so_tien_nop' => 'So Tien Nop',
            'nguoi_thu' => 'Nguoi Thu',
            'bien_lai' => 'Bien Lai',
            'ngay_nop' => 'Ngay Nop',
            'nguoi_tao' => 'Nguoi Tao',
            'thoi_gian_tao' => 'Thoi Gian Tao',
        ];
    }
}
