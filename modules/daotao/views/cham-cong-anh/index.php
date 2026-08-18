<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\modules\daotao\models\HinhAnh;

$this->title = 'Chụp ảnh chấm công / giảng dạy';
$this->params['breadcrumbs'][] = ['label' => 'Đào tạo', 'url' => ['/daotao']];
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    .camera-container {
        max-width: 600px;
        margin: 0 auto;
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        border: 1px solid #e9ecef;
    }

    .camera-header {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        color: #fff;
        padding: 18px 24px;
        text-align: center;
    }

    .camera-header h4 {
        margin: 0;
        font-weight: 700;
        font-size: 1.25rem;
        letter-spacing: 0.5px;
    }

    .camera-body {
        padding: 20px;
    }

    .viewport-wrapper {
        position: relative;
        width: 100%;
        min-height: 300px;
        background: #090a0f;
        border-radius: 12px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: inset 0 0 20px rgba(0, 0, 0, 0.6);
    }

    #camera-stream,
    #captured-img {
        width: 100%;
        max-height: 70vh;
        object-fit: contain;
    }

    .camera-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        pointer-events: none;
        border: 2px dashed rgba(255, 255, 255, 0.4);
        margin: 15px;
        border-radius: 8px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 10px;
    }

    .camera-overlay::before {
        content: "Đưa đối tượng vào khung hình";
        color: rgba(255, 255, 255, 0.7);
        font-size: 12px;
        text-align: center;
        background: rgba(0, 0, 0, 0.4);
        padding: 4px 8px;
        border-radius: 4px;
        align-self: center;
    }

    .camera-flash {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: white;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.15s ease-out;
        z-index: 10;
    }

    .camera-flash.active {
        opacity: 0.9;
    }

    .controls-wrapper {
        margin-top: 20px;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .btn-camera-capture {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background: #e63946;
        border: 5px solid #ffffff;
        box-shadow: 0 4px 15px rgba(230, 57, 70, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 26px;
        cursor: pointer;
        transition: all 0.2s ease;
        margin: 0 auto;
    }

    .btn-camera-capture:active {
        transform: scale(0.92);
        background: #d62828;
    }

    .action-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
    }

    .btn-switch-cam {
        background: #f1f5f9;
        border: 1px solid #cbd5e1;
        color: #334155;
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
    }

    .btn-switch-cam:hover {
        background: #e2e8f0;
    }

    .status-badge {
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        color: #ffffff !important;
    }

    .status-badge.bg-primary {
        background-color: #0284c7 !important;
        color: #ffffff !important;
    }

    .status-badge.bg-success {
        background-color: #16a34a !important;
        color: #ffffff !important;
    }

    .status-badge.bg-info-light {
        background-color: #0284c7 !important;
        color: #ffffff !important;
    }

    .status-badge.bg-warning {
        background-color: #d97706 !important;
        color: #ffffff !important;
    }

    .status-badge.bg-danger {
        background-color: #dc2626 !important;
        color: #ffffff !important;
    }

    .upload-success-card {
        display: none;
        margin-top: 15px;
        padding: 15px;
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 10px;
        color: #166534;
    }
</style>

<div class="container-fluid py-3">
    <div class="camera-container">
        <div class="camera-header">
            <h4><i class="fa fa-camera me-2"></i>ẢNH LƯU KẾ HOẠCH GIẢNG DẠY</h4>
        </div>

        <div class="camera-body">
            <!-- Form thông tin phụ (được ẩn hiển thị trên UI nhưng vẫn giữ các element cho JS submit form) -->
            <div class="row g-3 mb-3 d-none">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Loại hình ảnh</label>
                    <?= Html::dropDownList('loai', $loai, $loaiList, [
                        'id' => 'select-loai',
                        'class' => 'form-select form-select-md fw-semibold border-primary',
                    ]) ?>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Lượt (Đi/Về)</label>
                    <?= Html::dropDownList('luot', $luot, $luotList, [
                        'id' => 'select-luot',
                        'class' => 'form-select form-select-md fw-semibold border-primary',
                    ]) ?>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Giáo viên thực hiện</label>
                    <input type="text" class="form-control form-control-md bg-light" readonly value="<?= $idGiaoVien ? 'Mã GV: ' . $idGiaoVien : 'Tài khoản chưa gán Giáo viên' ?>">
                    <input type="hidden" id="input-id-giao-vien" value="<?= Html::encode($idGiaoVien) ?>">
                </div>
            </div>

            <!-- Khung hình Camera Stream / Preview -->
            <div class="viewport-wrapper">
                <video id="camera-stream" autoplay playsinline muted></video>
                <img id="captured-img" style="display: none;" alt="Ảnh xem trước">
                <div class="camera-overlay" id="camera-overlay"></div>
                <div class="camera-flash" id="camera-flash"></div>
            </div>

            <!-- Nút điều khiển -->
            <div class="controls-wrapper">
                <div class="action-bar">
                    <button type="button" class="btn-switch-cam" id="btn-toggle-camera">
                        <i class="fa fa-refresh me-1"></i> Đổi Camera
                    </button>
                    <span class="status-badge bg-info-light" id="camera-status">Sẵn sàng</span>
                    <label class="btn btn-outline-secondary btn-sm rounded-pill mb-0 d-none" for="file-fallback-input">
                        <i class="fa fa-folder-open me-1"></i> Chọn tệp ảnh
                    </label>
                    <input type="file" id="file-fallback-input" accept="image/*" capture="environment" style="display: none;">
                </div>

                <!-- Capture & Confirm controls -->
                <div class="text-center mt-2" id="capture-controls">
                    <button type="button" class="btn-camera-capture" id="btn-capture" title="Chụp ảnh">
                        <i class="fa fa-camera"></i>
                    </button>
                    <div class="text-muted small mt-1">Chạm để chụp ảnh</div>
                </div>

                <div class="text-center mt-2" id="confirm-controls" style="display: none;">
                    <div class="d-flex justify-content-center gap-3">
                        <button type="button" class="btn btn-secondary btn-md rounded-pill px-4" id="btn-retake">
                            <i class="fa fa-undo me-1"></i> Chụp lại
                        </button>
                        <button type="button" class="btn btn-success btn-md rounded-pill px-4 fw-bold" id="btn-upload">
                            <i class="fa fa-cloud-upload me-1"></i> Lưu & Tải lên
                        </button>
                    </div>
                </div>
            </div>

            <!-- Thẻ thông báo kết quả upload -->
            <div class="upload-success-card mt-3" id="upload-result">
                <div class="d-flex align-items-center">
                    <i class="fa fa-check-circle fs-3 me-3 text-success"></i>
                    <div>
                        <div class="fw-bold" id="result-title">Tải lên thành công!</div>
                        <div class="small" id="result-detail">Ảnh đã được lưu vào hệ thống.</div>
                    </div>
                </div>
                <div class="mt-2 text-end">
                    <a href="#" id="result-link" target="_blank" class="btn btn-sm btn-outline-success">Xem hình ảnh</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Canvas ẩn dùng để xử lý cắt khung ảnh từ video -->
<canvas id="photo-canvas" style="display: none;"></canvas>

<?php

use app\modules\user\models\User;

$uploadUrl = Url::to(['upload']);
$homeUrl = Url::home();
$csrfToken = Yii::$app->request->csrfToken;

$userModel = !Yii::$app->user->isGuest ? User::findOne(Yii::$app->user->id) : null;
$tenUser = ($userModel && !empty($userModel->ho_ten)) ? $userModel->ho_ten : (!Yii::$app->user->isGuest ? Yii::$app->user->identity->username : '');

$this->registerJs(
    'const UPLOAD_URL = ' . json_encode($uploadUrl) . ';'
        . ' const HOME_URL = ' . json_encode($homeUrl) . ';'
        . ' const CSRF_TOKEN = ' . json_encode($csrfToken) . ';'
        . ' const TEN_USER = ' . json_encode($tenUser) . ';',
    \yii\web\View::POS_HEAD
);

$script = <<<'JS'
(function() {
    const video = document.getElementById('camera-stream');
    const capturedImg = document.getElementById('captured-img');
    const canvas = document.getElementById('photo-canvas');
    const btnCapture = document.getElementById('btn-capture');
    const btnRetake = document.getElementById('btn-retake');
    const btnUpload = document.getElementById('btn-upload');
    const btnToggleCam = document.getElementById('btn-toggle-camera');
    const captureControls = document.getElementById('capture-controls');
    const confirmControls = document.getElementById('confirm-controls');
    const cameraOverlay = document.getElementById('camera-overlay');
    const cameraFlash = document.getElementById('camera-flash');
    const cameraStatus = document.getElementById('camera-status');
    const fileFallbackInput = document.getElementById('file-fallback-input');
    const uploadResult = document.getElementById('upload-result');
    const resultLink = document.getElementById('result-link');
    const resultDetail = document.getElementById('result-detail');

    let currentStream = null;
    let facingMode = 'environment'; // Mặc định camera sau cho máy điện thoại
    let capturedBase64Data = null;
    let currentGeoLocation = 'Đang xác định vị trí GPS...';

    // Tự động nhận diện Tên thiết bị / Hệ điều hành chụp ảnh
    function getDeviceName() {
        const ua = navigator.userAgent;
        if (/android/i.test(ua)) {
            const match = ua.match(/Android\s+[\d\.]+;\s*([^;\)]+)/i);
            return 'Android' + (match && match[1] ? ' (' + match[1].trim() + ')' : '');
        }
        if (/iPhone/i.test(ua)) return 'iPhone (iOS)';
        if (/iPad/i.test(ua)) return 'iPad (iOS)';
        if (/Windows/i.test(ua)) return 'Máy tính Windows';
        if (/Macintosh|Mac OS/i.test(ua)) return 'Máy tính Mac OS';
        if (/Linux/i.test(ua)) return 'Thiết bị Linux';
        return 'Thiết bị di động';
    }

    // Khởi tạo Geolocation API lấy tọa độ GPS của thiết bị
    function initGeoLocation() {
        if ('geolocation' in navigator) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const lat = position.coords.latitude.toFixed(6);
                    const lng = position.coords.longitude.toFixed(6);
                    currentGeoLocation = `${lat}, ${lng}`;
                },
                function(err) {
                    console.warn('Không lấy được GPS:', err.message);
                    currentGeoLocation = 'Không khả dụng (Tắt GPS)';
                },
                { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
            );
        } else {
            currentGeoLocation = 'Thiết bị không hỗ trợ GPS';
        }
    }

    // Lấy ngày giờ hiện tại dạng d/m/Y H:i:s
    function getCurrentDateTimeString() {
        const now = new Date();
        const d = String(now.getDate()).padStart(2, '0');
        const m = String(now.getMonth() + 1).padStart(2, '0');
        const y = now.getFullYear();
        const h = String(now.getHours()).padStart(2, '0');
        const i = String(now.getMinutes()).padStart(2, '0');
        const s = String(now.getSeconds()).padStart(2, '0');
        return `${d}/${m}/${y} ${h}:${i}:${s}`;
    }

    // Vẽ Watermark tem với 3 Label (Ngày giờ, Tọa độ, Tên user) lên Canvas 2D
    function drawWatermarkOnCanvas(ctx, width, height) {
        const dateTimeStr = 'Ngày giờ: ' + getCurrentDateTimeString();
        const locationStr = 'Tọa độ: ' + currentGeoLocation;
        const userStr = 'Tên user: ' + (TEN_USER || 'Chưa xác định');

        // Tính kích thước chữ và dải nền tỉ lệ theo độ phân giải ảnh
        const fontSize = Math.max(14, Math.floor(height / 36));
        const padding = Math.max(12, Math.floor(height / 45));
        // Lùi từ mép trái vào ít nhất 30px hoặc 5% chiều rộng của hình ảnh
        const startX = Math.max(30, Math.floor(width * 0.05));
        const lineHeight = fontSize + 8;
        const totalLines = 3;
        const barHeight = lineHeight * totalLines + padding * 2;

        // Vẽ dải nền đen mờ ở góc dưới ảnh
        ctx.fillStyle = 'rgba(0, 0, 0, 0.75)';
        ctx.fillRect(0, height - barHeight, width, barHeight);

        // Định dạng kiểu chữ, căn lề trái chuẩn xác & bóng chữ sắc nét
        ctx.font = 'bold ' + fontSize + 'px Arial, "Helvetica Neue", sans-serif';
        ctx.textAlign = 'left';
        ctx.textBaseline = 'alphabetic';
        ctx.fillStyle = '#ffffff';
        ctx.shadowColor = 'rgba(0, 0, 0, 0.9)';
        ctx.shadowBlur = 4;
        ctx.shadowOffsetX = 1;
        ctx.shadowOffsetY = 1;

        let startY = height - barHeight + padding + fontSize;

        // In 3 dòng nhãn thông tin lùi vào từ mép trái startX
        ctx.fillText(dateTimeStr, startX, startY);
        ctx.fillText(locationStr, startX, startY + lineHeight);
        ctx.fillText(userStr, startX, startY + lineHeight * 2);
    }

    // Khởi tạo Stream Camera từ HTML5 MediaDevices
    async function startCamera() {
        initGeoLocation();

        if (currentStream) {
            currentStream.getTracks().forEach(track => track.stop());
        }

        cameraStatus.textContent = 'Đang mở Camera...';
        cameraStatus.className = 'status-badge bg-info-light';

        try {
            const constraints = {
                video: {
                    facingMode: facingMode,
                    width: { ideal: 1920 },
                    height: { ideal: 1080 }
                },
                audio: false
            };

            currentStream = await navigator.mediaDevices.getUserMedia(constraints);
            video.srcObject = currentStream;
            video.style.display = 'block';
            capturedImg.style.display = 'none';
            cameraOverlay.style.display = 'flex';
            captureControls.style.display = 'block';
            confirmControls.style.display = 'none';
            
            cameraStatus.textContent = 'Camera Sẵn Sàng';
            cameraStatus.className = 'status-badge bg-success text-white';
        } catch (err) {
            console.warn('Không thể khởi tạo camera tự động:', err);
            cameraStatus.textContent = 'Chọn hình ảnh từ tệp';
            cameraStatus.className = 'status-badge bg-warning text-dark';
            cameraOverlay.style.display = 'none';
        }
    }

    // Toggle chuyển đổi Camera Trước / Sau
    btnToggleCam.addEventListener('click', function() {
        facingMode = (facingMode === 'environment') ? 'user' : 'environment';
        startCamera();
    });

    // Chụp ảnh từ Video Stream
    btnCapture.addEventListener('click', function() {
        if (!video.videoWidth || !video.videoHeight) {
            alert('Camera chưa sẵn sàng, vui lòng chờ trong giây lát hoặc chọn ảnh từ tệp.');
            return;
        }

        // Tạo hiệu ứng chớp sáng camera (flash)
        cameraFlash.classList.add('active');
        setTimeout(() => cameraFlash.classList.remove('active'), 150);

        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        const ctx = canvas.getContext('2d');
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

        // Vẽ Tem Watermark Ngày giờ + GPS
        drawWatermarkOnCanvas(ctx, canvas.width, canvas.height);

        capturedBase64Data = canvas.toDataURL('image/jpeg', 0.9);
        capturedImg.src = capturedBase64Data;

        // Chuyển chế độ hiển thị Xem trước
        video.style.display = 'none';
        capturedImg.style.display = 'block';
        cameraOverlay.style.display = 'none';
        captureControls.style.display = 'none';
        confirmControls.style.display = 'block';

        cameraStatus.textContent = 'Đã Chụp - Chờ Lưu';
        cameraStatus.className = 'status-badge bg-primary text-white';
    });

    // Chụp lại
    btnRetake.addEventListener('click', function() {
        capturedBase64Data = null;
        uploadResult.style.display = 'none';
        video.style.display = 'block';
        capturedImg.style.display = 'none';
        cameraOverlay.style.display = 'flex';
        captureControls.style.display = 'block';
        confirmControls.style.display = 'none';

        cameraStatus.textContent = 'Camera Sẵn Sàng';
        cameraStatus.className = 'status-badge bg-success text-white';
    });

    // Xử lý chọn tệp thay thế (file fallback)
    fileFallbackInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const img = new Image();
                img.onload = function() {
                    canvas.width = img.width;
                    canvas.height = img.height;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

                    // Vẽ Tem Watermark Ngày giờ + GPS
                    drawWatermarkOnCanvas(ctx, canvas.width, canvas.height);

                    capturedBase64Data = canvas.toDataURL('image/jpeg', 0.9);
                    capturedImg.src = capturedBase64Data;

                    video.style.display = 'none';
                    capturedImg.style.display = 'block';
                    cameraOverlay.style.display = 'none';
                    captureControls.style.display = 'none';
                    confirmControls.style.display = 'block';

                    cameraStatus.textContent = 'Đã chọn tệp';
                    cameraStatus.className = 'status-badge bg-primary text-white';
                };
                img.src = event.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    // Upload dữ liệu ảnh lên Server
    btnUpload.addEventListener('click', function() {
        if (!capturedBase64Data) {
            alert('Vui lòng chụp ảnh trước khi lưu!');
            return;
        }

        const idGiaoVien = document.getElementById('input-id-giao-vien').value;
        const loai = document.getElementById('select-loai').value;
        const luot = document.getElementById('select-luot') ? document.getElementById('select-luot').value : 'DI';

        if (!idGiaoVien) {
            alert('Không tìm thấy thông tin Giáo viên. Vui lòng kiểm tra lại tài khoản.');
            return;
        }

        btnUpload.disabled = true;
        btnUpload.innerHTML = '<i class="fa fa-spinner fa-spin me-1"></i> Đang lưu...';

        const formData = new FormData();
        formData.append('image_data', capturedBase64Data);
        formData.append('loai', loai);
        formData.append('luot', luot);
        formData.append('id_giao_vien', idGiaoVien);
        formData.append('_csrf', CSRF_TOKEN);

        fetch(UPLOAD_URL, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(res => {
            btnUpload.disabled = false;
            btnUpload.innerHTML = '<i class="fa fa-cloud-upload me-1"></i> Lưu & Tải lên';

            if (res.success) {
                cameraStatus.textContent = 'Đã tải lên';
                cameraStatus.className = 'status-badge bg-success text-white';

                uploadResult.style.display = 'block';
                //resultDetail.textContent = 'File ' + res.data.file_name + ' đã lưu thành công cho giáo viên ID ' + idGiaoVien + '.';
                resultDetail.textContent = 'File ' + res.data.file_name + ' đã lưu thành công.';
                resultLink.href = res.data.file_url;

                // Tự động chuyển hướng về trang chủ sau khi lưu ảnh thành công
                setTimeout(function() {
                    window.location.href = HOME_URL;
                }, 400);
            } else {
                alert('Lỗi: ' + (res.message || 'Không thể lưu hình ảnh.'));
                cameraStatus.textContent = 'Thất bại';
                cameraStatus.className = 'status-badge bg-danger text-white';
            }
        })
        .catch(err => {
            btnUpload.disabled = false;
            btnUpload.innerHTML = '<i class="fa fa-cloud-upload me-1"></i> Lưu & Tải lên';
            console.error(err);
            alert('Đã xảy ra lỗi khi kết nối với máy chủ.');
        });
    });

    // Bắt đầu khởi chạy camera khi trang vừa load
    startCamera();
})();
JS;

$this->registerJs($script);
?>