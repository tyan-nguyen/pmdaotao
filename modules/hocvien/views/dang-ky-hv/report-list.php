<?php 


use kartik\date\DatePicker;
use yii\helpers\Html;
use app\modules\user\models\User;
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
    	<label class="form-label">Nhân viên</label>
        <?= Html::dropDownList('byuser', null, User::getList() , ['id'=>'byuser', 'class'=>'form-control', 'prompt'=>'-Tất cả-']) ?>
    </div>
    
    <div class="col-md-4" style="padding-top:20px">    
    	<?= Html::button('<i class="fa fa-print"> </i> In Phiếu mẫu cũ', ['class' => 'btn btn-success', 'style'=>'width:100%', 'onclick' => 'InBaoCao(0,0)']) ?>
    </div>
     <div class="col-md-4" style="padding-top:20px">    
    	<?= Html::button('<i class="fa fa-print"> </i> In Phiếu mẫu 1', ['class' => 'btn btn-success', 'style'=>'width:100%', 'onclick' => 'InBaoCao(0,1)']) ?>
    </div>
</div>


<!-- Phần tử ẩn chứa nội dung phiếu -->
<div style="display:none">
  <div id="print"></div>
</div>

<script>
function InBaoCao(nhap, typereport) {
    $.ajax({
        type: 'POST',
        url: '/hocvien/dang-ky-hv/get-phieu-in-report-list-ajax?startdate=' + $('#startdate').val() + '&starttime=' + $('#starttime').val() + '&enddate=' + $('#enddate').val() + '&endtime=' + $('#endtime').val() + '&byuser='+ $('#byuser').val() + '&typereport=' + typereport,
        success: function (data) {
            if (data.status === 'success') {
                $('#print').html(data.content);
                //printPhieuXuat(); // Gọi hàm in phiếu
				printPhieu();
                // Khi in xong, cập nhật số lần in
               /* if(nhap == 0){//in thật
                    setTimeout(function() {
                        updatePrintCount(id);
                    }, 1000); // Đợi 1 giây sau khi in để cập nhật
                }*/
            } else {
                alert('Không thể tải phiếu!');
            }
        },
        error: function () {
            alert('Đã xảy ra lỗi.');
        }
    });
}

// Hàm cập nhật số lần in
/*function updatePrintCount(id) {
    $.ajax({
        type: 'POST',
        url: '/hocvien/dang-ky-hv/update-print-count?id='+id,
        success: function (response) {
            if (response.success) {
                $('#soLanIn'+id).text(response.so_lan_in); // Cập nhật số lần in
            } else {
                alert('Cập nhật số lần in thất bại!');
            }
        },
        error: function () {
            alert('Lỗi kết nối server!');
        }
    });
}*/
</script>
