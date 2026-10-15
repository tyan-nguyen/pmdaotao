<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ptx_xe_luot_ra_vao".
 *
 * @property int $id
 * @property string $ma_xe
 * @property string|null $bien_so_xe
 * @property int|null $id_xe
 * @property string $loai_xe
 * @property string $kieu_luot
 * @property int|null $log_di_id
 * @property string|null $camera_di
 * @property string|null $thoi_gian_di
 * @property string|null $trang_thai_ke_hoach
 * @property int|null $log_ve_id
 * @property string|null $camera_ve
 * @property string|null $thoi_gian_ve
 * @property int|null $so_phut_o_ngoai
 * @property int $qua_dem
 * @property string|null $thoi_gian_o_ngoai_label
 * @property string $trang_thai
 * @property string|null $ghi_chu
 * @property int $is_deleted
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class PtxXeLuotRaVao extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ptx_xe_luot_ra_vao';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ma_xe'], 'required'],
            [['id_xe', 'log_di_id', 'log_ve_id', 'so_phut_o_ngoai', 'qua_dem', 'is_deleted'], 'integer'],
            [['thoi_gian_di', 'thoi_gian_ve', 'created_at', 'updated_at'], 'safe'],
            [['ghi_chu'], 'string'],
            [['ma_xe', 'bien_so_xe', 'camera_di', 'camera_ve', 'thoi_gian_o_ngoai_label'], 'string', 'max' => 50],
            [['trang_thai_ke_hoach', 'loai_xe', 'kieu_luot'], 'string', 'max' => 20],
            [['trang_thai'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ma_xe' => 'Mã Xe',
            'bien_so_xe' => 'Biển Số Xe',
            'id_xe' => 'Xe Nội Bộ',
            'loai_xe' => 'Loại Xe',
            'kieu_luot' => 'Kiểu Lượt',
            'log_di_id' => 'ID Log Đi',
            'camera_di' => 'Cổng Đi',
            'thoi_gian_di' => 'Thời Gian Đi',
            'trang_thai_ke_hoach' => 'Kế Hoạch Lúc Đi',
            'log_ve_id' => 'ID Log Về',
            'camera_ve' => 'Cổng Về',
            'thoi_gian_ve' => 'Thời Gian Về',
            'so_phut_o_ngoai' => 'Số Phút Ở Ngoài',
            'qua_dem' => 'Xe Qua Đêm',
            'thoi_gian_o_ngoai_label' => 'Thời Gian Ở Ngoài',
            'trang_thai' => 'Trạng Thái',
            'ghi_chu' => 'Ghi Chú',
            'is_deleted' => 'Đã Xóa Tạm',
            'created_at' => 'Thời Gian Tạo',
            'updated_at' => 'Thời Gian Cập Nhật',
        ];
    }
}
