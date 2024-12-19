<?php
use yii\helpers\Html;
$this->registerCssFile('@web/css/lich-hoc.css', [
    'depends' => [\yii\bootstrap5\BootstrapAsset::className()],
]);

$this->title = 'Lịch dạy Giáo viên';
    $data = '';  
    $idGV = $model->id;
?>

<div class="schedule-index">
    <h4><?= Html::encode($this->title) ?></h4>
    <div class="filters mb-3">
    <?= Html::dropDownList('month', null, $months, [
        'class' => 'form-control d-inline-block',
        'style' => 'width: 250px;',
        'prompt' => 'Chọn tuần',
        'id' => 'week-selector',
     
    ]) ?>
    <?= Html::button('<i class="fa fa-print"> </i> In', ['class' => 'btn btn-info btn-md', 'onclick' => 'InPhieuThueXe()']) ?>
</div>

</div>

<div id="schedule-table">
    <?= $this->render('_schedule_table', ['data' => $data,'model' =>$model]) ?>
</div>

<?php
$this->registerJs("
$('#week-selector').on('change', function() {
    var weekString = $(this).find(':selected').text(); 
     var idGV = '$idGV'; 
   
    $.ajax({
        url: '" . \yii\helpers\Url::to(['/giaovien/giao-vien/load-schedule-week']) . "',
        type: 'GET',
        data: { week_string: weekString, idGV: idGV},
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






