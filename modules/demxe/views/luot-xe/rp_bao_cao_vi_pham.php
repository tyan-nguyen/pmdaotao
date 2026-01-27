<?php
use kartik\date\DatePicker;
use yii\helpers\Html;
use app\modules\user\models\User;
use app\modules\hocvien\models\DangKyHv;
?>

<div class="alert alert-outline-success" role="alert">
	<button aria-label="Close" class="btn-close float-end" data-bs-dismiss="alert" type="button">
		<span aria-hidden="true">×</span></button>
	<strong><span class="alert-inner--icon d-inline-block me-1"><i class="fe fe-bell"></i></span> Xuất báo cáo vi phạm (cho xe đào tạo): 
	<ul>
		<li><i class="fa fa-angle-double-right mb-2 me-2"></i> Xe qua đêm.</li>
		<li><i class="fa fa-angle-double-right mb-2 me-2"></i> Xe đi không có kế hoạch trong ngày.</li>
	</ul>
</div>

<div class="row">
	<div class="col-md-12">
		<h4 class="text-primary">Chọn ngày</h4>
	</div>
	<div class="col-md-3">
		<label class="form-label text-primary">Từ (<span class="text-danger">*</span>)</label>
		<?= DatePicker::widget([
            'name' => 'startdate',
		    'id'=>'startdate',
            'type' => DatePicker::TYPE_COMPONENT_APPEND,
            'value' => date('d/m/Y'),
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd/mm/yyyy',
                'zIndexOffset'=>'9999',
                'todayHighlight'=>true,
                'todayBtn'=>true
            ]
        ])?>
    </div>
    <div class="col-md-2">
    	<label class="form-label" >&nbsp;</label>
        <?= Html::textInput('startime', '', ['id'=>'starttime', 'class'=>'form-control']) ?>
    </div>
    <div class="col-md-3">    
        <label class="form-label text-primary">Đến (<span class="text-danger">*</span>)</label>
		<?= DatePicker::widget([
            'name' => 'enddate',
		    'id'=>'enddate',
            'type' => DatePicker::TYPE_COMPONENT_APPEND,
            'value' => date('d/m/Y'),
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd/mm/yyyy',
                'zIndexOffset'=>'9999',
                'todayHighlight'=>true,
                'todayBtn'=>true
            ]
        ])?>
    </div>
    <div class="col-md-2">    
    	<label class="form-label">&nbsp;</label>
        <?= Html::textInput('endtime', '', ['id'=>'endtime', 'class'=>'form-control']) ?>
    </div>
</div>

<div class="row">    
     <div class="col-md-3" style="padding-top:20px">    
    	<?= Html::button('<i class="fa fa-print"> </i> In báo cáo', ['class' => 'btn btn-success', 'style'=>'width:100%', 'onclick' => 'InBaoCao(0,1)']) ?>
    </div>
    
    <!-- <div class="col-md-3" style="padding-top:20px">    
    	<?= Html::button('<i class="fas fa-file-excel"></i> Xuất Excel', ['class' => 'btn btn-success', 'style'=>'width:100%', 'onclick' => 'XuatExcel(0,1)']) ?>
    </div>  -->
    
</div>


<!-- Phần tử ẩn chứa nội dung phiếu -->
<div style="display:none">
  <div id="print"></div>
</div>

<script>
function InBaoCao(nhap, typereport) {
    $.ajax({
        type: 'POST',
        url: '/demxe/luot-xe/get-phieu-in-xe-dao-tao?startdate=' + $('#startdate').val() + '&starttime=' + $('#starttime').val() + '&enddate=' + $('#enddate').val() + '&endtime=' + $('#endtime').val() + '&typereport=' + typereport,
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

function XuatExcel(nhap, typereport) {
   var url = '/demxe/luot-xe/xuat-danh-sach-ca-excel?startdate=' + $('#startdate').val() + '&starttime=' + $('#starttime').val() + '&enddate=' + $('#enddate').val() + '&endtime=' + $('#endtime').val() + '&byuser='+ $('#byuser').val() + '&typereport=' + typereport + '&byaddress=' + $('#byaddress').val();
   window.open(url, '_blank', 'noopener,noreferrer');
}
</script>
