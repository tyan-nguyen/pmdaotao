<?php
use yii\helpers\Html;
$this->registerCssFile('@web/css/lich-hoc.css', [
    'depends' => [\yii\bootstrap5\BootstrapAsset::className()],
]);

$this->title = 'Thời Khóa Biểu Học Viên';
    $data = '';  
    $idKH = $modelHV->id_khoa_hoc;
    $idNhom =$modelHV->id_nhom;
    $idHV = $modelHV->id;
?>

<div class="schedule-index" >
    <h4><?= Html::encode($this->title) ?></h4>
    <div class="filters mb-3 d-flex align-items-center gap-2">
        <?= Html::dropDownList('week', null, $weeks, [
            'class' => 'form-control form-control-sm',
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
    </div>

    <div style="display:none">
        <div id="print"></div>
    </div>
</div>




<div id="lhContent">
    <?= $this->render('_schedule_table', ['data' => $data,'idHV' => $modelHV->id]) ?>
</div>

<?php
$this->registerJs("
$('#week-selector').on('change', function() {
    var weekString = $(this).find(':selected').text(); 
     var idKH = '$idKH'; 
     var idNhom = '$idNhom';
     var idHV ='$idHV';
     
     $.ajax({
        url: '" . \yii\helpers\Url::to(['/hocvien/hoc-vien/load-schedule-week']) . "',
        type: 'GET',
        data: { week_string: weekString, idKH: idKH, idNhom:idNhom, idHV:idHV},
        success: function(data) {
            $('#schedule-table').html(data);
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error: ', {
                status: status,
                error: error,
                response: xhr.responseText
            });
            alert('Không thể tải lịch học. Lỗi: ' + error + '\\nChi tiết: ' + xhr.responseText);
        }
    });
});
");
?>

<script>
function InLichHoc() {
    $.ajax({
        type: 'POST',
        url: '/hocvien/hoc-vien/get-phieu-in-ajax?id=<?= $modelHV->id_khoa_hoc ?>&idHV=<?= $modelHV->id ?>&type=lichhoc',

        success: function (data) {
            if (data.status === 'success') {
                $('#print').html(data.content); 
                printPhieuXuat(); 
            } else {
                alert('Không thể tải phiếu!');
            }
        },
        error: function (xhr, status, error) {
            // Hiển thị chi tiết lỗi trong alert
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





