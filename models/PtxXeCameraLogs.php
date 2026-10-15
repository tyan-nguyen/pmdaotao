<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ptx_xe_camera_logs".
 *
 * @property int $id
 * @property int|null $camera_log_id
 * @property string $camera
 * @property string $su_kien
 * @property string|null $trang_thai_ke_hoach
 * @property string $ma_xe
 * @property string|null $bien_so_xe
 * @property string $thoi_gian
 * @property string|null $thoi_gian_tao
 * @property int|null $nguoi_tao
 * @property int $is_deleted
 * @property string|null $deleted_at
 * @property string|null $deleted_by
 */
class PtxXeCameraLogs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ptx_xe_camera_logs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['camera', 'su_kien', 'ma_xe', 'thoi_gian'], 'required'],
            [['thoi_gian', 'thoi_gian_tao', 'deleted_at'], 'safe'],
            [['camera_log_id', 'nguoi_tao', 'is_deleted'], 'integer'],
            [['camera'], 'string', 'max' => 50],
            [['su_kien', 'trang_thai_ke_hoach'], 'string', 'max' => 20],
            [['ma_xe', 'bien_so_xe'], 'string', 'max' => 50],
            [['deleted_by'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'camera_log_id' => 'ID Log Camera',
            'camera' => 'Camera',
            'su_kien' => 'Sự Kiện',
            'trang_thai_ke_hoach' => 'Kế Hoạch Lúc Quét',
            'ma_xe' => 'Mã Xe',
            'bien_so_xe' => 'Biển Số Xe',
            'thoi_gian' => 'Thời Gian',
            'thoi_gian_tao' => 'Thời Gian Tạo',
            'nguoi_tao' => 'Người Tạo',
            'is_deleted' => 'Đã Xóa Tạm',
            'deleted_at' => 'Thời Gian Xóa',
            'deleted_by' => 'Người Xóa',
        ];
    }
}
