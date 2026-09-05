<?php

namespace app\models;

use Yii;
use app\custom\CustomFunc;

/**
 * This is the model class for table "ptx_xe_vi_tri_gps".
 *
 * @property int $id
 * @property int $id_xe
 * @property string $imei
 * @property float $latitude
 * @property float $longitude
 * @property float|null $speed
 * @property float|null $rotation
 * @property int|null $acc
 * @property int|null $status
 * @property int|null $status_device
 * @property int|null $signal_quality
 * @property float|null $fuel_lit
 * @property float|null $fuel_percent
 * @property string|null $time_record
 * @property string $thoi_gian_tao
 * @property string|null $du_lieu_json
 *
 * @property PtxXe $xe
 */
class PtxXeVitriGps extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ptx_xe_vi_tri_gps';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_xe', 'imei', 'latitude', 'longitude', 'thoi_gian_tao'], 'required'],
            [['id_xe', 'acc', 'status', 'status_device', 'signal_quality'], 'integer'],
            [['latitude', 'longitude', 'speed', 'rotation', 'fuel_lit', 'fuel_percent'], 'number'],
            [['time_record', 'thoi_gian_tao'], 'safe'],
            [['du_lieu_json'], 'string'],
            [['imei'], 'string', 'max' => 20],
            [['id_xe'], 'exist', 'skipOnError' => true, 'targetClass' => PtxXe::class, 'targetAttribute' => ['id_xe' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_xe' => 'Xe',
            'imei' => 'Mã IMEI',
            'latitude' => 'Vĩ độ (Lat)',
            'longitude' => 'Kinh độ (Lng)',
            'speed' => 'Tốc độ (km/h)',
            'rotation' => 'Góc quay (độ)',
            'acc' => 'Khóa điện (ACC)',
            'status' => 'Trạng thái',
            'status_device' => 'Trạng thái thiết bị',
            'signal_quality' => 'Chất lượng sóng',
            'fuel_lit' => 'Nhiên liệu (lít)',
            'fuel_percent' => '% Nhiên liệu',
            'time_record' => 'Thời gian thiết bị',
            'thoi_gian_tao' => 'Thời gian cập nhật',
            'du_lieu_json' => 'Dữ liệu JSON',
        ];
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

    /**
     * Kiểm tra xem vị trí GPS này có phải là vị trí mới / xe đang chạy hay không.
     * Trả về true (Màu xanh - đang chạy):
     * - Vừa lấy trong vòng 30 phút VÀ (tốc độ > 0 HOẶC khóa điện acc = 1)
     * - Hoặc dữ liệu vừa lấy trong vòng 5 phút gần nhất
     * Trả về false (Màu đỏ - vị trí cũ/dừng đỗ):
     * - Quá 30 phút hoặc tốc độ = 0 và tắt máy lâu
     *
     * @param int $thresholdMinutes Ngưỡng phút coi là vừa lấy (mặc định 30 phút)
     * @return bool
     */
    public function isDangChay($thresholdMinutes = 30)
    {
        $time = !empty($this->time_record) ? strtotime($this->time_record) : strtotime($this->thoi_gian_tao);
        if (!$time) {
            return false;
        }

        $diffSeconds = time() - $time;
        // Nếu vừa lấy trong vòng 5 phút: coi như vừa lấy mới từ GPS
        if ($diffSeconds <= 300) {
            return true;
        }

        // Nếu trong vòng ngưỡng (30 phút) và xe có tín hiệu chạy (speed > 0 hoặc acc = 1)
        if ($diffSeconds <= ($thresholdMinutes * 60)) {
            if ($this->speed > 0 || $this->acc == 1) {
                return true;
            }
        }

        return false;
    }

    /**
     * Lấy màu sắc đánh dấu (marker) trên bản đồ
     * @return string 'green' hoặc 'red'
     */
    public function getMarkerColor()
    {
        return $this->isDangChay() ? 'green' : 'red';
    }

    /**
     * Lấy mô tả trạng thái dạng badge HTML
     * @return string
     */
    public function getTrangThaiBadge()
    {
        if ($this->isDangChay()) {
            $speedText = $this->speed > 0 ? " ({$this->speed} km/h)" : "";
            return '<span class="badge bg-success"><i class="fa fa-circle"></i> Đang chạy' . $speedText . '</span>';
        } else {
            return '<span class="badge bg-danger"><i class="fa fa-circle"></i> Vị trí cũ / Đã dừng</span>';
        }
    }

    /**
     * Lấy chuỗi khoảng thời gian tương đối so với hiện tại
     * @return string
     */
    public function getTimeAgo()
    {
        $time = !empty($this->time_record) ? strtotime($this->time_record) : strtotime($this->thoi_gian_tao);
        if (!$time) {
            return 'Không xác định';
        }

        $diff = time() - $time;
        if ($diff < 60) {
            return 'Vừa xong';
        } elseif ($diff < 3600) {
            return floor($diff / 60) . ' phút trước';
        } elseif ($diff < 86400) {
            return floor($diff / 3600) . ' giờ trước';
        } else {
            return floor($diff / 86400) . ' ngày trước (' . date('d/m/Y H:i', $time) . ')';
        }
    }
}
