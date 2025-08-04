<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\widgets\CardWidget;
use app\modules\banhang\models\HoaDon;
use kartik\select2\Select2;
use yii\web\JsExpression;
use app\modules\thuexe\models\LichThue;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\modules\thuexe\models\LichThue */
/* @var $form yii\widgets\ActiveForm */
$giaoVienValue = '';
if ($model->id_giao_vien) {
    $giaoVienValue = $model->giaoVien ? $model->giaoVien->ho_ten : '';
}
$khachHangValue = '';
if ($model->id_khach_hang) {
    $khachHangValue = $model->khachHang ? $model->khachHang->ho_ten : '';
}
?>

<div class="lich-thue-form">
    <?php $form = ActiveForm::begin([
        'action' => $model->isNewRecord?'':['/thuexe/lich-thue/update', 'id'=>$model->id]
    ]); ?>
    
	<?php CardWidget::begin(['title'=>'THÔNG TIN KHÁCH HÀNG']) ?>	
	<div class="row">
        <div class="col-md-2" style="display:none">
			<?= $form->field($model, 'loai_giao_vien')->dropDownList(LichThue::getDmLoaiGiaoVien(), ['prompt'=>'-Chọn-', 'id'=>'ddlLoaiGiaoVien', 'disabled' => true]) ?>
		</div>
        <div class="col-md-3">
        	<?php 
        	   $giaoVienLabel = 'Người hướng dẫn <a href="/banhang/khach-hang/create-popup2" role="modal-remote-2" style="padding-left:10px;" title="Thêm khách hàng"><i class="fa-solid fa-square-plus"></i></a>';
        	?>
        	<label><?= $model->loai_giao_vien == LichThue::GV_KHACHNGOAI ? $giaoVienLabel : 'Giáo viên' ?></label>
        	 <?= $form->field($model, 'id_giao_vien')->widget(Select2::classname(), [
                //'data' => KhachHang::getList(),
                'initValueText' => $giaoVienValue, // This shows selected text on form load
                'language' => 'vi',
                'options' => [
                    'placeholder' => 'Chọn giáo viên...',  
                    'class' => 'form-control dropdown-with-arrow',
                    'id' => 'giao-vien-dropdown'
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'),
                    'width'=>'100%',
                    'minimumInputLength' => 0, // ← allow fetch without typing
                    'ajax' => [
                        'url' => '/banhang/khach-hang/search-giao-vien',
                        'dataType' => 'json',
                        'delay' => 250,
                        /* 'data' => new JsExpression('function(params) {
                            return {q:params.term};
                        }'), */
                        'data' => new JsExpression('function(params) {
                            return {
                                q: params.term || "", // if empty input, send empty string
                                loai: "'.($model->loai_giao_vien?$model->loai_giao_vien:'').'",
                            };
                        }'),
                        'processResults' => new JsExpression('function(data) {
                            return {results:data};
                        }'),
                        'cache' => true
                    ],
                ],
            ])->label(false); ?>
        </div>
        <div class="col-md-3">
            <label>Họ tên</label> <br/>
            <span id="gvHoTen" style="font-weight:bold"><?= $model->giaoVien ? $model->giaoVien->ho_ten : '' ?></span>
        </div>
        <div class="col-md-3">
            <label>Số điện thoại</label><br/>
            <span id="gvSDT" style="font-weight:bold"><?= $model->giaoVien ? $model->giaoVien->so_dien_thoai : '' ?></span>
        </div>
        <div class="col-md-3">
            <label>Địa chỉ</label><br/>
            <span id="gvDiaChi" style="font-weight:bold"><?= $model->giaoVien ? $model->giaoVien->dia_chi : '' ?></span>
        </div>
   </div>

   <div class="row">
        <div class="col-md-2" style="display:none">
			<?= $form->field($model, 'loai_khach_hang')->dropDownList(LichThue::getDmLoaiKhachHang(), ['prompt'=>'-Chọn-', 'id'=>'ddlLoaiKhachHang', 'disabled' => true]) ?>
		</div>
        <div class="col-md-3">
        <?php 
        	   $khachHangLabel = 'Khách hàng <a href="/banhang/khach-hang/create-popup" role="modal-remote-2" style="padding-left:10px;" title="Thêm khách hàng"><i class="fa-solid fa-square-plus"></i></a>';
        	?>
        	<label><?= $model->loai_khach_hang == LichThue::KH_KHACHNGOAI ? $khachHangLabel : 'Học viên' ?></label>
        	<?= $form->field($model, 'id_khach_hang')->widget(Select2::classname(), [
                //'data' => KhachHang::getList(),
                'initValueText' => $khachHangValue, // This shows selected text on form load
                'language' => 'vi',
                'options' => [
                    'placeholder' => 'Chọn khách hàng...',  
                    'class' => 'form-control dropdown-with-arrow',
                    'id' => 'khach-hang-dropdown'
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'),
                    'width'=>'100%',
                    'minimumInputLength' => 0, // ← allow fetch without typing
                    'ajax' => [
                        'url' => '/banhang/khach-hang/search',
                        'dataType' => 'json',
                        'delay' => 250,
                        /* 'data' => new JsExpression('function(params) {
                            return {q:params.term};
                        }'), */
                        'data' => new JsExpression('function(params) {
                            return {
                                q: params.term || "", // if empty input, send empty string
                                loai: "'.($model->loai_khach_hang?$model->loai_khach_hang:'').'",
                            };
                        }'),
                        'processResults' => new JsExpression('function(data) {
                            return {results:data};
                        }'),
                        'cache' => true
                    ],
                ],
            ])->label(false); ?>
        </div>
        <div class="col-md-3">
            <label>Họ tên</label> <br/>
            <span id="khHoTen" style="font-weight:bold"><?= $model->khachHang ? $model->khachHang->ho_ten : '' ?></span>
        </div>
        <div class="col-md-3">
            <label>Số điện thoại</label><br/>
            <span id="khSDT" style="font-weight:bold"><?= $model->khachHang ? $model->khachHang->so_dien_thoai : '' ?></span>
        </div>
        <div class="col-md-3">
            <label>Địa chỉ</label><br/>
            <span id="khDiaChi" style="font-weight:bold"><?= $model->khachHang ? $model->khachHang->dia_chi : '' ?></span>
        </div>
   </div>
   <?php CardWidget::end() ?>
   
   <?php /* CardWidget::begin(['title'=>'THÔNG TIN XE THUÊ']) ?>
   <div class="row">        
        <div class="col-md-4">
        	<?= $form->field($model, 'thoi_gian_bat_dau')->textInput() ?>
        </div>
        <div class="col-md-4">
        	<?= $form->field($model, 'thoi_gian_ket_thuc')->textInput() ?>
        </div>
        
        <div class="col-md-4">
        	<?= $form->field($model, 'id_xe')->textInput() ?>
        </div>
   </div>
   <?php CardWidget::end()*/ ?>
   
   <?php CardWidget::begin(['title'=>'THÔNG TIN XE THUÊ']) ?>
   <div class="row">  
   		<div class="col-md-4">
        	<?= $form->field($model, 'id_xe')->widget(Select2::classname(), [
       		       'data' => LichThue::getDsXeCamUng(),
                    'language' => 'vi',
                    'options' => ['placeholder' => 'Chọn xe...'],
                    'pluginOptions' => [
                        'width'=>'100%',
                        'allowClear' => true,
                        'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'),
                    ],
             ]);?>
        </div>      
        <div class="col-md-2">
        	<?= $form->field($model, 'ngay_bat_dau')->widget(DatePicker::classname(), [
        	    'options' => ['id' => 'start-date', 'placeholder' => 'Chọn ngày  ...'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd/mm/yyyy',
                    'todayHighlight'=>true,
                    'todayBtn'=>true
                ],
        	    'pluginEvents' => [
        	        "changeDate" => "function(e) {
                        // Lấy ngày được chọn ở start-date
                        var startDate = e.format('dd/mm/yyyy');    
                        console.log('Ngày được chọn:', startDate);                	        
                        // Cập nhật cho DatePicker end-date
                        //$('#end-date').datepicker('setStartDate', startDate);   
                        
                      //  $('#end-date').val(startDate).trigger('change');   
              	        
                        // Nếu B < A => cập nhật B = A
                        var endVal = $('#end-date').val();
                        console.log('Ngày KT:', endVal);   
                        /*if(endVal==null || endVal < startDate){
                            //$('#end-date').datepicker('update', startDate);
                            //$('#end-date').val(startDate).trigger('change');
                            $('#end-date').val(startDate).trigger('change');
                        }*/
                        //set end date bang gia tri start date nếu chưa chọn
                        if(endVal==''){
                            $('#end-date').val(startDate).trigger('change');
                        }
                    }"
        	    ]
            ]); ?>
        </div>
        <div class="col-md-1">
        	<?= $form->field($model, 'gio_bat_dau')->dropDownList(LichThue::getListHoursOfDay()) ?>
        </div>
        <div class="col-md-1">
        	<?= $form->field($model, 'phut_bat_dau')->dropDownList(LichThue::getList15MinutesOfHour()) ?>
        </div>
        <div class="col-md-2">
        	<?= $form->field($model, 'ngay_ket_thuc')->widget(DatePicker::classname(), [
        	    'options' => ['id' => 'end-date', 'placeholder' => 'Chọn ngày  ...'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd/mm/yyyy',
                    'todayHighlight'=>true,
                    'todayBtn'=>true
                ],
        	   /* 'pluginEvents' => [
        	        "changeDate" => "function(e) {
                        // Lấy ngày được chọn ở start-date
                        var endDate = e.format('dd/mm/yyyy');
                        console.log('Ngày được chọn:', endDate);
                        // Cập nhật cho DatePicker end-date
                        //$('#end-date').datepicker('setStartDate', startDate);
                        //$('#start-date').val(startDate).trigger('change');
                        // Nếu B < A => cập nhật B = A
                        var startVal = $('#start-date').val();
                        console.log('Ngày BĐ:', startVal);
                        if(startVal == ''){
                            $('#start-date').val(endDate).trigger('change');
                        }
                    }"
        	    ]*/
            ]); ?>
        </div>
         <div class="col-md-1">
        	<?= $form->field($model, 'gio_ket_thuc')->dropDownList(LichThue::getListHoursOfDay()) ?>
        </div>
         <div class="col-md-1">
        	<?= $form->field($model, 'phut_ket_thuc')->dropDownList(LichThue::getList15MinutesOfHour()) ?>
        </div>
   </div>
   <?php CardWidget::end() ?>
   
   <?php CardWidget::begin(['title'=>'THÔNG TIN PHIẾU THU (Tổng tiền: ' . number_format($model->so_gio*$model->don_gia) . ' đồng)']) ?>
   <div class="row">
        <div class="col-md-2">
        	<?= $form->field($model, 'so_gio')->textInput() ?>
        </div>
        <div class="col-md-2">
        	<?= $form->field($model, 'don_gia')->textInput() ?>
        </div>
        <div class="col-md-2">
        	<?= $form->field($model, 'hinh_thuc_thanh_toan')->dropDownList(
                HoaDon::getDmHinhThucThanhToan(),
                ['prompt'=>'-Chưa chọn-']
            ) ?>
        </div>
        <div class="col-md-2">
        	<?= $form->field($model, 'trang_thai')->dropDownList(LichThue::getDmTrangThai()) ?>
        </div>
        
        <div class="col-md-4">
        	<?= $form->field($model, 'ghi_chu')->textInput() ?>
        	<?php // $form->field($model, 'ghi_chu')->textarea(['rows' => 6]) ?>
        </div>
  </div>
  <?php CardWidget::end() ?>
        
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>

