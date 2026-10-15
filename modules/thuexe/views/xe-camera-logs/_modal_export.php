<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */

Modal::begin([
    'id' => 'modalExportExcel',
    'title' => '<h5 class="modal-title text-primary"><i class="fa fa-print me-1"></i> <i class="fa fa-file-excel-o me-2 text-success"></i> IN &amp; XUẤT BÁO CÁO THỐNG KÊ LƯỢT XE</h5>',
    'size' => Modal::SIZE_DEFAULT,
    'footer' => false,
]);
?>

<?php $form = ActiveForm::begin([
    'id' => 'formExportExcel',
    'action' => ['export-excel'],
    'method' => 'get',
    'options' => [
        'target' => '_blank',
    ],
]); ?>

<div class="mb-3">
    <label class="form-label fw-bold text-dark fs-14">1. Chọn Cổng kiểm soát / Camera:</label>
    <div class="border rounded p-3 bg-light">
        <div class="form-check mb-2">
            <input class="form-check-input" type="radio" name="khu_vuc_cong" id="gate_cantin" value="cong_can_tin" checked>
            <label class="form-check-label fw-semibold text-primary fs-14" for="gate_cantin">
                <i class="fe fe-map-pin me-1"></i> Cổng Căn Tin (cong_can_tin)
            </label>
            <div class="form-text text-muted small ms-4">Giám sát xe ra vào bãi qua cổng căn tin (Camera ANPR nhận diện biển số).</div>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="khu_vuc_cong" id="gate_sancambien" value="cong_san_cam_bien">
            <label class="form-check-label fw-semibold text-success fs-14" for="gate_sancambien">
                <i class="fe fe-map-pin me-1"></i> Cổng Sân Cảm Biến (cong_san_cam_bien)
            </label>
            <div class="form-text text-muted small ms-4">Giám sát xe vào / ra khu vực sân thi sát hạch cảm biến.</div>
        </div>
    </div>
</div>

<div class="mb-3">
    <label class="form-label fw-bold text-dark fs-14">2. Chọn loại báo cáo cần in / xuất:</label>
    <div class="border rounded p-3 bg-light">
        <div class="form-check mb-2">
            <input class="form-check-input" type="radio" name="loai_bao_cao" id="rpt_unplanned" value="XE_KHONG_KE_HOACH" checked>
            <label class="form-check-label fw-semibold text-danger" for="rpt_unplanned">
                <i class="fa fa-exclamation-triangle me-1"></i> Báo cáo Xe nội bộ đi không lập kế hoạch
            </label>
            <div class="form-text text-muted small ms-4">Thống kê gom nhóm theo xe (tổng số lượt vi phạm) và tổng hợp kết quả vi phạm theo từng lần.</div>
        </div>

        <div class="form-check mb-2">
            <input class="form-check-input" type="radio" name="loai_bao_cao" id="rpt_overnight" value="XE_QUA_DEM">
            <label class="form-check-label fw-semibold text-purple" for="rpt_overnight">
                <i class="fa fa-moon-o me-1"></i> Báo cáo Phương tiện lưu lại qua đêm
            </label>
            <div class="form-text text-muted small ms-4">Danh sách các xe ở ngoài hoặc lưu lại bãi sân qua khung giờ 00:00 - 05:00.</div>
        </div>

        <div class="form-check mb-2">
            <input class="form-check-input" type="radio" name="loai_bao_cao" id="rpt_external" value="XE_LA">
            <label class="form-check-label fw-semibold text-secondary" for="rpt_external">
                <i class="fa fa-globe me-1"></i> Báo cáo Xe khách ngoài / Xe vãng lai
            </label>
            <div class="form-text text-muted small ms-4">Danh sách xe ngoài vào sân, thời gian lưu lại trong bãi và rời sân.</div>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" name="loai_bao_cao" id="rpt_all" value="TAT_CA">
            <label class="form-check-label fw-semibold text-primary" for="rpt_all">
                <i class="fa fa-list-alt me-1"></i> Báo cáo Tổng hợp toàn bộ lượt xe ra - vào
            </label>
            <div class="form-text text-muted small ms-4">Xuất/In đầy đủ tất cả các lượt xe nội bộ và xe ngoài trong kỳ thống kê.</div>
        </div>
    </div>
</div>

