<?php 


use kartik\date\DatePicker;
use yii\helpers\Html;
use app\modules\user\models\User;
use app\modules\hocvien\models\DangKyHv;
?>

<div class="alert alert-outline-success" role="alert">
	<button aria-label="Close" class="btn-close float-end" data-bs-dismiss="alert" type="button">
		<span aria-hidden="true">×</span></button>
	<strong><span class="alert-inner--icon d-inline-block me-1"><i class="fe fe-bell"></i></span> In danh sách theo ca</strong> <br/>Có thể in báo cáo cho tất cả hoặc theo từng nơi tiếp nhận hồ sơ và nhân viên tiếp nhận. Đối với báo cáo theo ca của từng nhân viên cần chọn: 
	<ul>
		<li><i class="fa fa-angle-double-right mb-2 me-2"></i> Thời gian: từ ngày-giờ-phút-giây đến ngày-giờ-phút-giây.</li>
		<li><i class="fa fa-angle-double-right mb-2 me-2"></i> Nhân viên tiếp nhận hồ sơ.</li>
		<li><i class="fa fa-angle-double-right mb-2 me-2"></i> Nơi nhận hồ sơ (nơi đăng ký).</li>
	</ul>
</div>

<div class="row">
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
<div class="row" style="margin-top:20px">
	<div class="col-md-12">
		<h4 class="text-primary">Chọn thông tin lọc danh sách</h4>
	</div>
    <div class="col-md-4">    
    	<label class="form-label">Nhân viên</label>
        <?= Html::dropDownList('byuser', null, User::getListNvNhanHoSo() , ['id'=>'byuser', 'class'=>'form-control', 'prompt'=>'-Tất cả-']) ?>
    </div>
    <div class="col-md-4">    
    	<label class="form-label">Nơi đăng ký</label>
        <?= Html::dropDownList('byaddress', null, DangKyHv::getDmNoiDangKy() , ['id'=>'byaddress', 'class'=>'form-control', 'prompt'=>'-Tất cả-']) ?>
    </div>
</div>

<div class="row">    
    <!-- <div class="col-md-2" style="padding-top:20px">    
    	<?= Html::button('<i class="fa fa-print"> </i> In Phiếu mẫu cũ', ['class' => 'btn btn-success', 'style'=>'width:100%', 'onclick' => 'InBaoCao(0,0)']) ?> 
    </div>  -->
     <div class="col-md-3" style="padding-top:20px">    
    	<?= Html::button('<i class="fa fa-print"> </i> In Phiếu mẫu 1', ['class' => 'btn btn-success', 'style'=>'width:100%', 'onclick' => 'InBaoCao(0,1)']) ?>
    </div>
     <div class="col-md-3" style="padding-top:20px">    
    	<?= Html::button('<i class="fa fa-print"> </i> In Phiếu mẫu 2 (>3 lần TT)', ['class' => 'btn btn-success', 'style'=>'width:100%', 'onclick' => 'InBaoCao(0,2)']) ?>
    </div>
     <div class="col-md-3" style="padding-top:20px">    
    	<?= Html::button('<i class="fa fa-print"> </i> In Phiếu mẫu 3 (Có hạng ĐT)', ['class' => 'btn btn-success', 'style'=>'width:100%', 'onclick' => 'InBaoCao(0,3)']) ?>
    </div>
    <div class="col-md-3" style="padding-top:20px">    
    	<?= Html::button('<i class="fas fa-file-excel"></i> Xuất Excel', ['class' => 'btn btn-success', 'style'=>'width:100%', 'onclick' => 'XuatExcel(0,2)']) ?>
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
        url: '/hocvien/dang-ky-hv/get-phieu-in-report-list-ajax?startdate=' + $('#startdate').val() + '&starttime=' + $('#starttime').val() + '&enddate=' + $('#enddate').val() + '&endtime=' + $('#endtime').val() + '&byuser='+ $('#byuser').val() + '&typereport=' + typereport + '&byaddress=' + $('#byaddress').val(),
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

function XuatExcel(nhap, typereport) {
   var url = '/hocvien/bao-cao/xuat-danh-sach-ca-excel?startdate=' + $('#startdate').val() + '&starttime=' + $('#starttime').val() + '&enddate=' + $('#enddate').val() + '&endtime=' + $('#endtime').val() + '&byuser='+ $('#byuser').val() + '&typereport=' + typereport + '&byaddress=' + $('#byaddress').val();
   window.open(url, '_blank', 'noopener,noreferrer');
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