<script>

function getGiaoVienAjax(idkh){
    $.ajax({
        type: 'post',
        url: '/banhang/khach-hang/get-giao-vien-ajax?idkh=' + idkh + '&loai=' + $('#ddlLoaiGiaoVien').val(),
        //data: frm.serialize(),
        success: function (data) {
            console.log('Submission was successful.');
            console.log(data);            
            if(data.status == 'success'){
            	$('#gvHoTen').text(data.gvHoTen);
            	$('#gvSDT').text(data.gvSDT);
            	$('#gvDiaChi').text(data.gvDiaChi);
            } else {
            	alert('Thông tin Giáo viên không còn tồn tại trên hệ thống!');
            }
        },
        error: function (data) {
            console.log('An error occurred.');
            console.log(data);
        },
    });
}

function clearInfoGiaoVien(){
	$('#gvHoTen').text('');
	$('#gvSDT').text('');
	$('#gvDiaChi').text('');
}

$('#giao-vien-dropdown').on("select2:select", function(e) { 
   if(this.value != ''){
   		getGiaoVienAjax(this.value);
   } else {
   		clearInfoGiaoVien();
   }
});

$('#giao-vien-dropdown').on('select2:clear', function(e) {
    clearInfoGiaoVien();
});

function getKhachHangAjax(idkh){
    $.ajax({
        type: 'post',
        url: '/banhang/khach-hang/get-khach-hang-ajax?idkh=' + idkh + '&loai=' + $('#ddlLoaiKhachHang').val(),
        //data: frm.serialize(),
        success: function (data) {
            console.log('Submission was successful.');
            console.log(data);            
            if(data.status == 'success'){
            	$('#khHoTen').text(data.khHoTen);
            	$('#khSDT').text(data.khSDT);
            	$('#khDiaChi').text(data.khDiaChi);
            } else {
            	alert('Thông tin Khách hàng không còn tồn tại trên hệ thống!');
            }
        },
        error: function (data) {
            console.log('An error occurred.');
            console.log(data);
        },
    });
}

