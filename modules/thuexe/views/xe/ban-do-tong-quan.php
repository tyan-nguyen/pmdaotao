<?php

use yii\bootstrap5\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $vehicleData array */
/* @var $vungList array */
/* @var $stats array */

$vehiclesJson = json_encode($vehicleData, JSON_UNESCAPED_UNICODE);
$vungListJson = json_encode($vungList, JSON_UNESCAPED_UNICODE);
$statsJson = json_encode($stats, JSON_UNESCAPED_UNICODE);
?>

<!-- Leaflet CSS fallback -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<style>
    #map-all-vehicles {
        height: 560px;
        width: 100%;
        border-radius: 8px;
        background-color: #e5e7eb;
    }
    #map-all-vehicles.drawing-mode {
        cursor: crosshair !important;
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
        box-shadow: 0 3px 8px rgba(0,0,0,0.35);
        border: 2px solid #ffffff;
        cursor: pointer;
        transition: transform 0.2s ease;
    }
    .custom-car-pin-all:hover {
        transform: scale(1.15);
    }
    .pin-green-all {
        background: linear-gradient(135deg, #10b981, #047857);
    }
    .pin-red-all {
        background: linear-gradient(135deg, #ef4444, #b91c1c);
    }
    .map-stats-bar {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 8px 14px;
        margin-bottom: 10px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }
    .stat-filter-btn {
        background: #ffffff !important;
        border: 1px solid #cbd5e1 !important;
        color: #334155 !important;
        padding: 5px 12px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.15s ease-in-out;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        text-decoration: none;
    }
    .stat-filter-btn:hover {
        border-color: #94a3b8 !important;
        background: #f8fafc !important;
        color: #0f172a !important;
    }
    .stat-filter-btn.active {
        border-color: #2563eb !important;
        background: #ffffff !important;
        color: #1d4ed8 !important;
        box-shadow: 0 1px 3px rgba(37, 99, 235, 0.2) !important;
        font-weight: 600 !important;
    }
    .zone-editor-panel {
        background: #f8fafc;
        border: 1px dashed #3b82f6;
        border-radius: 8px;
        padding: 12px 16px;
        margin-bottom: 10px;
        display: none;
    }
    .zone-vertex-pin {
        width: 14px;
        height: 14px;
        background: #ffffff;
        border: 3px solid #2563eb;
        border-radius: 50%;
        box-shadow: 0 1px 4px rgba(0,0,0,0.45);
        cursor: move;
    }
    .drawing-point-pin {
        width: 22px;
        height: 22px;
        border-radius: 50%;
        color: #ffffff;
        font-size: 11px;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 5px rgba(0,0,0,0.4);
        border: 2px solid #ffffff;
        cursor: pointer;
    }
</style>

<div class="ban-do-tong-quan-view">
    <!-- Thanh thống kê và lọc nhanh -->
    <div class="map-stats-bar">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
            <!-- Nút lọc các vùng và ngoài đường: Nền trắng đồng nhất, chỉ style background cho badge số lượng -->
            <div class="d-flex flex-wrap align-items-center gap-2" id="filter-chips-container">
                <button type="button" class="btn stat-filter-btn active" data-filter="all" title="Xem tất cả xe">
                    <i class="fa fa-list text-secondary"></i> Tất cả
                    <span id="stat-total" class="badge bg-dark ms-1"><?= $stats['total_xe_gps'] ?? 0 ?> xe</span>
                </button>

                <?php if (!empty($stats['vung_stats'])): ?>
                    <?php foreach ($stats['vung_stats'] as $vs): ?>
                        <button type="button" class="btn stat-filter-btn" 
                                data-filter="vung-<?= $vs['id'] ?>"
                                title="Click để zoom đến <?= Html::encode($vs['ten_vung']) ?>">
                            <i class="fa fa-map-marker-alt" style="color: <?= Html::encode($vs['mau_sac']) ?>;"></i> <?= Html::encode($vs['ten_vung']) ?>
                            <span class="badge ms-1" style="background-color: <?= Html::encode($vs['mau_sac']) ?>; color: #ffffff;">
                                <?= (int)$vs['count'] ?> xe
                            </span>
                        </button>
                    <?php endforeach; ?>
                <?php endif; ?>

                <button type="button" class="btn stat-filter-btn" data-filter="ngoai-duong" title="Click để xem các xe ngoài đường">
                    <i class="fa fa-road text-warning"></i> Ngoài đường
                    <span id="stat-ngoai-duong" class="badge ms-1" style="background-color: #f59e0b; color: #ffffff;"><?= $stats['count_ngoai_duong'] ?? 0 ?> xe</span>
                </button>

                <?php if (!empty($stats['count_chua_co_gps'])): ?>
                    <button type="button" class="btn stat-filter-btn" data-filter="chua-co-gps" title="Xe chưa có tín hiệu GPS">
                        <i class="fa fa-satellite-dish text-muted"></i> Chưa có GPS
                        <span id="stat-chua-gps" class="badge bg-secondary ms-1"><?= $stats['count_chua_co_gps'] ?> xe</span>
                    </button>
                <?php endif; ?>
            </div>

            <!-- Công cụ quản lý vùng giới hạn -->
            <div class="d-flex align-items-center gap-2">
                <button type="button" class="btn btn-outline-primary btn-sm" id="btn-toggle-zone-editor">
                    <i class="fa fa-draw-polygon"></i> <span id="btn-editor-text">Quản lý vùng giới hạn</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Panel chỉnh sửa / vẽ vùng đa giác -->
    <div class="zone-editor-panel" id="zone-editor-panel">
        <!-- Chế độ chọn và chỉnh sửa bình thường -->
        <div id="normal-editor-controls">
            <div class="row g-2 align-items-center">
                <div class="col-md-3">
                    <label class="form-label mb-1 fw-bold fs-12">Chọn vùng quản lý:</label>
                    <select class="form-select form-select-sm" id="select-zone-edit">
                        <!-- Điền bằng JS -->
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label mb-1 fw-bold fs-12">Tên vùng:</label>
                    <input type="text" class="form-control form-control-sm" id="input-zone-name" placeholder="Ví dụ: Khuôn viên công ty">
                </div>
                <div class="col-md-2">
                    <label class="form-label mb-1 fw-bold fs-12">Màu sắc viền/nền:</label>
                    <div class="d-flex align-items-center gap-2">
                        <input type="color" class="form-control form-control-color form-control-sm p-0" id="input-zone-color" value="#2563eb" title="Chọn màu sắc vùng">
                        <span id="zone-color-code" class="fs-12 text-muted fw-bold">#2563eb</span>
                    </div>
                </div>
                <div class="col-md-4 text-end pt-3">
                    <button type="button" class="btn btn-outline-primary btn-sm me-1" id="btn-start-redraw" title="Xóa các điểm và click trên bản đồ để vẽ lại đa giác mới">
                        <i class="fa fa-pencil-alt"></i> Vẽ lại
                    </button>
                    <button type="button" class="btn btn-success btn-sm me-1" id="btn-save-zone">
                        <i class="fa fa-check"></i> Lưu vùng
                    </button>
                    <button type="button" class="btn btn-outline-danger btn-sm me-1" id="btn-delete-zone" style="display:none;" title="Xóa vùng giới hạn này">
                        <i class="fa fa-trash"></i> Xóa
                    </button>
                    <button type="button" class="btn btn-outline-secondary btn-sm" id="btn-close-zone-panel">
                        Đóng
                    </button>
                </div>
            </div>
            <div class="mt-2 text-primary fs-12">
                <i class="fa fa-info-circle"></i> <strong>Hướng dẫn:</strong> Kéo các chốt tròn màu trên bản đồ để nắn khớp khuôn viên. Hoặc bấm <strong>Vẽ lại</strong> để click các điểm mới từ đầu.
            </div>
        </div>

        <!-- Chế độ đang vẽ trên bản đồ (Drawing Mode) -->
        <div id="drawing-mode-controls" style="display:none;">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-primary fs-13 py-2 px-3">
                        <i class="fa fa-crosshairs"></i> Đang vẽ: <strong id="draw-points-count">0</strong> điểm (cần $\ge 3$ điểm)
                    </span>
                    <span class="fs-12 text-muted">
                        Click liên tiếp trên bản đồ để đặt các đỉnh. Click lại điểm số 1 hoặc bấm <strong>Hoàn tất vẽ</strong> khi xong.
                    </span>
                </div>
                <div class="d-flex align-items-center gap-1">
                    <button type="button" class="btn btn-success btn-sm" id="btn-finish-drawing" disabled>
                        <i class="fa fa-check"></i> Hoàn tất vẽ
                    </button>
                    <button type="button" class="btn btn-outline-warning btn-sm" id="btn-undo-drawing-point" disabled>
                        <i class="fa fa-undo"></i> Xóa điểm vừa vẽ
                    </button>
                    <button type="button" class="btn btn-outline-secondary btn-sm" id="btn-cancel-drawing">
                        Hủy vẽ
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Khung bản đồ -->
    <div style="border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; position: relative;">
        <div id="map-all-vehicles"></div>
    </div>
</div>

<script>
(function() {
    var vehicles = <?= $vehiclesJson ?>;
    var vungList = <?= $vungListJson ?>;
    var currentStats = <?= $statsJson ?>;

    var map = null;
    var markersMap = {};      // xeId -> L.marker
    var polygonLayers = {};   // vungId -> L.polygon
    
    // State machine cho quản lý và vẽ vùng
    var isEditingZone = false;
    var isDrawingMode = false;
    var editingZoneId = null;
    
    var tempCoords = [];
    var editVertexMarkers = [];
    var tempPolygon = null;

    // Các layer cho chế độ vẽ mới (Drawing Mode)
    var drawingMarkers = [];
    var drawingPolyline = null;
    var drawingPolygonPreview = null;

    var saveZoneUrl = '<?= Url::to(['luu-vung-gioi-han']) ?>';
    var deleteZoneUrl = '<?= Url::to(['xoa-vung-gioi-han']) ?>';

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

    function createVertexIcon(color) {
        return L.divIcon({
            className: 'zone-vertex-marker',
            html: '<div class="zone-vertex-pin" style="border-color:' + (color || '#2563eb') + '"></div>',
            iconSize: [14, 14],
            iconAnchor: [7, 7]
        });
    }

    function createDrawingPointIcon(num, color) {
        return L.divIcon({
            className: 'drawing-point-marker',
            html: '<div class="drawing-point-pin" style="background:' + (color || '#2563eb') + ';">' + num + '</div>',
            iconSize: [22, 22],
            iconAnchor: [11, 11]
        });
    }

    function initAllVehiclesMap() {
        var container = L.DomUtil.get('map-all-vehicles');
        if (container !== null && container._leaflet_id) {
            container._leaflet_id = null;
        }

        // Tọa độ mặc định trung tâm Trà Vinh / Nguyễn Trình
        map = L.map('map-all-vehicles').setView([9.807887, 106.345648], 15);

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

        // Vẽ các vùng và các xe (Không hiển thị text đè lên bản đồ)
        renderAllPolygons();
        renderAllVehicles();
        populateZoneSelectDropdown();

        // Xử lý sự kiện click bản đồ khi ở chế độ vẽ mới (Drawing Mode)
        map.on('click', function(e) {
            if (isDrawingMode) {
                var lat = parseFloat(e.latlng.lat.toFixed(6));
                var lng = parseFloat(e.latlng.lng.toFixed(6));
                addDrawingPoint(lat, lng);
            }
        });

        function fixMapSize() {
            if (map) {
                map.invalidateSize();
                fitAllBounds();
            }
        }

        setTimeout(fixMapSize, 300);
        setTimeout(fixMapSize, 700);
        $('#ajaxCrudModal, #ajaxCrudModal2').one('shown.bs.modal', fixMapSize);
    }

    /**
     * Vẽ tất cả các đa giác vùng giới hạn lên bản đồ (Sạch sẽ, không chữ đè lên)
     */
    function renderAllPolygons() {
        // Xóa các polygon cũ
        for (var id in polygonLayers) {
            if (polygonLayers[id] && map.hasLayer(polygonLayers[id])) {
                map.removeLayer(polygonLayers[id]);
            }
        }
        polygonLayers = {};

        vungList.forEach(function(vung) {
            if (vung.coords && vung.coords.length >= 3) {
                var color = vung.mau_sac || '#2563eb';
                var poly = L.polygon(vung.coords, {
                    color: color,
                    fillColor: color,
                    fillOpacity: 0.16,
                    weight: 2,
                    dashArray: '6, 6'
                }).addTo(map);

                // Tooltip khi hover (không hiển thị chữ cố định đè lên bản đồ)
                poly.bindTooltip(vung.ten_vung, {
                    sticky: true,
                    direction: 'top',
                    className: 'fs-12'
                });

                polygonLayers[vung.id] = poly;
            }
        });
    }

    /**
     * Vẽ các marker xe lên bản đồ
     */
    function renderAllVehicles() {
        for (var xid in markersMap) {
            if (markersMap[xid] && map.hasLayer(markersMap[xid])) {
                map.removeLayer(markersMap[xid]);
            }
        }
        markersMap = {};

        vehicles.forEach(function(xe) {
            if (xe.lat && xe.lng) {
                var icon = createCarIcon(xe.marker_color);
                var marker = L.marker([xe.lat, xe.lng], { icon: icon }).addTo(map);

                var vungBadge = '';
                if (xe.id_vung && xe.id_vung !== 'ngoai_duong') {
                    vungBadge = '<span class="badge" style="background-color:' + (xe.mau_vung || '#2563eb') + '; color:#fff;"><i class="fa fa-building"></i> ' + xe.ten_vung + '</span>';
                } else {
                    vungBadge = '<span class="badge bg-warning text-dark"><i class="fa fa-road"></i> Ngoài đường</span>';
                }

                var accStatus = (xe.acc == 1) 
                    ? '<span class="text-success"><i class="fa fa-bolt"></i> Nổ máy</span>' 
                    : '<span class="text-secondary"><i class="fa fa-power-off"></i> Tắt máy</span>';

                var popupContent = '<div style="min-width: 200px;">' +
                    '<div class="d-flex justify-content-between align-items-center mb-1">' +
                    '<h6 class="mb-0 text-primary font-weight-bold"><i class="fa fa-car"></i> ' + xe.bien_so_xe + '</h6>' +
                    '<div>' + vungBadge + '</div>' +
                    '</div>' +
                    '<div class="text-muted fs-12 mb-1">' + (xe.hieu_xe || '') + ' (Mã: ' + (xe.ma_so || '-') + ')</div>' +
                    '<div class="fs-13"><strong>Tốc độ:</strong> ' + xe.speed + ' km/h &nbsp;|&nbsp; ' + accStatus + '</div>' +
                    '<div class="fs-13"><strong>Trạng thái:</strong> ' + (xe.is_dang_chay ? '<span class="text-success font-weight-bold">Đang chạy</span>' : '<span class="text-danger">Đã dừng</span>') + '</div>' +
                    '<div class="fs-12 text-muted mt-1 border-top pt-1">' + (xe.acc == 0 ? 'Vị trí lưu lần cuối: ' : 'Thời gian: ') + (xe.time_record || xe.time_ago) + '</div>' +
                    '</div>';

                marker.bindPopup(popupContent);
                marker._xeData = xe;
                markersMap[xe.id] = marker;
            }
        });
    }

    /**
     * Canh chỉnh phạm vi bản đồ bao quát toàn bộ
     */
    function fitAllBounds() {
        var bounds = [];
        vehicles.forEach(function(xe) {
            if (xe.lat && xe.lng) bounds.push([xe.lat, xe.lng]);
        });
        vungList.forEach(function(vung) {
            if (vung.coords) {
                vung.coords.forEach(function(pt) { bounds.push(pt); });
            }
        });
        if (bounds.length > 0) {
            map.fitBounds(bounds, { padding: [50, 50] });
        }
    }

    /**
     * Điền danh sách vùng vào dropdown chọn sửa
     */
    function populateZoneSelectDropdown() {
        var $select = $('#select-zone-edit');
        $select.empty();
        vungList.forEach(function(vung) {
            $select.append('<option value="' + vung.id + '">' + vung.ten_vung + '</option>');
        });
        $select.append('<option value="new">+ Thêm vùng mới...</option>');
    }

    // -------------------------------------------------------------
    // XỬ LÝ LỌC NHANH & TỰ ĐỘNG ZOOM ĐẾN VÙNG ĐƯỢC CHỌN
    // -------------------------------------------------------------
    $(document).on('click', '.stat-filter-btn', function() {
        $('.stat-filter-btn').removeClass('active');
        $(this).addClass('active');

        var filter = $(this).data('filter');
        var bounds = [];

        for (var xid in markersMap) {
            var m = markersMap[xid];
            var d = m._xeData;
            var visible = false;

            if (filter === 'all') {
                visible = true;
            } else if (filter === 'ngoai-duong') {
                visible = (d.is_ngoai_duong === true || d.id_vung === 'ngoai_duong');
            } else if (filter === 'chua-co-gps') {
                visible = false;
            } else if (filter.indexOf('vung-') === 0) {
                var vId = filter.replace('vung-', '');
                visible = (d.id_vung == vId);
            }

            if (visible) {
                if (!map.hasLayer(m)) map.addLayer(m);
                bounds.push([d.lat, d.lng]);
            } else {
                if (map.hasLayer(m)) map.removeLayer(m);
            }
        }

        // Tự động zoom đến vùng hoặc các xe đang lọc
        if (filter.indexOf('vung-') === 0) {
            var targetVungId = filter.replace('vung-', '');
            if (polygonLayers[targetVungId]) {
                var zoneBounds = polygonLayers[targetVungId].getBounds();
                // Gộp cả tọa độ xe trong vùng nếu có
                bounds.forEach(function(pt) { zoneBounds.extend(pt); });
                map.fitBounds(zoneBounds, { padding: [60, 60], maxZoom: 18 });
            } else if (bounds.length > 0) {
                map.fitBounds(bounds, { padding: [60, 60], maxZoom: 18 });
            }
        } else if (filter === 'all') {
            fitAllBounds();
        } else if (bounds.length > 0) {
            map.fitBounds(bounds, { padding: [50, 50], maxZoom: 17 });
        }
    });

    // -------------------------------------------------------------
    // CHẾ ĐỘ QUẢN LÝ VÀ CHỈNH SỬA / VẼ VÙNG
    // -------------------------------------------------------------
    $('#btn-toggle-zone-editor').on('click', function() {
        if (!isEditingZone) {
            openZoneEditor();
        } else {
            closeZoneEditor();
        }
    });

    $('#btn-close-zone-panel').on('click', function() {
        closeZoneEditor();
    });

    $('#select-zone-edit').on('change', function() {
        loadZoneForEditing($(this).val());
    });

    $('#input-zone-color').on('input change', function() {
        var c = $(this).val();
        $('#zone-color-code').text(c);
        if (tempPolygon) {
            tempPolygon.setStyle({ color: c, fillColor: c });
        }
        if (drawingPolygonPreview) {
            drawingPolygonPreview.setStyle({ color: c, fillColor: c });
        }
        if (drawingPolyline) {
            drawingPolyline.setStyle({ color: c });
        }
        editVertexMarkers.forEach(function(vm) {
            var pin = vm.getElement();
            if (pin) {
                var innerPin = pin.querySelector('.zone-vertex-pin');
                if (innerPin) innerPin.style.borderColor = c;
            }
        });
    });

    function openZoneEditor() {
        isEditingZone = true;
        $('#zone-editor-panel').slideDown(200);
        $('#btn-toggle-zone-editor').removeClass('btn-outline-primary').addClass('btn-primary');
        $('#btn-editor-text').text('Đang quản lý vùng');

        var currentVal = $('#select-zone-edit').val();
        if (!currentVal && vungList.length > 0) {
            currentVal = vungList[0].id;
            $('#select-zone-edit').val(currentVal);
        }
        loadZoneForEditing(currentVal || 'new');
    }

    function closeZoneEditor() {
        if (isDrawingMode) {
            cancelDrawingMode();
        }
        isEditingZone = false;
        $('#zone-editor-panel').slideUp(200);
        $('#btn-toggle-zone-editor').removeClass('btn-primary').addClass('btn-outline-primary');
        $('#btn-editor-text').text('Quản lý vùng giới hạn');

        clearDraggableVertices();
        if (tempPolygon && map.hasLayer(tempPolygon)) {
            map.removeLayer(tempPolygon);
            tempPolygon = null;
        }
        renderAllPolygons();
    }

    function clearDraggableVertices() {
        editVertexMarkers.forEach(function(m) {
            if (map.hasLayer(m)) map.removeLayer(m);
        });
        editVertexMarkers = [];
    }

    function loadZoneForEditing(val) {
        if (isDrawingMode) {
            cancelDrawingMode();
        }
        clearDraggableVertices();
        if (tempPolygon && map.hasLayer(tempPolygon)) {
            map.removeLayer(tempPolygon);
            tempPolygon = null;
        }

        if (val === 'new') {
            editingZoneId = null;
            $('#input-zone-name').val('Vùng mới');
            $('#input-zone-color').val('#10b981');
            $('#zone-color-code').text('#10b981');
            $('#btn-delete-zone').hide();

            // Mặc định tạo 4 điểm quanh trung tâm bản đồ
            var c = map.getCenter();
            var dLat = 0.0015, dLng = 0.0020;
            tempCoords = [
                [parseFloat((c.lat + dLat).toFixed(6)), parseFloat((c.lng - dLng).toFixed(6))],
                [parseFloat((c.lat + dLat).toFixed(6)), parseFloat((c.lng + dLng).toFixed(6))],
                [parseFloat((c.lat - dLat).toFixed(6)), parseFloat((c.lng + dLng).toFixed(6))],
                [parseFloat((c.lat - dLat).toFixed(6)), parseFloat((c.lng - dLng).toFixed(6))]
            ];
        } else {
            editingZoneId = val;
            var curZone = null;
            vungList.forEach(function(v) {
                if (v.id == val) curZone = v;
            });

            if (curZone) {
                $('#input-zone-name').val(curZone.ten_vung);
                $('#input-zone-color').val(curZone.mau_sac || '#2563eb');
                $('#zone-color-code').text(curZone.mau_sac || '#2563eb');
                tempCoords = JSON.parse(JSON.stringify(curZone.coords || []));
                $('#btn-delete-zone').show();
            }
        }

        // Tạm ẩn polygon gốc của vùng này
        if (editingZoneId && polygonLayers[editingZoneId] && map.hasLayer(polygonLayers[editingZoneId])) {
            map.removeLayer(polygonLayers[editingZoneId]);
        }

        createEditablePolygon();
        if (tempPolygon) {
            map.fitBounds(tempPolygon.getBounds(), { padding: [60, 60] });
        }
    }

    function createEditablePolygon() {
        clearDraggableVertices();
        if (tempPolygon && map.hasLayer(tempPolygon)) {
            map.removeLayer(tempPolygon);
            tempPolygon = null;
        }

        if (tempCoords.length < 3) return;

        var color = $('#input-zone-color').val() || '#2563eb';
        tempPolygon = L.polygon(tempCoords, {
            color: color,
            fillColor: color,
            fillOpacity: 0.25,
            weight: 3,
            dashArray: '4, 6'
        }).addTo(map);

        // Tạo các đỉnh có thể kéo thả
        tempCoords.forEach(function(pt, idx) {
            var vm = L.marker(pt, {
                icon: createVertexIcon(color),
                draggable: true
            }).addTo(map);

            vm.on('drag', function(e) {
                var nPos = e.target.getLatLng();
                tempCoords[idx] = [parseFloat(nPos.lat.toFixed(6)), parseFloat(nPos.lng.toFixed(6))];
                tempPolygon.setLatLngs(tempCoords);
            });

            editVertexMarkers.push(vm);
        });
    }

    // -------------------------------------------------------------
    // CHẾ ĐỘ CLICK VẼ MỚI TRÊN BẢN ĐỒ (DRAWING MODE)
    // -------------------------------------------------------------
    $('#btn-start-redraw').on('click', function() {
        startDrawingMode();
    });

    $('#btn-cancel-drawing').on('click', function() {
        cancelDrawingMode();
    });

    $('#btn-finish-drawing').on('click', function() {
        finishDrawingMode();
    });

    $('#btn-undo-drawing-point').on('click', function() {
        undoLastDrawingPoint();
    });

    function startDrawingMode() {
        isDrawingMode = true;
        clearDraggableVertices();
        if (tempPolygon && map.hasLayer(tempPolygon)) {
            map.removeLayer(tempPolygon);
            tempPolygon = null;
        }
        clearDrawingLayers();
        tempCoords = [];

        $('#normal-editor-controls').hide();
        $('#drawing-mode-controls').show();
        $('#map-all-vehicles').addClass('drawing-mode');
        updateDrawingStateUI();
    }

    function cancelDrawingMode() {
        isDrawingMode = false;
        clearDrawingLayers();
        $('#drawing-mode-controls').hide();
        $('#normal-editor-controls').show();
        $('#map-all-vehicles').removeClass('drawing-mode');

        // Phục hồi lại vùng cũ
        var currentVal = $('#select-zone-edit').val();
        loadZoneForEditing(currentVal || 'new');
    }

    function finishDrawingMode() {
        if (tempCoords.length < 3) {
            alert('Cần có ít nhất 3 điểm để tạo thành một đa giác khép kín.');
            return;
        }
        isDrawingMode = false;
        clearDrawingLayers();
        $('#drawing-mode-controls').hide();
        $('#normal-editor-controls').show();
        $('#map-all-vehicles').removeClass('drawing-mode');

        // Tạo polygon hoàn chỉnh có chốt kéo thả
        createEditablePolygon();
    }

    function addDrawingPoint(lat, lng) {
        var color = $('#input-zone-color').val() || '#2563eb';
        var ptIndex = tempCoords.length + 1;
        tempCoords.push([lat, lng]);

        // Tạo marker điểm đánh số thứ tự
        var m = L.marker([lat, lng], {
            icon: createDrawingPointIcon(ptIndex, color)
        }).addTo(map);

        // Nếu click lại điểm số 1 khi đã có >= 3 điểm -> Hoàn tất vẽ
        if (ptIndex === 1) {
            m.on('click', function() {
                if (isDrawingMode && tempCoords.length >= 3) {
                    finishDrawingMode();
                }
            });
        }

        drawingMarkers.push(m);
        refreshDrawingPreviews();
        updateDrawingStateUI();
    }

    function undoLastDrawingPoint() {
        if (tempCoords.length === 0) return;
        tempCoords.pop();
        var lastM = drawingMarkers.pop();
        if (lastM && map.hasLayer(lastM)) {
            map.removeLayer(lastM);
        }
        refreshDrawingPreviews();
        updateDrawingStateUI();
    }

    function refreshDrawingPreviews() {
        var color = $('#input-zone-color').val() || '#2563eb';

        // Cập nhật đường thẳng nối giữa các điểm
        if (tempCoords.length >= 2) {
            if (!drawingPolyline) {
                drawingPolyline = L.polyline(tempCoords, {
                    color: color,
                    weight: 2,
                    dashArray: '4, 4'
                }).addTo(map);
            } else {
                drawingPolyline.setLatLngs(tempCoords);
            }
        } else {
            if (drawingPolyline && map.hasLayer(drawingPolyline)) {
                map.removeLayer(drawingPolyline);
                drawingPolyline = null;
            }
        }

        // Cập nhật đa giác mờ khi đã có >= 3 điểm
        if (tempCoords.length >= 3) {
            if (!drawingPolygonPreview) {
                drawingPolygonPreview = L.polygon(tempCoords, {
                    color: color,
                    fillColor: color,
                    fillOpacity: 0.2,
                    weight: 2,
                    dashArray: '4, 4'
                }).addTo(map);
            } else {
                drawingPolygonPreview.setLatLngs(tempCoords);
            }
        } else {
            if (drawingPolygonPreview && map.hasLayer(drawingPolygonPreview)) {
                map.removeLayer(drawingPolygonPreview);
                drawingPolygonPreview = null;
            }
        }
    }

    function clearDrawingLayers() {
        drawingMarkers.forEach(function(m) {
            if (map.hasLayer(m)) map.removeLayer(m);
        });
        drawingMarkers = [];

        if (drawingPolyline && map.hasLayer(drawingPolyline)) {
            map.removeLayer(drawingPolyline);
            drawingPolyline = null;
        }
        if (drawingPolygonPreview && map.hasLayer(drawingPolygonPreview)) {
            map.removeLayer(drawingPolygonPreview);
            drawingPolygonPreview = null;
        }
    }

    function updateDrawingStateUI() {
        var count = tempCoords.length;
        $('#draw-points-count').text(count);
        $('#btn-finish-drawing').prop('disabled', count < 3);
        $('#btn-undo-drawing-point').prop('disabled', count === 0);
    }

    // -------------------------------------------------------------
    // LƯU VÀ XÓA VÙNG QUA AJAX
    // -------------------------------------------------------------
    $('#btn-save-zone').on('click', function() {
        var name = $('#input-zone-name').val().trim();
        var color = $('#input-zone-color').val();

        if (!name) {
            alert('Vui lòng nhập tên vùng giới hạn.');
            return;
        }

        if (tempCoords.length < 3) {
            alert('Vùng đa giác phải có ít nhất 3 điểm tọa độ để tạo thành vùng khép kín.');
            return;
        }

        var $btn = $(this);
        var origHtml = $btn.html();
        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Đang lưu...');

        $.ajax({
            url: saveZoneUrl,
            type: 'POST',
            dataType: 'json',
            data: {
                id: editingZoneId,
                ten_vung: name,
                mau_sac: color,
                loai_vung: 'KHUON_VIEN',
                coords: tempCoords
            },
            success: function(res) {
                $btn.prop('disabled', false).html(origHtml);
                if (res.status === 'success') {
                    if (typeof showNotif === 'function') {
                        showNotif(res.message);
                    } else {
                        alert(res.message);
                    }

                    vehicles = res.vehicleData || vehicles;
                    vungList = res.vungList || vungList;
                    currentStats = res.stats || currentStats;

                    updateFilterChipsUI();
                    closeZoneEditor();
                    renderAllPolygons();
                    renderAllVehicles();
                    populateZoneSelectDropdown();
                } else {
                    if (typeof showError === 'function') {
                        showError(res.message || 'Không thể lưu vùng.');
                    } else {
                        alert(res.message || 'Không thể lưu vùng.');
                    }
                }
            },
            error: function(xhr) {
                $btn.prop('disabled', false).html(origHtml);
                if (typeof showError === 'function') {
                    showError('Lỗi kết nối máy chủ khi lưu vùng giới hạn.');
                } else {
                    alert('Lỗi kết nối máy chủ khi lưu vùng giới hạn.');
                }
            }
        });
    });

    $('#btn-delete-zone').on('click', function() {
        if (!editingZoneId) return;
        var name = $('#input-zone-name').val();
        if (!confirm('Bạn có chắc chắn muốn xóa vùng giới hạn "' + name + '" không?')) {
            return;
        }

        var $btn = $(this);
        var origHtml = $btn.html();
        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');

        $.ajax({
            url: deleteZoneUrl,
            type: 'POST',
            dataType: 'json',
            data: { id: editingZoneId },
            success: function(res) {
                $btn.prop('disabled', false).html(origHtml);
                if (res.status === 'success') {
                    if (typeof showNotif === 'function') {
                        showNotif(res.message);
                    } else {
                        alert(res.message);
                    }

                    vehicles = res.vehicleData || vehicles;
                    vungList = res.vungList || vungList;
                    currentStats = res.stats || currentStats;

                    updateFilterChipsUI();
                    closeZoneEditor();
                    renderAllPolygons();
                    renderAllVehicles();
                    populateZoneSelectDropdown();
                } else {
                    if (typeof showError === 'function') {
                        showError(res.message || 'Không thể xóa vùng.');
                    } else {
                        alert(res.message || 'Không thể xóa vùng.');
                    }
                }
            },
            error: function(xhr) {
                $btn.prop('disabled', false).html(origHtml);
                if (typeof showError === 'function') {
                    showError('Lỗi kết nối máy chủ khi xóa vùng giới hạn.');
                } else {
                    alert('Lỗi kết nối máy chủ khi xóa vùng giới hạn.');
                }
            }
        });
    });

    /**
     * Cập nhật HTML thanh filter chips khi số liệu thay đổi:
     * Đồng bộ phong cách nút không màu nền, chỉ tô màu nền cho badge số lượng.
     */
    function updateFilterChipsUI() {
        var $con = $('#filter-chips-container');
        $con.empty();

        $con.append(
            '<button type="button" class="btn stat-filter-btn active" data-filter="all" title="Xem tất cả xe">' +
            '<i class="fa fa-list text-secondary"></i> Tất cả ' +
            '<span class="badge bg-dark ms-1">' + (currentStats.total_xe_gps || 0) + ' xe</span>' +
            '</button>'
        );

        if (currentStats && currentStats.vung_stats) {
            currentStats.vung_stats.forEach(function(vs) {
                $con.append(
                    '<button type="button" class="btn stat-filter-btn" data-filter="vung-' + vs.id + '" title="Click để zoom đến ' + vs.ten_vung + '">' +
                    '<i class="fa fa-map-marker-alt" style="color:' + vs.mau_sac + ';"></i> ' + vs.ten_vung + ' ' +
                    '<span class="badge ms-1" style="background-color:' + vs.mau_sac + '; color:#fff;">' + vs.count + ' xe</span>' +
                    '</button>'
                );
            });
        }

        $con.append(
            '<button type="button" class="btn stat-filter-btn" data-filter="ngoai-duong" title="Click để xem các xe ngoài đường">' +
            '<i class="fa fa-road text-warning"></i> Ngoài đường ' +
            '<span class="badge ms-1" style="background-color:#f59e0b; color:#fff;">' + (currentStats.count_ngoai_duong || 0) + ' xe</span>' +
            '</button>'
        );

        if (currentStats.count_chua_co_gps > 0) {
            $con.append(
                '<button type="button" class="btn stat-filter-btn" data-filter="chua-co-gps" title="Xe chưa có tín hiệu GPS">' +
                '<i class="fa fa-satellite-dish text-muted"></i> Chưa có GPS ' +
                '<span class="badge bg-secondary ms-1">' + currentStats.count_chua_co_gps + ' xe</span>' +
                '</button>'
            );
        }
    }
})();
</script>
