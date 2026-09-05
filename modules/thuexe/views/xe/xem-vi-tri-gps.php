<?php

use yii\bootstrap5\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\thuexe\models\Xe */
/* @var $viTri app\models\PtxXeVitriGps|null */

$hasGps = $viTri !== null && !empty($viTri->latitude) && !empty($viTri->longitude);
$lat = $hasGps ? (float)$viTri->latitude : 9.934682; // Tọa độ mặc định (khu vực Trà Vinh)
$lng = $hasGps ? (float)$viTri->longitude : 106.342656;
$isDangChay = $hasGps ? $viTri->isDangChay() : false;
$markerColor = $hasGps ? $viTri->getMarkerColor() : 'red';
$speed = $hasGps ? (float)$viTri->speed : 0;
$timeAgo = $hasGps ? $viTri->getTimeAgo() : 'Chưa có';
$timeRecord = $hasGps && $viTri->time_record ? date('d/m/Y H:i:s', strtotime($viTri->time_record)) : 'Chưa có';
$accText = $hasGps ? ($viTri->acc == 1 ? '<span class="badge bg-success"><i class="fa fa-bolt"></i> Nổ máy (ACC ON)</span>' : '<span class="badge bg-secondary"><i class="fa fa-power-off"></i> Tắt máy (ACC OFF)</span>') : '';
?>