function clearInfoKhachHang(){
	$('#khHoTen').text('');
	$('#khSDT').text('');
	$('#khDiaChi').text('');
}
    	
$('#khach-hang-dropdown').on("select2:select", function(e) { 
   if(this.value != ''){
   		getKhachHangAjax(this.value);
   } else {
   		clearInfoKhachHang();
   }
});
$('#khach-hang-dropdown').on('select2:clear', function(e) {
    clearInfoKhachHang();
});


function runFunc2(sendVal){
	var url = '/banhang/khach-hang/refresh-select2?selected=' + sendVal;
	$.ajax({
        url: url,
        method: 'GET',
        success: function (response) {
            var $select = $('#giao-vien-dropdown');
            $select.empty(); // Xóa hết option cũ
            var selectedValue = null;
    
            $.each(response, function(i, item) {
                var isSelected = item.selected === true;
                var option = new Option(item.text, item.id, false, isSelected);
    
                $select.append(option);
    
                if (isSelected) {
                    selectedValue = item.id;
                }
            });
    
            // Cập nhật Select2 giao diện
            if (selectedValue !== null) {
                $select.val(selectedValue).trigger('change');
                getGiaoVienAjax(selectedValue);//doc du lieu de lay thong tin
            } else {
                $select.trigger('change');
            }
        },
        contentType: false,
        cache: false,
        processData: false
   });
}

function runFunc(sendVal){
	var url = '/banhang/khach-hang/refresh-select2?selected=' + sendVal;
	$.ajax({
        url: url,
        method: 'GET',
        success: function (response) {
            var $select = $('#khach-hang-dropdown');
            $select.empty(); // Xóa hết option cũ
            var selectedValue = null;
    
            $.each(response, function(i, item) {
                var isSelected = item.selected === true;
                var option = new Option(item.text, item.id, false, isSelected);
    
                $select.append(option);
    
                if (isSelected) {
                    selectedValue = item.id;
                }
            });
    
            // Cập nhật Select2 giao diện
            if (selectedValue !== null) {
                $select.val(selectedValue).trigger('change');
                getKhachHangAjax(selectedValue);//doc du lieu de lay thong tin
            } else {
                $select.trigger('change');
            }
        },
        contentType: false,
        cache: false,
        processData: false
   });
}
$.fn.modal.Constructor.prototype.enforceFocus = function() {};
</script>
