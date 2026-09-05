<?php

use yii\bootstrap5\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $vehicleData array */

$vehiclesJson = json_encode($vehicleData, JSON_UNESCAPED_UNICODE);
$count = count($vehicleData);
?>

<!-- Leaflet CSS fallback -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<style>
    #map-all-vehicles {
        height: 550px;
        width: 100%;
        border-radius: 8px;
        background-color: #e5e7eb;
    }
    .custom-car-pin-all {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        color: #ffffff;
        font-size: 16px;
        box-shadow: 0 3px 8px rgba(0,0,0,0.3);
        border: 2px solid #ffffff;
        cursor: pointer;
    }
    .pin-green-all {
        background: linear-gradient(135deg, #10b981, #047857);
    }
    .pin-red-all {
        background: linear-gradient(135deg, #ef4444, #b91c1c);
    }
    .map-stats-bar {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 8px 16px;
        margin-bottom: 12px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
</style>

<div class="ban-do-tong-quan-view">
    <div class="map-stats-bar">
        <div>
            <strong>Tổng số xe có tọa độ GPS:</strong> <span class="badge bg-primary fs-13"><?= $count ?> xe</span>
        </div>
        <div>
            <span class="badge bg-success me-2"><i class="fa fa-circle"></i> Xanh: Đang chạy / Vừa lấy</span>
            <span class="badge bg-danger"><i class="fa fa-circle"></i> Đỏ: Vị trí cũ / Đã dừng</span>
        </div>
    </div>

    <div style="border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden;">
        <div id="map-all-vehicles"></div>
    </div>
</div>

<script>
(function() {
    var vehicles = <?= $vehiclesJson ?>;

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
        initAllVehiclesMap();
    });

    function createCarIcon(color) {
        var pinClass = (color === 'green') ? 'pin-green-all' : 'pin-red-all';
        return L.divIcon({
            className: 'custom-car-marker-all',
            html: '<div class="custom-car-pin-all ' + pinClass + '"><i class="fa fa-car"></i></div>',
            iconSize: [36, 36],
            iconAnchor: [18, 18],
            popupAnchor: [0, -18]
        });
    }

    function initAllVehiclesMap() {
        var container = L.DomUtil.get('map-all-vehicles');
        if (container !== null && container._leaflet_id) {
            container._leaflet_id = null;
        }

        var map = L.map('map-all-vehicles').setView([9.934682, 106.342656], 12);

        // 1. Google Maps Road (Mặc định)
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

        // 3. OpenStreetMap
        var osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap'
        });

        googleRoad.addTo(map);

        var baseMaps = {
            "Google Bản đồ": googleRoad,
            "Google Vệ tinh": googleHybrid,
            "OpenStreetMap": osmLayer
        };
        L.control.layers(baseMaps, null, { position: 'topright' }).addTo(map);

        var bounds = [];

        vehicles.forEach(function(xe) {
            if (xe.lat && xe.lng) {
                var icon = createCarIcon(xe.marker_color);
                var marker = L.marker([xe.lat, xe.lng], { icon: icon }).addTo(map);

                var popupContent = '<div style="min-width: 190px;">' +
                    '<h6 class="mb-1 text-primary font-weight-bold"><i class="fa fa-car"></i> ' + xe.bien_so_xe + '</h6>' +
                    '<div class="text-muted fs-12 mb-1">' + (xe.hieu_xe || '') + ' (Mã: ' + (xe.ma_so || '-') + ')</div>' +
                    '<div class="fs-13"><strong>Tốc độ:</strong> ' + xe.speed + ' km/h</div>' +
                    '<div class="fs-13"><strong>IMEI:</strong> ' + xe.imei + '</div>' +
                    '<div class="fs-13"><strong>Trạng thái:</strong> ' + (xe.is_dang_chay ? '<span class="text-success font-weight-bold">Đang chạy</span>' : '<span class="text-danger">Đã dừng</span>') + '</div>' +
                    '<div class="fs-12 text-muted mt-1">' + xe.time_ago + '</div>' +
                    '</div>';

                marker.bindPopup(popupContent);
                bounds.push([xe.lat, xe.lng]);
            }
        });

        if (bounds.length > 0) {
            map.fitBounds(bounds, { padding: [50, 50] });
        }

        function fixMapSize() {
            if (map) {
                map.invalidateSize();
                if (bounds.length > 0) {
                    map.fitBounds(bounds, { padding: [50, 50] });
                }
            }
        }

        setTimeout(fixMapSize, 300);
        setTimeout(fixMapSize, 700);

        $('#ajaxCrudModal, #ajaxCrudModal2').one('shown.bs.modal', fixMapSize);
    }
})();
</script>
