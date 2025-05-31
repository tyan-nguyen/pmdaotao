<?php

use yii\helpers\Html;
use app\modules\khoahoc\models\KhoaHoc;
use app\modules\lichhoc\models\LichThi;

/* @var $this yii\web\View */
/* @var $model app\modules\lichhoc\models\LichThi */

$idKH = $model->id_khoa_hoc;
$modelKH = KhoaHoc::find()->where(['id' => $idKH])->one();
$modelLT = $modelKH ? LichThi::find()->where(['id_khoa_hoc' => $modelKH->id])->one() : null;
//$idNhom = $model->id_nhom;
$idNhom = $model->nhomHoc ? $model->nhomHoc->id : null;
?>
<div class="lich-thi-view">
    <div class="row">
        <div class="col-xl-5 col-md-8 mx-auto">
            <div class="card custom-card shadow-lg">
                <div class="card-header custom-card-header rounded-bottom-0 text-center" style="background-color: #f8f9fa; border-bottom: 2px solid #0d6efd;">
                    <h5 class="card-title mb-0" style="color: #0d6efd; font-weight: bold;">
                        <i class="fa fa-table me-2"></i>Lịch Thi
                    </h5>
                </div>
                <div class="card-body" style="background-color: #fdfdfe;">
                    <?php if (!$modelKH || !$modelLT || $idNhom != $model->id_nhom): ?>
                        <p class="text-danger text-center">
                            <i class="fas fa-exclamation-circle me-2"></i>Chưa có lịch thi
                        </p>
                    <?php else: ?>
                        <p>
                           <i class= "fas fa-book text-success me-2"></i>
                           <strong> Kỳ thi: </strong><?= Html::encode($modelLT->ten_ky_thi ?? '(Chưa xác định)') ?>
                        </p>
                        <p>
                            <i class="fas fa-book text-success me-2"></i>
                            <strong>Khóa học:</strong> <?= Html::encode($modelKH->ten_khoa_hoc) ?>
                        </p>
                        <p>
                            <i class="fas fa-users text-warning me-2"></i>
                            <strong>Nhóm:</strong> <?= Html::encode($modelLT->nhom->ten_nhom ?? '(Chung)') ?>
                        </p>
                        <p>
                            <i class="fas fa-door-open text-danger me-2"></i>
                            <strong>Phòng thi:</strong> <?= Html::encode($modelLT->phongThi->ten_phong ?? '(Chưa xác định)') ?>
                        </p>
                        <p>
                            <i class="fas fa-chalkboard-teacher text-primary me-2"></i>
                            <strong>Cán bộ coi thi:</strong> <?= Html::encode($modelLT->giaoVien->ho_ten ?? '(Chưa xác định)') ?>
                        </p>
                        <p>
                            <i class="fas fa-clock text-success me-2"></i>
                            <strong>Thời gian thi:</strong> <?= Yii::$app->formatter->asDatetime($modelLT->thoi_gian_thi, 'php:H:i | d-m-Y') ?>
                        </p>
                        <hr style = "width: 50%;border: 1px solid red;margin: 0 auto; ">
                        <br>
                        <p>
                           <?= Html::button('<i class="fa fa-print"> </i> In lịch thi', ['class' => 'btn btn-success', 'onclick' => 'InLichThi()']) ?>
                        </p>
                        <div style="display:none">
                            <div id="print"></div>
                        </div>
                    <?php endif; ?>
                </div>
               
            </div>
        </div>
    </div>
</div>

<script>
function InLichThi() {
    <?php if ($modelLT): ?>
        $.ajax({
            type: 'POST',
            url: '/hocvien/hoc-vien/get-lich-thi-ajax?id=<?= $modelLT->id ?>&type=lichthi',
            success: function (data) {
                if (data.status === 'success') {
                    $('#print').html(data.content);
                    printLichThi();
                } else {
                    alert('Không thể tải lịch thi!');
                }
            },
            error: function (xhr, status, error) {
                alert('Đã xảy ra lỗi:\n' +
                      'Trạng thái: ' + status + '\n' +
                      'Lỗi: ' + error + '\n' +
                      'Phản hồi từ máy chủ: ' + xhr.responseText);
            }
        });
    <?php else: ?>
        alert('Không có lịch thi!');
    <?php endif; ?>
}

function printLichThi() {
    var printContents = document.getElementById('print').innerHTML;

    // Tạo iframe ẩn
    var iframe = document.createElement('iframe');
    iframe.style.position = 'absolute';
    iframe.style.width = '0px';
    iframe.style.height = '0px';
    iframe.style.border = 'none';

    // Thêm iframe vào body
    document.body.appendChild(iframe);

    // Ghi nội dung cần in vào iframe
    var doc = iframe.contentWindow.document;
    doc.open();
    doc.write(`
        <html>
            <head>
                <title>In lịch thi</title>
                <style>
                    body { font-family: Arial, sans-serif; margin: 20px; }
                </style>
            </head>
            <body>
                ${printContents}
            </body>
        </html>
    `);
    doc.close();

    iframe.contentWindow.focus();
    iframe.contentWindow.print();

    // Xóa iframe 
    setTimeout(() => document.body.removeChild(iframe), 1000);
}
</script>
