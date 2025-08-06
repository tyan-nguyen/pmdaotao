<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\modules\banhang\models\KhachHang;
use yii\web\JsExpression;
use app\modules\banhang\models\HoaDon;
use kartik\date\DatePicker;
use app\custom\CustomFunc;
use app\modules\user\models\User;
use app\modules\hocvien\models\HocVien;
use app\widgets\CardWidget;

/* @var $this yii\web\View */
/* @var $model app\modules\banhang\models\HoaDon */
/* @var $form yii\widgets\ActiveForm */

// Get default selected value (for update form)
$initValue = '';
if ($model->id_khach_hang) {
    $initValue = $model->khachHang ? $model->khachHang->ho_ten : '';
}
//process date/datetime
if($model->ngay_dat_hang == NULL)
    $model->ngay_dat_hang = date('Y-m-d');
$model->ngay_dat_hang = CustomFunc::convertYMDToDMY($model->ngay_dat_hang);
$model->ngay_giao_hang = CustomFunc::convertYMDToDMY($model->ngay_giao_hang);
?>

<div class="hoa-don-form">

    <?php $form = ActiveForm::begin(['action' => $model->isNewRecord?'':['/banhang/hoa-don-ban-hang/update', 'id'=>$model->id]]); ?>
	
	<?php CardWidget::begin(['title'=>'THÔNG TIN PHIẾU THU']) ?>
	
	<div class="row">
	
		<div class="col-md-2" style="display:none">
			<?= $form->field($model, 'loai_khach_hang')->dropDownList(HoaDon::getDmLoaiKhachHang(), ['prompt'=>'-Chọn-', 'id'=>'ddlLoaiKhachHang', 'disabled' => true]) ?>
		</div>
        <div class="col-md-3">
            <?php // $form->field($model, 'id_khach_hang')->textInput() ?>
            <?php 
        	   $khachHangLabel = $model->getAttributeLabel('id_khach_hang') . ' <a href="/banhang/khach-hang/create-popup" role="modal-remote-2" style="padding-left:10px;" title="Thêm khách hàng"><i class="fa-solid fa-square-plus"></i></a>';
        	   //'<a href="#" onclick="runFunc(0)" style="padding-left:10px;" title="Tải lại danh sách"><i class="fa-solid fa-retweet"></i></a>';
        	?>
        	<label><?= $model->loai_khach_hang == HoaDon::LOAI_KHACHLE ? $khachHangLabel : 'Khách hàng' ?></label>
            <?= $form->field($model, 'id_khach_hang')->widget(Select2::classname(), [
                //'data' => KhachHang::getList(),
                'initValueText' => $initValue, // This shows selected text on form load
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
        <div class="col-md-2">
            <label>Họ tên</label> <br/>
            <!-- <span id="khHoTen" style="font-weight:bold"><?= $model->khachHang ? $model->khachHang->ho_ten : '' ?></span> -->
            <?= Html::textInput('ho_ten', 
                ($model->khachHang ? $model->khachHang->ho_ten : ''), 
                ['id'=>'khHoTen', 'class'=>'form-control', 'disabled'=>true]) ?>
        </div>
        <div class="col-md-2">
            <label>Số điện thoại</label><br/>
            <!-- <span id="khSDT" style="font-weight:bold"><?= $model->khachHang ? $model->khachHang->so_dien_thoai : '' ?></span> -->
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
            <!-- <span id="khDiaChi" style="font-weight:bold"><?= $model->khachHang ? $model->khachHang->dia_chi : '' ?></span>-->
            <?= Html::textInput('khDiaChi', 
                ($model->khachHang ? $model->khachHang->dia_chi : ''), 
                ['id'=>'khDiaChi', 'class'=>'form-control', 'disabled'=>true]) ?>
        </div>
        <!-- <div class="col-md-1">
            <?= $form->field($model, 'so_don_hang')->textInput()->label('SĐH') ?>
        </div> -->
        <div class="col-md-1">
            <?= $form->field($model, 'so_vao_so')->textInput() ?>
        </div>
        <div class="col-md-1">
            <?= $form->field($model, 'nam')->textInput() ?>
        </div>
        <!-- 
        <div class="col-md-4">
            <?= $form->field($model, 'trang_thai')->textInput(['maxlength' => true]) ?>
        </div>
         -->
        <div class="col-md-2">
           <?= $form->field($model, 'ngay_dat_hang')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Chọn ngày  ...'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd/mm/yyyy',
                    'todayHighlight'=>true,
                    'todayBtn'=>true
                ]
            ]); ?>
        </div>
        <!-- 
        <div class="col-md-2">
           <?= $form->field($model, 'ngay_giao_hang')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Chọn ngày  ...'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd/mm/yyyy',
                    'todayHighlight'=>true,
                    'todayBtn'=>true
                ]
            ]); ?>
        </div>
        -->
        
        <!-- 
        <div class="col-md-4">
            <?= $form->field($model, 'ngay_xuat')->textInput() ?>
        </div>
         -->
        <div class="col-md-2">
            <?= $form->field($model, 'hinh_thuc_thanh_toan')->dropDownList(
                HoaDon::getDmHinhThucThanhToan(),
                //['prompt'=>'-Chưa chọn-']
            ) ?>
        </div>
         <!-- 
        <div class="col-md-4">
            <?= $form->field($model, 'so_lan_in')->textInput() ?>
        </div>
        -->
        <!-- 
        <div class="col-md-4">
            <?= $form->field($model, 'da_giao_hang')->checkbox() ?>
        </div>
        -->
        
        <!-- <div class="col-md-2">
            <?= $form->field($model, 'chi_phi_van_chuyen')->textInput() ?>
        </div> -->
        <div class="col-md-<?= (User::hasRole('Admin',true)?5:6) ?>">
            <?= $form->field($model, 'ghi_chu')->textInput() ?>
        </div>
         <?php if(User::hasRole('Admin',true)){?>
        <div class="col-md-1">
        	<label>&nbsp;</label>
            <?= $form->field($model, 'edit_mode')->checkbox() ?>
        </div>
        <?php } ?>
        <!-- 
        <div class="col-md-4">
            <?= $form->field($model, 'nguoi_tao')->textInput() ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'thoi_gian_tao')->textInput() ?>
        </div>
        -->
  
	</div>
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>
	
	
	<?php CardWidget::end() ?>

    <?php ActiveForm::end(); ?>
    
    
