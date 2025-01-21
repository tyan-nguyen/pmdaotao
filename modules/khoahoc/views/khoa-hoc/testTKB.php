<?php
use yii\helpers\Html;
use app\modules\khoahoc\models\NhomHoc;

$this->registerCssFile('@web/css/lich-hoc.css', [
    'depends' => [\yii\bootstrap5\BootstrapAsset::className()],
]);

$this->title = 'Thời Khóa Biểu Khóa Học';

    $nhomHoc = NhomHoc::find()->where(['id_khoa_hoc' => $model->id])->all();
    $nhomHocList = !empty($nhomHoc) ? \yii\helpers\ArrayHelper::map($nhomHoc, 'id', 'ten_nhom') : []; 
    $data = '';  
    $idKH = $model->id;
?>

<div class="schedule-index">
    <h4><?= Html::encode($this->title) ?></h4>
    <div class="filters mb-3 d-flex align-items-center justify-content-start gap-3">
        <?php if (!empty($nhomHocList)): ?>
            <?= Html::dropDownList('nhom', null, $nhomHocList, [
                'class' => 'form-control d-inline-block-sm',
                'style' => 'width: 250px;',
                'prompt' => 'Chọn nhóm học',
                'id' => 'nhom-selector',
            ]) ?>
        <?php endif; ?>

        <?= Html::dropDownList('week', null, $weeks, [
            'class' => 'form-control d-inline-block-sm',
            'style' => 'width: 250px;',
            'prompt' => 'Chọn tuần',
            'id' => 'week-selector',
            'disabled' => !empty($nhomHocList) ? true : false, 
        ]) ?>

        <?= Html::button('<i class="fa fa-print"> </i> In', [
            'class' => 'btn btn-info btn-md',
            'onclick' => 'InLichHoc()',
        ]) ?>
        <!-- Phần tử ẩn chứa nội dung phiếu -->
        <div style="display:none">
             <div id="print"></div>
        </div>
        <div class="d-flex align-items-center">
            <?= Html::a('<i class="fa fa-plus"> </i>', 
                ['/khoahoc/khoa-hoc/create-lich-hoc-from-khoa-hoc', 'id_khoa_hoc' => $model->id],
                [
                    'class' => 'btn ripple btn-danger btn-sm ',
                    'title' => 'Sắp lịch',
                    'style' => 'color: white;',
                    'role' => 'modal-remote-2',
                    'id' => 'sap-lich-button',
                ]
            ) ?>
        </div>
    </div>
</div>

<div id="lhContent">
    <?= $this->render('_schedule_table', ['data' => $data,'model' =>$model]) ?>
</div>

<?php
$this->registerJs("
$(document).ready(function() {
    var nhomSelector = $('#nhom-selector');
    var weekSelector = $('#week-selector');
    var idNhom = nhomSelector.val() || null;
    nhomSelector.on('change', function() {
     if ($(this).val()) {
                weekSelector.prop('disabled', false);
            } else {
                weekSelector.prop('disabled', true);
            }
        idNhom = $(this).val();
        loadData();
    });
    weekSelector.on('change', function() {
        loadData();
    });
    function loadData() {
        var weekString = weekSelector.find(':selected').text();
        var idKH = '$idKH';
        $.ajax({
            url: '" . \yii\helpers\Url::to(['/khoahoc/khoa-hoc/load-schedule-week']) . "',
            type: 'GET',
            data: { week_string: weekString, idKH: idKH, id_nhom: idNhom },
            success: function(data) {
                $('#schedule-table').html(data);
            },
            error: function(xhr, status, error) {
            }
        });
    }
    loadData();
});
");
?>


<script>
function InLichHoc() {
    $.ajax({
        type: 'POST',
        url: '/khoahoc/khoa-hoc/get-phieu-in-ajax?id=' + <?= $model->id?> + '&type=lichhoc',
        success: function (data) {
            if (data.status === 'success') {
                $('#print').html(data.content); 
                printPhieuXuat(); 
            } else {
                alert('Không thể tải phiếu!');
            }
        },
        error: function (xhr, status, error) {
            alert('Đã xảy ra lỗi trong quá trình tải dữ liệu.\n' +
                  'Mã lỗi: ' + xhr.status + '\n' + 
                  'Thông báo lỗi: ' + error + '\n' + 
                  'Phản hồi từ server: ' + xhr.responseText);
        }
    });
}

function printPhieuXuat() {
    var printContents = document.getElementById('print').innerHTML;
    if (!printContents.trim()) {
        alert('Nội dung phiếu không có, vui lòng thử lại.');
        return;
    }
    var iframe = document.createElement('iframe');
    iframe.style.position = 'absolute';
    iframe.style.width = '0px';
    iframe.style.height = '0px';
    iframe.style.border = 'none';
    document.body.appendChild(iframe);
    var doc = iframe.contentWindow.document;
    doc.open();
    doc.write(`
        <html>
            <head>
                <title>In lịch học</title>
                <style>
                    body { font-family: Arial, sans-serif; margin: 20px; }
                    table { width: 100%; border-collapse: collapse; }
                    table, th, td { border: 1px solid black; }
                    th, td { padding: 10px; text-align: left; }
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

    setTimeout(() => document.body.removeChild(iframe), 1000);
}
</script>