<div class="mb-3">
    <label class="form-label fw-bold text-dark fs-14">3. Chọn khoảng thời gian:</label>
    <div class="row g-2">
        <div class="col-6">
            <label class="form-label fs-12 text-muted mb-1">Từ ngày:</label>
            <input type="date" class="form-control" name="tu_ngay" value="<?= date('Y-m-01') ?>" required>
        </div>
        <div class="col-6">
            <label class="form-label fs-12 text-muted mb-1">Đến ngày:</label>
            <input type="date" class="form-control" name="den_ngay" value="<?= date('Y-m-d') ?>" required>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center pt-3 border-top">
    <div>
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Đóng</button>
    </div>
    <div class="d-flex gap-2">
        <button type="button" class="btn btn-primary btn-sm px-3" id="btnInBaoCaoCamera" onclick="inBaoCaoCamera()">
            <i class="fa fa-print me-1"></i> In báo cáo (Print Preview)
        </button>
        <button type="submit" class="btn btn-success btn-sm px-3">
            <i class="fa fa-file-excel-o me-1"></i> Tải file Excel
        </button>
    </div>
</div>

<?php ActiveForm::end(); ?>

<script>
/**
 * In trực tiếp báo cáo vi phạm hiển thị Print Preview trình duyệt
 * Sử dụng iframe độc lập (sandbox) để không bao giờ ảnh hưởng đến CSS/giao diện toàn cục của ứng dụng.
 */
function inBaoCaoCamera(loaiBaoCaoOverride) {
    var form = $('#formExportExcel');
    var loaiBaoCao = loaiBaoCaoOverride || form.find('input[name="loai_bao_cao"]:checked').val() || 'XE_KHONG_KE_HOACH';
    var khuVucCong = form.find('input[name="khu_vuc_cong"]:checked').val() || 'cong_can_tin';
    var tuNgay = form.find('input[name="tu_ngay"]').val();
    var denNgay = form.find('input[name="den_ngay"]').val();

    if (!tuNgay || !denNgay) {
        alert('Vui lòng chọn khoảng thời gian Từ ngày và Đến ngày.');
        return;
    }

    var btn = $('#btnInBaoCaoCamera');
    var origHtml = btn.html();
    btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin me-1"></i> Đang tải dữ liệu in...');

    $.ajax({
        type: 'GET',
        url: '<?= Url::to(['print-report']) ?>',
        data: {
            loai_bao_cao: loaiBaoCao,
            khu_vuc_cong: khuVucCong,
            tu_ngay: tuNgay,
            den_ngay: denNgay
        },
        dataType: 'json',
        success: function (res) {
            btn.prop('disabled', false).html(origHtml);
            if (res && res.status === 'success') {
                // Tạo hoặc tái sử dụng iframe hoàn toàn độc lập với trang chính
                var iframe = document.getElementById('iframePrintCameraReport');
                if (!iframe) {
                    iframe = document.createElement('iframe');
                    iframe.id = 'iframePrintCameraReport';
                    iframe.style.position = 'fixed';
                    iframe.style.right = '0';
                    iframe.style.bottom = '0';
                    iframe.style.width = '0';
                    iframe.style.height = '0';
                    iframe.style.border = '0';
                    iframe.style.visibility = 'hidden';
                    document.body.appendChild(iframe);
                }

                var congLabel = (khuVucCong === 'cong_san_cam_bien') ? 'Sân Cảm Biến' : 'Cổng Căn Tin';
                var doc = iframe.contentWindow.document;
                doc.open();
                doc.write('<!DOCTYPE html><html><head><meta charset="utf-8"><title>Báo cáo vi phạm lượt xe - ' + congLabel + '</title>');
                doc.write('<style>');
                doc.write('@page { size: A4 portrait; margin: 12mm 10mm 15mm 10mm; }');
                doc.write('* { box-sizing: border-box; }');
                doc.write('body { font-family: "Times New Roman", Times, serif; font-size: 11pt; color: #000; margin: 0; padding: 0; background: #fff; }');
                doc.write('table { border-collapse: collapse; }');
                doc.write('</style>');
                doc.write('</head><body>');
                doc.write(res.content);
                doc.write('</body></html>');
                doc.close();

                // Đợi render nội dung trong iframe và kích hoạt hộp thoại in
                setTimeout(function () {
                    iframe.contentWindow.focus();
                    iframe.contentWindow.print();
                }, 300);
            } else {
                alert(res && res.message ? res.message : 'Không thể tải mẫu in báo cáo!');
            }
        },
        error: function () {
            btn.prop('disabled', false).html(origHtml);
            alert('Đã xảy ra lỗi khi kết nối máy chủ để lấy dữ liệu in.');
        }
    });
}

// Bắt sự kiện khi click mở modal từ các nút riêng biệt để tự động chọn đúng cổng
$(document).on('click', '[data-bs-target="#modalExportExcel"], a[href="#modalExportExcel"]', function () {
    var cong = $(this).data('cong');
    if (cong === 'cong_san_cam_bien') {
        $('#gate_sancambien').prop('checked', true);
    } else if (cong === 'cong_can_tin') {
        $('#gate_cantin').prop('checked', true);
    }
});
</script>

<?php Modal::end(); ?>
