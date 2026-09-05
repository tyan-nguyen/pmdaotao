<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "ptx_xe_vung_gioi_han".
 *
 * @property int $id
 * @property string $ten_vung
 * @property string $loai_vung
 * @property string $toa_do_polygon
 * @property string|null $mau_sac
 * @property int|null $trang_thai
 * @property string|null $ghi_chu
 * @property string $thoi_gian_tao
 * @property string|null $thoi_gian_cap_nhat
 */
class PtxXeVungGioiHan extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ptx_xe_vung_gioi_han';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten_vung', 'toa_do_polygon'], 'required', 'message' => '{attribute} không được để trống.'],
            [['toa_do_polygon', 'ghi_chu'], 'string'],
            [['trang_thai'], 'integer'],
            [['thoi_gian_tao', 'thoi_gian_cap_nhat'], 'safe'],
            [['ten_vung'], 'string', 'max' => 255],
            [['loai_vung'], 'string', 'max' => 50],
            [['mau_sac'], 'string', 'max' => 20],
            [['loai_vung'], 'default', 'value' => 'KHUON_VIEN'],
            [['mau_sac'], 'default', 'value' => '#2563eb'],
            [['trang_thai'], 'default', 'value' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ten_vung' => 'Tên vùng giới hạn',
            'loai_vung' => 'Loại vùng',
            'toa_do_polygon' => 'Tọa độ đa giác',
            'mau_sac' => 'Màu sắc hiển thị',
            'trang_thai' => 'Trạng thái',
            'ghi_chu' => 'Ghi chú',
            'thoi_gian_tao' => 'Thời gian tạo',
            'thoi_gian_cap_nhat' => 'Thời gian cập nhật',
        ];
    }

    /**
     * Lấy mảng tọa độ đỉnh [[lat, lng], [lat, lng], ...]
     * @return array
     */
    public function getCoordinates()
    {
        if (empty($this->toa_do_polygon)) {
            return [];
        }
        $data = json_decode($this->toa_do_polygon, true);
        return is_array($data) ? $data : [];
    }

    /**
     * Gán mảng tọa độ dạng mảng PHP vào JSON
     * @param array $coords
     */
    public function setCoordinates($coords)
    {
        $this->toa_do_polygon = json_encode($coords, JSON_UNESCAPED_UNICODE);
    }

    /**
     * Lấy danh sách tất cả các vùng đang kích hoạt
     * @return PtxXeVungGioiHan[]
     */
    public static function getDanhSachVungDangApDung()
    {
        return self::find()
            ->where(['trang_thai' => 1])
            ->orderBy(['id' => SORT_ASC])
            ->all();
    }

    /**
     * Thuật toán Ray-Casting (bắn tia) kiểm tra điểm tọa độ ($lat, $lng) có nằm trong đa giác không.
     *
     * @param float|string $lat Vĩ độ
     * @param float|string $lng Kinh độ
     * @return bool
     */
    public function isPointInside($lat, $lng)
    {
        $coords = $this->getCoordinates();
        $n = count($coords);
        if ($n < 3) {
            return false;
        }

        $lat = (float)$lat;
        $lng = (float)$lng;
        $inside = false;

        for ($i = 0, $j = $n - 1; $i < $n; $j = $i++) {
            $xi = (float)$coords[$i][0];
            $yi = (float)$coords[$i][1];
            $xj = (float)$coords[$j][0];
            $yj = (float)$coords[$j][1];

            $intersect = (($yi > $lng) != ($yj > $lng)) &&
                ($lat < ($xj - $xi) * ($lng - $yi) / ($yj - $yi) + $xi);

            if ($intersect) {
                $inside = !$inside;
            }
        }

        return $inside;
    }

    /**
     * Phân loại danh sách xe theo các vùng đang áp dụng và thống kê số lượng.
     * Lưu ý: Xe tắt máy vẫn được tính chính xác dựa trên tọa độ lần lưu gần nhất.
     *
     * @param \app\modules\thuexe\models\Xe[] $vehicles Danh sách xe
     * @param PtxXeVungGioiHan[]|null $activeZones Danh sách vùng (mặc định lấy tất cả vùng đang áp dụng)
     * @return array [
     *    'vehicleData' => [...],
     *    'vungList' => [...],
     *    'stats' => [
     *        'total_xe_gps' => int,
     *        'count_ngoai_duong' => int,
     *        'count_chua_co_gps' => int,
     *        'vung_stats' => [ id => ['id' => ..., 'ten_vung' => ..., 'count' => ..., 'mau_sac' => ...], ... ]
     *    ]
     * ]
     */
    public static function phanLoaiVaThongKeXe($vehicles, $activeZones = null)
    {
        if ($activeZones === null) {
            $activeZones = self::getDanhSachVungDangApDung();
        }

        $vungStats = [];
        $vungList = [];
        foreach ($activeZones as $zone) {
            $vungStats[$zone->id] = [
                'id' => $zone->id,
                'ten_vung' => $zone->ten_vung,
                'loai_vung' => $zone->loai_vung,
                'mau_sac' => $zone->mau_sac ?: '#2563eb',
                'count' => 0,
            ];
            $vungList[] = [
                'id' => $zone->id,
                'ten_vung' => $zone->ten_vung,
                'loai_vung' => $zone->loai_vung,
                'mau_sac' => $zone->mau_sac ?: '#2563eb',
                'coords' => $zone->getCoordinates(),
            ];
        }

        $countNgoaiDuong = 0;
        $countChuaCoGps = 0;
        $vehicleData = [];

        foreach ($vehicles as $xe) {
            $vt = $xe->viTriGpsMoiNhat;
            $hasCoords = ($vt && $vt->latitude && $vt->longitude);

            $idVung = null;
            $tenVung = 'Chưa có tọa độ GPS';
            $mauVung = '#6b7280';
            $isNgoaiDuong = false;

            if ($hasCoords) {
                $lat = (float)$vt->latitude;
                $lng = (float)$vt->longitude;
                $foundZone = false;

                // Kiểm tra lần lượt qua từng vùng giới hạn
                foreach ($activeZones as $zone) {
                    if ($zone->isPointInside($lat, $lng)) {
                        $idVung = $zone->id;
                        $tenVung = $zone->ten_vung;
                        $mauVung = $zone->mau_sac ?: '#2563eb';
                        $vungStats[$zone->id]['count']++;
                        $foundZone = true;
                        break;
                    }
                }

                if (!$foundZone) {
                    $idVung = 'ngoai_duong';
                    $tenVung = 'Ngoài đường';
                    $mauVung = '#f59e0b';
                    $isNgoaiDuong = true;
                    $countNgoaiDuong++;
                }
            } else {
                $countChuaCoGps++;
            }

            if ($hasCoords) {
                $vehicleData[] = [
                    'id' => $xe->id,
                    'bien_so_xe' => $xe->bien_so_xe,
                    'hieu_xe' => $xe->hieu_xe,
                    'ma_so' => $xe->ma_so,
                    'imei' => $xe->imei_gps,
                    'lat' => (float)$vt->latitude,
                    'lng' => (float)$vt->longitude,
                    'speed' => $vt->speed,
                    'rotation' => $vt->rotation,
                    'acc' => $vt->acc,
                    'is_dang_chay' => $vt->isDangChay(),
                    'marker_color' => $vt->getMarkerColor(),
                    'badge' => $vt->getTrangThaiBadge(),
                    'time_ago' => $vt->getTimeAgo(),
                    'time_record' => $vt->time_record ? date('d/m/Y H:i:s', strtotime($vt->time_record)) : '',
                    // Thông tin vùng
                    'id_vung' => $idVung,
                    'ten_vung' => $tenVung,
                    'mau_vung' => $mauVung,
                    'is_ngoai_duong' => $isNgoaiDuong,
                ];
            }
        }

        return [
            'vehicleData' => $vehicleData,
            'vungList' => $vungList,
            'stats' => [
                'total_xe_gps' => count($vehicles),
                'count_co_toa_do' => count($vehicleData),
                'count_ngoai_duong' => $countNgoaiDuong,
                'count_chua_co_gps' => $countChuaCoGps,
                'vung_stats' => array_values($vungStats),
            ],
        ];
    }
}
