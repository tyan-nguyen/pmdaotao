<?php
use kartik\date\DatePicker;
use yii\helpers\Html;
use app\modules\user\models\User;
use app\modules\hocvien\models\HangDaoTao;
use app\modules\hocvien\models\DangKyHv;
use app\modules\khoahoc\models\KhoaHoc;
?>

<div class="row" style="margin-top:20px">
	<div class="col-md-12">
		<h4 class="text-primary">Chọn khoảng thời gian</h4>
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
                'format' => 'dd/mm/yyyy'
            ]
        ])?>
    </div>
    <div class="col-md-2">    
    	<label class="form-label">&nbsp;</label>
        <?= Html::textInput('endtime', '', ['id'=>'endtime', 'class'=>'form-control']) ?>
    </div>
</div>

<div class="row" style="margin-top:20px">
	<div class="col-md-12">
		<h4 class="text-primary">Chọn thông tin lọc hồ sơ</h4>
	</div>
    
    
    <div class="col-md-3">    
    	<label class="form-label">Nhân viên</label>
        <?= Html::dropDownList('byuser', null, User::getListNvNhanHoSo() , ['id'=>'byuser', 'class'=>'form-control', 'prompt'=>'-Tất cả-']) ?>
    </div>
    
</div>

<div class="row" style="margin-top:20px">
	<div class="col-md-12">
		<h4 class="text-primary">Tùy chọn khác</h4>
	</div>
    <div class="col-md-4">    
    	<label class="form-label">Sắp xếp danh sách theo</label>
        <?= Html::dropDownList('sort', null, [
            'ngay'=>'Sắp xếp theo ngày xuất hàng',
            'sohd'=>'Sắp xếp theo số hóa đơn', 
        ] , ['id'=>'sort', 'class'=>'form-control']) ?>
    </div>
    <div class="col-md-4">    
    	<label class="form-label">Loại biên bản bàn giao</label>
        <?= Html::dropDownList('bienbanfull', null, [
            '0'=>'Theo hóa đơn',
            '1'=>'Theo xe', 
        ] , ['id'=>'bienbanfull', 'class'=>'form-control']) ?>
    </div>
</div>

<div class="row">    
     <div class="col-md-3" style="padding-top:20px">    
    	<?= Html::button('<i class="fa fa-print"> </i> In Báo cáo', ['class' => 'btn btn-success', 'style'=>'width:100%', 'onclick' => 'InBaoCao(0)']) ?>
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
        url: $('#bienbanfull').val()==1 ? '/thuexe/report/rp-theo-ca-hang-hoa-print?startdate=' + $('#startdate').val() + '&starttime=' + $('#starttime').val() + '&enddate=' + $('#enddate').val() + '&endtime=' + $('#endtime').val() + '&byuser='+ $('#byuser').val() + '&sortby='+ $('#sort').val() + '&bienbanfull=' + $('#bienbanfull').val() : '/thuexe/report/rp-theo-ca-hoa-don-print?startdate=' + $('#startdate').val() + '&starttime=' + $('#starttime').val() + '&enddate=' + $('#enddate').val() + '&endtime=' + $('#endtime').val() + '&byuser='+ $('#byuser').val() + '&sortby='+ $('#sort').val() + '&bienbanfull=' + $('#bienbanfull').val(),
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
