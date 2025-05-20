<?php
use kartik\date\DatePicker;
use yii\helpers\Html;
use app\modules\user\models\User;
use app\modules\hocvien\models\HangDaoTao;
use app\modules\hocvien\models\DangKyHv;
use app\modules\khoahoc\models\KhoaHoc;
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
    	<label class="form-label">Hạng đào tạo</label>
        <?= Html::dropDownList('byhangdaotao', null, HangDaoTao::getList(), ['id'=>'byhangdaotao', 'class'=>'form-control  dropdown-with-arrow', 'prompt'=>'-Tất cả-']) ?>
    </div>
    <div class="col-md-2">    
    	<label class="form-label">Khóa</label>
        <?= Html::dropDownList('bykhoa', null, KhoaHoc::getList(0), ['id'=>'bykhoa', 'class'=>'form-control  dropdown-with-arrow', 'prompt'=>'-Tất cả-']) ?>
    </div>
    <div class="col-md-2">    
    	<label class="form-label">Nhân viên</label>
        <?= Html::dropDownList('byuser', null, User::getList() , ['id'=>'byuser', 'class'=>'form-control', 'prompt'=>'-Tất cả-']) ?>
    </div>
    <div class="col-md-2">    
    	<label class="form-label">Nơi đăng ký</label>
        <?= Html::dropDownList('byaddress', null, DangKyHv::getDmNoiDangKy() , ['id'=>'byaddress', 'class'=>'form-control', 'prompt'=>'-Tất cả-']) ?>
    </div>
    <div class="col-md-2">    
    	<label class="form-label">Sắp xếp</label>
        <?= Html::dropDownList('sort', null, [
            'ngay'=>'Sắp xếp theo ngày nhận hồ sơ',
            'hang'=>'Sắp xếp theo hạng', 
        ] , ['id'=>'sort', 'class'=>'form-control']) ?>
    </div>
    
     <div class="col-md-3" style="padding-top:20px">    
    	<?= Html::button('<i class="fa fa-print"> </i> In Biên Bản', ['class' => 'btn btn-success', 'style'=>'width:100%', 'onclick' => 'InBaoCao(0)']) ?>
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
        url: '/hocvien/bao-cao/rp-bien-ban-ban-giao-print?startdate=' + $('#startdate').val() + '&starttime=' + $('#starttime').val() + '&enddate=' + $('#enddate').val() + '&endtime=' + $('#endtime').val() + '&byuser='+ $('#byuser').val() + '&sortby='+ $('#sort').val() + '&byhangdaotao=' + $('#byhangdaotao').val() + '&typereport=' + typereport + '&byaddress=' + $('#byaddress').val() + '&bykhoa=' + $('#bykhoa').val(),
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
