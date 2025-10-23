<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\widgets\CardWidget;
use app\modules\banhang\models\HoaDon;
use kartik\select2\Select2;
use yii\web\JsExpression;
use app\modules\thuexe\models\LichThue;
use kartik\date\DatePicker;
use app\modules\user\models\User;
use app\custom\CustomFunc;

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
$checkDaThanh = $model->trang_thai==LichThue::TT_XUATHOADON?true:false;
$isAdmin = User::getCurrentUser()->superadmin;
$disallowEdit = true;//mac dinh la disallow
$laNgayCu = date('Y-m-d H:i:s') > $model->thoi_gian_ket_thuc ? true : false;
if(!$checkDaThanh || ($checkDaThanh && !$laNgayCu) || $isAdmin){
    $disallowEdit = false;
}
?>

<?php if($checkDaThanh && $isAdmin){ ?>
<div class="alert alert-danger mb-0" role="alert">
            <span class="alert-inner--icon d-inline-block me-1"><i class="fe fe-slash"></i></span>
            <span class="alert-inner--text"><strong>Thông báo!</strong> Bạn đang ở chế độ sửa dữ liệu khóa!</span>
        </div>
<?php } ?>

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
                    'id' => 'giao-vien-dropdown',
                    'disabled'=>$disallowEdit
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
        <div class="col-md-2">
            <label>Họ tên</label> <br/>
            <!-- <span id="gvHoTen" style="font-weight:bold"><?= $model->giaoVien ? $model->giaoVien->ho_ten : '' ?></span>-->
            <?= Html::textInput('ho_ten', 
                ($model->giaoVien ? $model->giaoVien->ho_ten : ''), 
                ['id'=>'gvHoTen', 'class'=>'form-control', 'disabled'=>true]) ?>
        </div>
        <div class="col-md-2">
            <label>Số điện thoại</label><br/>
            <!--  <span id="gvSDT" style="font-weight:bold"><?= $model->giaoVien ? $model->giaoVien->so_dien_thoai : '' ?></span>-->
            <?= Html::textInput('sdt', 
                ($model->giaoVien ? $model->giaoVien->so_dien_thoai : ''), 
                ['id'=>'gvSDT', 'class'=>'form-control', 'disabled'=>true]) ?>
        </div>
        <div class="col-md-2">
            <label>Số CCCD</label><br/>
            <?= Html::textInput('so_cccd', 
                ($model->giaoVien ? $model->giaoVien->so_cccd : ''), 
                ['id'=>'gvCCCD', 'class'=>'form-control', 'disabled'=>true]) ?>
        </div>
        <div class="col-md-3">
            <label>Địa chỉ</label><br/>
            <!-- <span id="gvDiaChi" style="font-weight:bold"><?= $model->giaoVien ? $model->giaoVien->diaChi : '' ?></span>-->
            <?= Html::textInput('dia_chi', 
                ($model->giaoVien ? $model->giaoVien->diaChi : ''), 
                ['id'=>'gvDiaChi', 'class'=>'form-control', 'disabled'=>true]) ?>
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
                    'id' => 'khach-hang-dropdown',
                    'disabled'=>$disallowEdit
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
        <div class="col-md-2">
            <label>Họ tên</label> <br/>
            <!-- <span id="khHoTen" style="font-weight:bold"><?= $model->khachHang ? $model->khachHang->ho_ten : '' ?></span>-->
            <?= Html::textInput('ho_ten', 
                ($model->khachHang ? $model->khachHang->ho_ten : ''), 
                ['id'=>'khHoTen', 'class'=>'form-control', 'disabled'=>true]) ?>
        </div>
        <div class="col-md-2">
            <label>Số điện thoại</label><br/>
            <!-- <span id="khSDT" style="font-weight:bold"><?= $model->khachHang ? $model->khachHang->so_dien_thoai : '' ?></span>-->
            <?= Html::textInput('sdt', 
                ($model->khachHang ? $model->khachHang->so_dien_thoai : ''), 
                ['id'=>'khSDT', 'class'=>'form-control', 'disabled'=>true]) ?>
        </div>
        <div class="col-md-2">
            <label>Số CCCD</label><br/>
            <?= Html::textInput('so_cccd', 
                ($model->khachHang ? $model->khachHang->so_cccd : ''), 
                ['id'=>'khCCCD', 'class'=>'form-control', 'disabled'=>true]) ?>
        </div>
        <div class="col-md-3">
            <label>Địa chỉ</label><br/>
            <!-- <span id="khDiaChi" style="font-weight:bold"><?= $model->khachHang ? $model->khachHang->diaChi : '' ?></span>-->
            <?= Html::textInput('khDiaChi', 
                ($model->khachHang ? $model->khachHang->diaChi : ''), 
                ['id'=>'khDiaChi', 'class'=>'form-control', 'disabled'=>true]) ?>
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
        	        'options' => ['placeholder' => 'Chọn xe...', 'disabled'=>$disallowEdit],
                    'pluginOptions' => [
                        'width'=>'100%',
                        'allowClear' => true,
                        'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'),
                    ],
        	    'pluginEvents' => [
        	        "change" => "function(e) {
                        $('#txtDonGia').val('');
                    }",
        	    ]
             ]);?>
        </div>      
        <div class="col-md-2">
        	<?= $form->field($model, 'ngay_bat_dau')->widget(DatePicker::classname(), [
        	    'options' => ['id' => 'start-date', 'placeholder' => 'Chọn ngày  ...', 'disabled'=>$disallowEdit],
        	    'removeButton'=>$disallowEdit?false:[],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd/mm/yyyy',
                    'todayHighlight'=>true,
                    'todayBtn'=>true,
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
        	<?= $form->field($model, 'gio_bat_dau')->dropDownList(LichThue::getListHoursOfDay(), [
        	    'disabled'=>$disallowEdit
        	]) ?>
        </div>
        <div class="col-md-1">
        	<?= $form->field($model, 'phut_bat_dau')->dropDownList(LichThue::getList15MinutesOfHour(), [
        	    'disabled'=>$disallowEdit
        	]) ?>
        </div>
        <div class="col-md-2">
        	<?= $form->field($model, 'ngay_ket_thuc')->widget(DatePicker::classname(), [
        	    'options' => ['id' => 'end-date', 'placeholder' => 'Chọn ngày  ...', 'disabled'=>$disallowEdit],
        	    'removeButton'=>$disallowEdit?false:[],
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
        	<?= $form->field($model, 'gio_ket_thuc')->dropDownList(LichThue::getListHoursOfDay(), [
        	    'disabled'=>$disallowEdit
        	]) ?>
        </div>
         <div class="col-md-1">
        	<?= $form->field($model, 'phut_ket_thuc')->dropDownList(LichThue::getList15MinutesOfHour(), [
        	    'disabled'=>$disallowEdit
        	]) ?>
        </div>
   </div>
   <?php CardWidget::end() ?>
   
   <?php CardWidget::begin(['title'=>'THÔNG TIN PHIẾU THU (Tổng tiền: ' . number_format($model->so_gio*$model->don_gia) . ' đồng)']) ?>
   <div class="row" style="padding: 0 50px; font-weight: bold;">
        <div class="col-md-2">
        	<?= $form->field($model, 'so_gio')->textInput(['disabled'=>true]) ?>
        </div>
        <div class="col-md-2">
        	<?= $form->field($model, 'don_gia')->textInput([/* 'value'=>number_format($model->don_gia) . ' đồng', */ 'disabled'=>$disallowEdit, 'id'=>'txtDonGia']) ?>
        </div>
        <!-- 
        <div class="col-md-2">
        	<?= $form->field($model, 'hinh_thuc_thanh_toan')->dropDownList(
                HoaDon::getDmHinhThucThanhToan(),
                ['prompt'=>'-Chưa chọn-']
            ) ?>
        </div>
         -->
        <div class="col-md-2">
        	<?= $form->field($model, 'trang_thai')->dropDownList(LichThue::getDmTrangThai(), [
        	    'disabled'=>$disallowEdit
        	]) ?>
        </div>
        
        <?php if($model->isNewRecord){?>
         <div class="col-md-6">
        	<?= $form->field($model, 'ghi_chu')->textInput() ?>
        </div>
        <?php } else { ?>
        <div class="col-md-3">
        	<?= $form->field($model, 'ghi_chu')->textInput() ?>
        </div>
        
        <div class="col-md-3">
        	<label>Trạng thái: <?= $model->trangThaiThanhToanWithBadge ?></label><br/>
        	<?= Html::a('<i class="fas fa-dollar-sign"></i> T.T tất cả', '/thuexe/phieu-thu/thanh-toan?type=all&idlich='.$model->id, [
                'title' => 'Thanh toán 100%',
                'role' => 'modal-remote',
                'class' => 'btn btn-warning', 
                'data-bs-placement' => 'top',
                'data-bs-toggle' => 'tooltip',
                'style'=>'color:white'
            ])?> 
            <?= Html::a('<i class="fas fa-dollar-sign"></i> T.T tùy chọn', '/thuexe/phieu-thu/thanh-toan?type=normal&idlich='.$model->id, [
                'title' => 'Đặt cọc',
                'role' => 'modal-remote',
                'class' => 'btn btn-danger', 
                'data-bs-placement' => 'top',
                'data-bs-toggle' => 'tooltip',
                'style'=>'color:white'
            ])?>
        </div>
        <?php } ?>
  </div>
  <?= (!$model->isNewRecord && $model->phieuThus!=null) ? $this->render('_phieu_thu', ['model'=>$model]) : '' ?>
 
  	<span><?= Html::img('/uploads/icons/info.png', ['width'=>30]) ?></span>
  	Người tạo lịch: <strong><?= $model->nguoiTao?($model->nguoiTao->hoTen. ' (' .$model->nguoiTao->username . ')'):'-'?></strong> 
  	 <?php if(!$model->isNewRecord && $model->phieuThus!=null){ ?>
  	&nbsp;-&nbsp; Tổng tiền: <strong><?= $model->tongTien?number_format($model->tongTien):0 ?> đồng</strong> 
  	&nbsp;-&nbsp; Đã nộp: <strong><?= $model->tienDaNopDuong?number_format($model->tienDaNopDuong):0 ?> đồng</strong> 
  	&nbsp;-&nbsp; Chiết khấu: <strong><?= $model->tienChietKhau?number_format($model->tienChietKhau):0 ?> đồng</strong> 
  	&nbsp;-&nbsp; Chi lại: <span style="font-weight: bold;color:red"><?= $model->tienDaNopAm?number_format($model->tienDaNopAm):0 ?> đồng</span>
  	&nbsp;-&nbsp; Còn lại: <strong><?= $model->tienChuaThanhToan?number_format($model->tienChuaThanhToan):0 ?> đồng</strong>
  <?php } ?>
  	
  <?php CardWidget::end() ?>
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>

<!-- Phần tử ẩn chứa nội dung phiếu -->
<div style="display:none">
  <div id="print"></div>
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
            	$('#gvHoTen').val(data.gvHoTen);
            	$('#gvSDT').val(data.gvSDT);
            	$('#gvCCCD').val(data.gvCCCD);
            	$('#gvDiaChi').val(data.gvDiaChi);
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
	$('#gvHoTen').val('');
	$('#gvSDT').val('');
	$('#gvCCCD').val('');
	$('#gvDiaChi').val('');
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
            	$('#khHoTen').val(data.khHoTen);
            	$('#khSDT').val(data.khSDT);
            	$('#khCCCD').val(data.khCCCD);
            	$('#khDiaChi').val(data.khDiaChi);
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
	$('#khHoTen').val('');
	$('#khSDT').val('');
	$('#khCCCD').val('');
	$('#khDiaChi').val('');
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

/********** xu ly in ***************/

function InPhieuThu(id,nhap) {
    $.ajax({
        type: 'POST',
        url: '/thuexe/phieu-thu/get-phieu-in-ajax?id=' + id + '&nhap=' + nhap,
        success: function (data) {
            if (data.status === 'success') {
                $('#print').html(data.content);
                //printPhieuXuat(); // Gọi hàm in phiếu
				printPhieu();
                // Khi in xong, cập nhật số lần in
                if(nhap == 0){//in thật
                    setTimeout(function() {
                        updatePrintCount(id);
                    }, 1000); // Đợi 1 giây sau khi in để cập nhật
                }
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
function updatePrintCount(id) {
    $.ajax({
        type: 'POST',
        url: '/thuexe/phieu-thu/update-print-count?id='+id,
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
}
</script>