<?php if(!$model->isNewRecord){?>

<?php CardWidget::begin(['title'=>'CHI TIẾT PHIẾU THU']) ?>
    
<div id="objHoaDonChiTiet" style="margin-top:10px;">
    <div class="row">
    	<div class="col-xs-12 table-responsive">
        	<div class="box">
        		<!-- <div class="box-header">
        			<h3 class="box-title">CHI TIẾT HÓA ĐƠN</h3>
        		</div> -->
        		<div class="box-body no-padding">
        			<!-- <button type="button" onClick="AddVatTu()">Thêm vật tư</button> -->
        			
        			<!-- ..............here------------------------- -->
        			<form id="idForm" method="post" action="/banhang/hoa-don-chi-tiet/save?id=<?= $model->id ?>">
                		<table id="vtTable" class="table table-striped">
                			<thead>
                				<tr>
                					<th style="width:3%">STT</th>
                					<th style="width:10%">Loại hàng hóa</th>
                					<th style="width:17%">Tên hàng hóa</th>
                					<th style="width:9%">ĐVT</th>			
                					<th style="width:9%">Số lượng</th>
                					<th style="width:9%">Đơn giá(VND)</th>
                					<th style="width:9%">Chiết khấu(VND)</th>
                					<th style="width:9%">Thành tiền(VND)</th>
                					<!-- <th style="width:10%">Ghi chú</th>-->
                					<th style="width:15%"></th>
                				</tr>
                			</thead>
                    		<tbody>
                    			<tr :id="'tr' + result.id" v-for="(result, indexResult) in results.dsVatTu" :key="result.id">
                    				<td :id="'td' + indexResult">{{ (indexResult + 1) }}</td>
                    				<td>{{ result.tenLoaiHangHoa }}</td>
                    				<td>{{ result.tenHangHoa }}</td>
                    				<td>{{ result.dvt }}</td>
                    				<td style="text-align: right">{{ result.soLuong.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</td>
                    				<td style="text-align: right">{{ result.donGia.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</td>
                    				<td style="text-align: right">{{ result.chietKhau.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</td>
                    				<td style="text-align: right">{{ result.thanhTien!=null?result.thanhTien.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") : 0 }}</td>
                    				<!-- <td>{{ result.ghiChu }}</td> -->
								
									<td>
                    				<?php if($model->trang_thai==HoaDon::TRANGTHAI_NHAP || $model->edit_mode){ ?>
                    					<span class="lbtn-remove btn btn-primary btn-sm" v-on:click="editVT(indexResult, 0)"><i class="fa fa-edit"></i> Sửa</span>
                    					<span class="lbtn-remove btn btn-danger btn-sm" v-on:click="deleteVT(result.id)"><i class="fa fa-trash"></i> Xóa</span>
                    					<?php } ?> 
                    					
                    			<?php /*if($model->trang_thai!='BAN_NHAP' && $model->edit_mode==1){ ?>
                    					<span class="lbtn-remove btn btn-default btn-xs" v-on:click="editVT(indexResult, 1)"><i class="fa fa-edit"></i> Sửa</span>
                    					<?php }*/ ?>                        					
                    					
                    				</td>
                    			</tr>
                    		</tbody>
                    		 <tfoot>
                				<tr>
                                  	<th colspan="7" style="text-align: right">Tổng cộng(VND)</th>
                					<th style="text-align: right"><span style="font-weight:bold">{{ results.tongTien!=null?results.tongTien.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") : 0 }}</span></th>
                					<th></th>
                					<!-- <th style="width:10%">Ghi chú</th>-->
                                </tr>

                              </tfoot>
                		</table>
                    	
                    	</form>
                </div>
            </div>
    	</div>
    </div>
</div><!-- end #obj -->

<?php if($model->trang_thai=='BAN_NHAP' || $model->edit_mode){ ?>
<a href="#" onClick="AddVatTu()" class="btn btn-primary btn-sm"><i class="fa-solid fa-plus"></i> Thêm hàng hóa</a>
<?php } ?>
<a href="#" onClick="InHoaDon()" class="btn btn-primary btn-sm"><i class="fa fa-print"></i> In Phiếu thu (<span id="soLanIn"><?= $model->so_lan_in ?? 0 ?></span>)</a>
<?php if($model->trang_thai == 'BAN_NHAP') { ?>
<a class="btn btn-primary btn-sm" href="/banhang/hoa-don-ban-hang/xuat-va-thanh-toan?id=<?= $model->id ?>" role="modal-remote"><i class="fa-solid fa-file-export"></i> Xuất và thanh toán</a>
<?php } ?>


<?php CardWidget::end() ?>

<?php } else { //end if isNewRecord ?>

<?php CardWidget::begin(['title'=>'CHI TIẾT PHIẾU THU']) ?>
<span class="text-success">Vui lòng lưu thông tin KHÁCH HÀNG trước để nhập chi tiết hàng hóa!</span>
<?php CardWidget::end() ?>

<?php }//end else if isNewRecord?>

<div style="display:none">
    <div id="printHD">
    <?= $model->isNewRecord ? '' : $this->render('_print_phieu', compact('model')) ?>
    </div>
</div>

    
</div>

<script type="text/javascript">
var vue1 = new Vue({
	el: '#objHoaDonChiTiet',
	data: {
		results: <?= json_encode($model->dsHangHoa()) ?>
	},
	methods: {
		editVT: function (indexResult) {
          editVatTu(this.results.dsVatTu[indexResult]);
        },
        deleteVT: function (id) {
            var result = confirm("Xác nhận xóa hàng hóa khỏi hóa đơn?");
            if (result) {
                deleteVatTu(id);
            }          
        }
	},
	computed: {
	}
});

function deleteVatTu(id){
	$.ajax({
        type: 'post',
        url: '/banhang/hoa-don-chi-tiet/delete-vat-tu?id=' + id,
        //data: frm.serialize(),
        success: function (data) {
            console.log('Submission was successful.');
            console.log(data);            
            if(data.status == 'success'){
            	vue1.results = data.results;
            } else if(data.status == 'error'){
            	alert(data.message);
            }
        },
        error: function (data) {
            console.log('An error occurred.');
            console.log(data);
        },
    });
}

function AddVatTu(){
	var formRow = '<tr id="idTr">';
	formRow += '<td>STT</td>';
	formRow += '<td><div style="display:none"><input type="text" name="loaiVatTu" id="lvtNew" value="VAT-TU" /></div><span id="loaiVatTuNew">Loại hàng hóa</span></td>';
	formRow += '<td><select id="idVatTuAdd" name="idVatTu" required></select></td>';
	formRow += '<td><span id="donViTinhNew">Đơn vị tính</span></td>';
	formRow += '<td><input type="text" name="soLuong" id="soLuongNew" required style="width:80px"/></td>';	
	formRow += '<td><input type="text" name="donGia" id="donGiaNew" required style="width:80px"/></td>';
	formRow += '<td><input type="text" name="chietKhau" id="chietKhauNew" style="width:80px"/></td>';
	formRow += '<td><span id="thanhTienNew">Thành tiền</span></td>';
	//formRow += '<td><input type="text" name="ghiChu" /></td>';
	formRow += '<td><button type="submit" form="idForm" value="Submit" class="lbtn-remove btn btn-warning btn-sm"><i class="fa-solid fa-database"></i> Lưu</button> <span class="lbtn-remove btn btn-secondary btn-sm" onClick="remove()"><i class="fa-solid fa-xmark"></i> Bỏ qua</span></td>';
	formRow += '</tr>';
    
    if($('#idTr').length <= 0){
    	$('#vtTable tbody').append(formRow);
    	
    	//fill dropdown vat tu
    	fillVatTuDropDown('#idVatTuAdd', '');
    	
    	$('#idVatTuAdd').select2({
    		dropdownParent: $('#ajaxCrudModal'),
          	selectOnClose: true,
          	width: '100%'
        });
        $('#idVatTuAdd').on("select2:select", function(e) { 
           //alert(this.value);
           getVatTuAjax(this.value);
        });
        //focus and open select 2
       // $('#idVatTuAdd').select2('focus');
       // $('#idVatTuAdd').select2('open');
        
        
        $("#soLuongNew").on("input", function() {
          // alert($(this).val()); 
           $('#thanhTienNew').text(($(this).val()*$('#donGiaNew').val()-$('#chietKhauNew').val()).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        });
        $("#donGiaNew").on("input", function() {
           //alert($(this).val()); 
           $('#thanhTienNew').text(($(this).val()*$('#soLuongNew').val()-$('#chietKhauNew').val()).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        });
        $("#chietKhauNew").on("input", function() {
           $('#thanhTienNew').text(($('#donGiaNew').val()*$('#soLuongNew').val()-$(this).val()).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        });
        /*$("#thanhTienNew").on("input", function() {
           $('#thanhTienNew').text(($(this).val()*$('#soLuongNew').val()-$('#chietKhauNew').val()).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        });*/
    } else {
    	alert('Vui lòng lưu dữ liệu đang nhập trước!');
    }
}

function editVatTu(arr){
	if ($("#idTrUpdate").length > 0){
		alert('Bạn đang chỉnh sửa chi tiết hàng hóa, vui lòng lưu dữ liệu hoặc hủy bỏ để tránh sai số, nhầm lẫn!');
	} else {
    	//alert(arr['slyc']);
    	var formRow = '<tr id="idTrUpdate">';
    	formRow += '<td><input type="text" name="id" value="' + arr['id'] + '" style="display:none" />'+ arr['id'] +'</td>';
    	formRow += '<td>'+ arr['loaiVatTu'] +'</td>';
    	formRow += '<td>'+ arr['tenVatTu'] +'</td>';
    	//formRow += '<td><select id="idVatTuEdit" name="idVatTu"></select></td>';
    	formRow += '<td>'+ arr['dvt'] +'</td>';
    	formRow += '<td><input type="text" name="soLuong" value="' + (arr['loaiVatTu']=='NHOM' ? arr['soLuongCayNhom'] : arr['soLuong'] ) + '" id="soLuongEdit" required  style="width:80px"/></td>';    		
    	formRow += '<td><input type="text" name="donGia" value="' + arr['donGia'] + '" id="donGiaEdit" required  style="width:80px"/></td>';
    	formRow += '<td><input type="text" name="chietKhau" value="' + arr['chietKhau'] + '" id="chietKhauEdit"  style="width:80px"/></td>';
    	formRow += '<td><span id="thanhTienEdit">'+ arr['thanhTien'].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") +' </span></td>';
    	/*formRow += '<td><span id="chietKhauEdit">'+ arr['chietKhau'].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") +' </span></td>';*/
    	//formRow += '<td><input type="text" name="ghiChu" value="' + arr['ghiChu'] + '" /></td>';
    	formRow += '<td><button type="submit" form="idForm" value="Submit" class="lbtn-remove btn btn-warning btn-sm"><i class="fa-solid fa-database"></i> Lưu</button> <span class="lbtn-remove btn btn-secondary btn-sm" onClick="removeEdit()"><i class="fa-solid fa-xmark"></i> Bỏ qua</span> </td>';
    	formRow += '</tr>';
    	
    	$('#tr' + arr['id']).hide();
    	$('#tr' + arr['id']).after(formRow);
    	
    	$('#idTrUpdate input[name="slyc"]').focus();
    	$('#idTrUpdate input[name="slyc"]').select();
    	
    	//fill dropdown vat tu
    	//fillVatTuDropDown('#idVatTuEdit', arr['idVatTu']);
    	/* $('#idVatTuEdit').select2({
          placeholder: 'Select an option',
           width: '100%'
        }); */

        $("#soLuongEdit").on("input", function() {
           $('#thanhTienEdit').text(($(this).val()*$('#donGiaEdit').val()-$('#chietKhauEdit').val()).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
           });
       $("#donGiaEdit").on("input", function() {
           //alert($(this).val()); 
           $('#thanhTienEdit').text(($(this).val()*$('#soLuongEdit').val()-$('#chietKhauEdit').val()).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
       
        });
        $("#chietKhauEdit").on("input", function() {
           $('#thanhTienEdit').text(($('#donGiaEdit').val()*$('#soLuongEdit').val()-$(this).val()).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
		});

	}
}

function removeEdit(){
	if ($("#idTrUpdate").length > 0){
		$('#idTrUpdate').prev("tr").show();
		$('#idTrUpdate').remove();
	}
}

function remove(){
	if ($("#idTr").length > 0){
		$('#idTr').remove();
	}
}

var frm = $('#idForm');

frm.submit(function (e) {

    e.preventDefault();
    $.ajax({
        type: frm.attr('method'),
        url: frm.attr('action'),
        data: frm.serialize(),
        success: function (data) {
            console.log('Submission was successful.');
            console.log(data);
            if(data.status == 'success'){
                if(data.type=='create'){
                	$('#idTr').remove();
                } else if(data.type == 'update'){
                	$('#idTrUpdate').remove();
                	$('#tr' + data.vatTuXuat['id']).show();
                }
                vue1.results = data.results
            } else if(data.status == 'error'){
            	alert(data.message);
            }
        },
        error: function (data) {
            console.log('An error occurred.');
            console.log(data);
        },
    });
});

function fillVatTuDropDown(dropdownId, selected){

    $.ajax({
        type: 'post',
        url: '/banhang/hoa-don-chi-tiet/get-list-vat-tu?selected=' + selected,
        //data: frm.serialize(),
        success: function (data) {
            console.log('Submission was successful.');
            console.log(data);            
            $(dropdownId).html(data.options);
        },
        error: function (data) {
            console.log('An error occurred.');
            console.log(data);
        },
    });
}

function getVatTuAjax(idvt){
    $.ajax({
        type: 'post',
        url: '/banhang/hoa-don-chi-tiet/get-vat-tu-ajax?idvt=' + idvt,
        //data: frm.serialize(),
        success: function (data) {
            console.log('Submission was successful.');
            console.log(data);            
            if(data.status == 'success'){
            	$('#idTr #donGiaNew').val(data.donGia);
            	$('#idTr #loaiVatTuNew').text(data.loaiVatTu);
            	$('#idTr #donViTinhNew').text(data.dvt);
            	$('#idTr #soLuongNew').val(1);
            	//set thanh tien
            	$('#thanhTienNew').text(($('#soLuongNew').val()*$('#donGiaNew').val()).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            } else {
            	alert('Vật tư không còn tồn tại trên hệ thống!');
            }
        },
        error: function (data) {
            console.log('An error occurred.');
            console.log(data);
        },
    });
}

function fillNhomDropDown(dropdownId, selected){

    $.ajax({
        type: 'post',
        url: '/banhang/hoa-don-chi-tiet/get-list-nhom?selected=' + selected,
        //data: frm.serialize(),
        success: function (data) {
            console.log('Submission was successful.');
            console.log(data);            
            $(dropdownId).html(data.options);
        },
        error: function (data) {
            console.log('An error occurred.');
            console.log(data);
        },
    });
}

function getNhomAjax(idvt){
    $.ajax({
        type: 'post',
        url: '/banhang/hoa-don-chi-tiet/get-nhom-ajax?idvt=' + idvt,
        //data: frm.serialize(),
        success: function (data) {
            console.log('Submission was successful.');
            console.log(data);            
            if(data.status == 'success'){
            	$('#idTr #donGiaNew').val(data.donGia);
            	$('#idTr #loaiVatTuNew').text(data.loaiVatTu);
            	$('#idTr #donViTinhNew').text(data.dvt);
            	$('#idTr #soLuongNew').val(1);
            	//set thanh tien
            	$('#thanhTienNew').text(($('#soLuongNew').val()*$('#donGiaNew').val()).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            } else {
            	alert('Vật tư không còn tồn tại trên hệ thống!');
            }
        },
        error: function (data) {
            console.log('An error occurred.');
            console.log(data);
        },
    });
}

function InHoaDon(){
	//load lai phieu in (tranh bi loi khi chinh sua du lieu chua update noi dung in)
	$.ajax({
        type: 'post',
        url: '/banhang/hoa-don-ban-hang/get-phieu-xuat-kho-in-ajax?idHoaDon=' + <?= $model->id?$model->id:"''" ?>,
        //data: frm.serialize(),
        success: function (data) {
            console.log('Submission was successful.');
            console.log(data);            
            if(data.status == 'success'){
            	$('#printHD').html(data.content);
            	printHoaDon();//call from script.js
            	setTimeout(function() {
                    updatePrintCount(<?= $model->id?$model->id:"''" ?>);
                }, 1000); // Đợi 1 giây sau khi in để cập nhật
            } else {
            	alert('Vật tư không còn tồn tại trên hệ thống!');
            }
        },
        error: function (data) {
            console.log('An error occurred.');
            console.log(data);
        },
    });	
}
// Hàm cập nhật số lần in
function updatePrintCount(id) {
    $.ajax({
        type: 'POST',
        url: '/banhang/hoa-don-ban-hang/update-print-count?id='+id,
        success: function (response) {
            if (response.success) {
                $('#soLanIn').text(response.so_lan_in); // Cập nhật số lần in
            } else {
                alert('Cập nhật số lần in thất bại!');
            }
        },
        error: function () {
            alert('Lỗi kết nối server!');
        }
    });
}







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
            	$('#khDiaChi').val(data.khDiaChi);
            	$('#khCCCD').val(data.khCCCD);
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
	$('#khDiaChi').val('');
	$('#khCCCD').val('');
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
