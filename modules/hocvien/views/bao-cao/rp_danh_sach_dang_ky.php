<?php
use kartik\date\DatePicker;
use yii\helpers\Html;
use app\modules\user\models\User;
use app\modules\hocvien\models\HangDaoTao;
?>

<div class="row">
	<div class="col-md-3">
		<label class="form-label">Từ</label>
		<?= DatePicker::widget([
            'name' => 'startdate',
		    'id'=>'startdate',
            'type' => DatePicker::TYPE_COMPONENT_APPEND,
            'value' => date('d/m/Y'),
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd/mm/yyyy',
            ]
        ])?>
    </div>
    <div class="col-md-2">
    	<label class="form-label" >&nbsp;</label>
        <?= Html::textInput('startime', '', ['id'=>'starttime', 'class'=>'form-control']) ?>
    </div>
    <div class="col-md-3">    
        <label class="form-label">Đến</label>
		<?= DatePicker::widget([
            'name' => 'enddate',
		    'id'=>'enddate',
            'type' => DatePicker::TYPE_COMPONENT_APPEND,
            'value' => date('d/m/Y'),
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd/mm/yyyy'
            ]
        ])?>
    </div>
    <div class="col-md-2">    
    	<label class="form-label">&nbsp;</label>
        <?= Html::textInput('endtime', '', ['id'=>'endtime', 'class'=>'form-control']) ?>
    </div>
    <div class="col-md-2">    
    	<label class="form-label">Học phí</label>
        <?= Html::dropDownList('byhocphi', null, [
            'all'=>'Tất cả danh sách',
            'danop'=>'Học viên đã nộp 50%-100% học phí',
            'coc'=>'Cọc 1 triệu hoặc 2 triệu'
        ] , ['id'=>'byhocphi', 'class'=>'form-control']) ?>
    </div>
    <div class="col-md-2">    
    	<label class="form-label">Hạng đào tạo</label>
        <?= Html::dropDownList('byhangdaotao', null, [
            HangDaoTao::getList()
        ] , ['id'=>'byhangdaotao', 'class'=>'form-control  dropdown-with-arrow', 'prompt'=>'-Tất cả-']) ?>
    </div>
    <div class="col-md-2">    
    	<label class="form-label">Nhân viên</label>
        <?= Html::dropDownList('byuser', null, User::getList() , ['id'=>'byuser', 'class'=>'form-control', 'prompt'=>'-Tất cả-']) ?>
    </div>
    
     <div class="col-md-4" style="padding-top:20px">    
    	<?= Html::button('<i class="fa fa-print"> </i> In báo cáo', ['class' => 'btn btn-success', 'style'=>'width:100%', 'onclick' => 'InBaoCao(0)']) ?>
    </div>
</div>


<!-- Phần tử ẩn chứa nội dung phiếu -->
<div style="display:none">
  <div id="print"></div>
</div>

<script>
function InBaoCao(typereport) {
    $.ajax({
        type: 'POST',
        url: '/hocvien/bao-cao/rp-danh-sach-dang-ky-print?startdate=' + $('#startdate').val() + '&starttime=' + $('#starttime').val() + '&enddate=' + $('#enddate').val() + '&endtime=' + $('#endtime').val() + '&byuser='+ $('#byuser').val() + '&byhocphi=' + $('#byhocphi').val() + '&sortby=0'+ '&byhangdaotao=' + $('#byhangdaotao').val() + '&typereport=' + typereport,
        success: function (data) {
            if (data.status === 'success') {
                $('#print').html(data.content);
				printPhieu();
            } else {
                alert('Không thể tải phiếu!');
            }
        },
        error: function () {
            alert('Đã xảy ra lỗi.');
        }
    });
}
</script>