<!-- Leaflet CSS fallback -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<style>
    #map-container-xe {
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    #map-xe-gps {
        height: 500px;
        width: 100%;
        background-color: #e5e7eb;
    }
    .gps-info-bar {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 12px 16px;
        margin-bottom: 12px;
    }
    .custom-car-pin {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 44px;
        height: 44px;
        border-radius: 50%;
        color: #ffffff;
        font-size: 20px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.35);
        border: 3px solid #ffffff;
        transition: all 0.3s ease;
    }
    .pin-green {
        background: linear-gradient(135deg, #10b981, #047857);
        animation: pulse-green 1.8s infinite;
    }
    .pin-red {
        background: linear-gradient(135deg, #ef4444, #b91c1c);
    }
    @keyframes pulse-green {
        0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
        70% { box-shadow: 0 0 0 12px rgba(16, 185, 129, 0); }
        100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }
</style>

<div class="xem-vi-tri-gps-view">
    <!-- Thanh thông tin xe và GPS -->
    <div class="gps-info-bar">
        <div class="row align-items-center">
            <div class="col-md-5">
                <h5 class="mb-1 text-primary">
                    <i class="fa fa-car"></i> <?= Html::encode($model->bien_so_xe) ?> 
                    <small class="text-muted fs-14">(<?= Html::encode($model->hieu_xe ?? 'Chưa đặt tên') ?>)</small>
                </h5>
                <div class="text-muted fs-13">
                    <span><strong>Mã số:</strong> <?= Html::encode($model->ma_so ?? '-') ?></span> | 
                    <span><strong>Loại:</strong> <?= Html::encode($model->loaiXe->ten_loai_xe ?? '-') ?></span> | 
                    <span><strong>IMEI GPS:</strong> <span class="badge bg-light text-dark border"><?= Html::encode($model->imei_gps ?? 'Chưa cấu hình') ?></span></span>
                </div>
            </div>
            <div class="col-md-7 text-md-end mt-2 mt-md-0">
                <div id="gps-status-badge" class="d-inline-block me-2">
                    <?php if ($hasGps): ?>
                        <?= $viTri->getTrangThaiBadge() ?>
                    <?php else: ?>
                        <span class="badge bg-secondary"><i class="fa fa-question-circle"></i> Chưa có dữ liệu GPS</span>
                    <?php endif; ?>
                </div>
                <div id="gps-acc-badge" class="d-inline-block me-2">
                    <?= $accText ?>
                </div>
                <div class="d-inline-block text-muted fs-13 mt-1">
                    <i class="fa fa-clock"></i> <span id="gps-time-ago"><?= $timeAgo ?></span>
                </div>
            </div>
        </div>

        <hr class="my-2">

        <div class="row fs-13 text-secondary">
            <div class="col-md-3">
                <strong>Vận tốc:</strong> <span id="gps-speed" class="fw-bold text-dark"><?= $speed ?> km/h</span>
            </div>
            <div class="col-md-4">
                <strong>Thời gian ghi nhận:</strong> <span id="gps-time-record" class="text-dark"><?= $timeRecord ?></span>
            </div>
            <div class="col-md-5 text-md-end">
                <strong>Tọa độ:</strong> <span id="gps-coords" class="text-dark"><?= $hasGps ? "{$lat}, {$lng}" : 'Chưa có' ?></span>
            </div>
        </div>
    </div>

    <!-- Container Bản đồ -->
    <div id="map-container-xe">
        <div id="map-xe-gps"></div>
    </div>
</div>

<script>
(function() {
    var hasData = <?= $hasGps ? 'true' : 'false' ?>;
    var currentLat = <?= $lat ?>;
    var currentLng = <?= $lng ?>;
    var isRunning = <?= $isDangChay ? 'true' : 'false' ?>;
    var speedVal = <?= $speed ?>;
    var bienSo = '<?= Html::encode($model->bien_so_xe) ?>';
    var hieuXe = '<?= Html::encode($model->hieu_xe) ?>';
    var xeId = <?= (int)$model->id ?>;
    var refreshUrl = '<?= Url::to(['xem-vi-tri-gps', 'id' => $model->id, 'refresh' => 1]) ?>';

    // Đảm bảo thư viện Leaflet được nạp an toàn
    function ensureLeaflet(callback) {
        if (typeof L !== 'undefined') {
            callback();
            return;
        }
        var script = document.createElement('script');
        script.src = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';
        script.onload = callback;
        document.head.appendChild(script);
    }

    ensureLeaflet(function() {
        initXeMap();
    });

    function createCarIcon(color) {
        var pinClass = (color === 'green') ? 'pin-green' : 'pin-red';
        return L.divIcon({
            className: 'custom-car-marker',
            html: '<div class="custom-car-pin ' + pinClass + '"><i class="fa fa-car"></i></div>',
            iconSize: [44, 44],
            iconAnchor: [22, 22],
            popupAnchor: [0, -22]
        });
    }

    var map = null;
    var marker = null;

    function initXeMap() {
        // Dọn dẹp map cũ trên container nếu có để tránh lỗi "Map container is already initialized"
        var container = L.DomUtil.get('map-xe-gps');
        if (container !== null && container._leaflet_id) {
            container._leaflet_id = null;
        }

        // Khởi tạo bản đồ
        map = L.map('map-xe-gps').setView([currentLat, currentLng], hasData ? 16 : 13);

        // 1. Google Maps Road (Mặc định - Cực nhanh, ổn định 100% tại Việt Nam)
        var googleRoad = L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
            attribution: '&copy; Google Maps'
        });

        // 2. Google Maps Hybrid Vệ tinh
        var googleHybrid = L.tileLayer('https://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
            attribution: '&copy; Google Maps Vệ tinh'
        });

        // 3. OpenStreetMap (Dự phòng)
        var osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap'
        });

        // Mặc định nạp Google Maps
        googleRoad.addTo(map);

        // Nút chuyển đổi loại bản đồ
        var baseMaps = {
            "Google Bản đồ": googleRoad,
            "Google Vệ tinh": googleHybrid,
            "OpenStreetMap": osmLayer
        };
        L.control.layers(baseMaps, null, { position: 'topright' }).addTo(map);

        // Đánh dấu vị trí xe
        if (hasData) {
            var initialColor = isRunning ? 'green' : 'red';
            marker = L.marker([currentLat, currentLng], { icon: createCarIcon(initialColor) }).addTo(map);

            var popupContent = '<div style="min-width: 190px;">' +
                '<h6 class="mb-1 text-primary font-weight-bold"><i class="fa fa-car"></i> ' + bienSo + '</h6>' +
                '<div class="text-muted fs-12 mb-1">' + hieuXe + '</div>' +
                '<div class="fs-13"><strong>Tốc độ:</strong> ' + speedVal + ' km/h</div>' +
                '<div class="fs-13"><strong>Trạng thái:</strong> ' + (isRunning ? '<span class="text-success font-weight-bold">Đang chạy</span>' : '<span class="text-danger">Đã dừng</span>') + '</div>' +
                '</div>';

            marker.bindPopup(popupContent).openPopup();
        }

        // Tự động căn chỉnh kích thước khi modal hiển thị hoàn tất
        function fixMapSize() {
            if (map) {
                map.invalidateSize();
                if (hasData) {
                    map.setView([currentLat, currentLng], 16);
                }
            }
        }

        setTimeout(fixMapSize, 300);
        setTimeout(fixMapSize, 700);

        $('#ajaxCrudModal, #ajaxCrudModal2').one('shown.bs.modal', fixMapSize);
    }

    // Xử lý nút "Cập nhật vị trí" trên footer modal
    $(document).off('click', '.btn-refresh-gps').on('click', '.btn-refresh-gps', function() {
        var $btn = $(this);
        var origHtml = $btn.html();
        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Đang lấy GPS...');

        $.ajax({
            url: refreshUrl,
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                $btn.prop('disabled', false).html(origHtml);
                if (res.success && res.data) {
                    var d = res.data;
                    var newLat = d.lat;
                    var newLng = d.lng;
                    var color = d.marker_color; // 'green' hoặc 'red'

                    // Cập nhật DOM thông tin
                    $('#gps-speed').text(d.speed + ' km/h');
                    $('#gps-time-record').text(d.time_record || 'Vừa xong');
                    $('#gps-coords').text(newLat + ', ' + newLng);
                    $('#gps-status-badge').html(d.badge);
                    $('#gps-time-ago').text(d.time_ago);

                    var accHtml = d.acc == 1 
                        ? '<span class="badge bg-success"><i class="fa fa-bolt"></i> Nổ máy (ACC ON)</span>' 
                        : '<span class="badge bg-secondary"><i class="fa fa-power-off"></i> Tắt máy (ACC OFF)</span>';
                    $('#gps-acc-badge').html(accHtml);

                    // Cập nhật Marker trên bản đồ
                    if (map) {
                        if (!marker) {
                            marker = L.marker([newLat, newLng], { icon: createCarIcon(color) }).addTo(map);
                        } else {
                            marker.setLatLng([newLat, newLng]);
                            marker.setIcon(createCarIcon(color));
                        }

                        var newPopup = '<div style="min-width: 190px;">' +
                            '<h6 class="mb-1 text-primary font-weight-bold"><i class="fa fa-car"></i> ' + bienSo + '</h6>' +
                            '<div class="text-muted fs-12 mb-1">' + hieuXe + '</div>' +
                            '<div class="fs-13"><strong>Tốc độ:</strong> ' + d.speed + ' km/h</div>' +
                            '<div class="fs-13"><strong>Trạng thái:</strong> ' + (d.is_dang_chay ? '<span class="text-success font-weight-bold">Đang chạy</span>' : '<span class="text-danger">Đã dừng</span>') + '</div>' +
                            '</div>';

                        marker.bindPopup(newPopup).openPopup();
                        map.flyTo([newLat, newLng], 17, { duration: 1.2 });
                    }
                    if (typeof showNotif === 'function') {
                        showNotif(res.message || 'Cập nhật vị trí GPS thành công!');
                    }
                } else {
                    if (typeof showError === 'function') {
                        showError(res.message || 'Không thể lấy vị trí xe!');
                    } else {
                        alert(res.message || 'Không thể lấy vị trí xe!');
                    }
                }
            },
            error: function(xhr) {
                $btn.prop('disabled', false).html(origHtml);
                if (typeof showError === 'function') {
                    showError('Lỗi kết nối máy chủ hoặc API MID.');
                } else {
                    alert('Lỗi kết nối máy chủ hoặc API MID.');
                }
            }
        });
    });
})();
</script>
