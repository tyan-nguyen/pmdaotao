<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\modules\giaovien\models\GiaoVien;
?>

<link href="/js/datatables/datatables.min.css" rel="stylesheet">
<script src="/js/datatables/datatables.min.js"></script>
<div class="row">
	<div class="col-md-2"></div>
    <div class="col-xl-10 col-md-10 col-sm-12 mb-4">
        <fieldset id="fs-search" class="fs-custom">
            <div class="search">
            	<table>
            		<tr>
            			<th>STT</th>
            			<th>Loại xe</th>
            			<th>Biển số</th>
            			<th>Người quản lý</th>
            			<th>Người sử dụng</th>
            		</tr>
            		<tr>
            			<td>
            				<input id="txtLoaiXe" type="text" class="form-control-sm" placeholder="Loại xe" />
            			</td>
            			<td>
            				<input id="txtBienSo" type="text" class="form-control-sm" placeholder="Biển số" />
            			</td>
            			<td>
            				<input id="txtNguoiQuanLy" type="text" class="form-control-sm" placeholder="Người quản lý" />
            			</td>
            			<td>
            				<?= Html::dropDownList('GiaoVien', null, GiaoVien::getListName(), ['id'=>'ddlNguoiSuDung', 'class'=>'form-control-sm', 'prompt'=>'-Chọn-']) ?>
            			</td>
            		</tr>
            	</table>
            </div>
        </fieldset>
    </div>
</div>

<?php $form = ActiveForm::begin(); ?>
<div class="row">
	<div class="col-md-12">
		<?= $form->errorSummary($model) ?>
	</div>
	<div class="col-md-2">
		<?= $form->field($model, 'idGiaoVien')->dropDownList(GiaoVien::getList(), ['prompt'=>'-Chọn giáo viên-']) ?>
		
	</div>
	<div class="col-md-10">
        <table id="tblDsXe" class="table table-bordered table-hover">
            <thead style="font-weight: bold">
                <tr>
                	<td style="width:3%"><span id="s-all" style="cursor:pointer" >All</span></td>
                	<td style="width:3%">STT</td>
                	<td style="width:12%">Loại xe</td>
                	<td style="width:20%">Biển số</td>
                	<td style="width:17%">Người quản lý</td>
                	<td style="width:30%">Người sử dụng</td>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($model->hvHocViens as $indexHocVien=>$hocVien){
                ?>
                <tr>
                	<td><?= Html::checkbox('GiaoVien[listXe]['.$hocVien->id.']', false, ['class'=>'chk','value'=>1, 'disabled'=>$hocVien->id_giao_vien != null]) ?></td>
                	<td style="text-align:center;vertical-align:middle"><?= $indexHocVien+1 ?></td>
                	<td style="text-align:center;vertical-align:middle"><?= $hocVien->so_cccd ?></td>
                	<td style="vertical-align:middle"><?= $hocVien->ho_ten ?></td>
                	<td style="vertical-align:middle"><?= $hocVien->getNgaySinh()  ?></td>
                	<td style="vertical-align:middle"><?= $hocVien->dia_chi ?></td>
                </tr>
               <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php ActiveForm::end(); ?>

<script>
$('#s-all').on('click', function(){
	 $('.chk').not(":disabled").attr('checked','checked');

});

var table = new DataTable('#tblDsXe',{
    pageLength: 10,
    "language": {
        "sLengthMenu":    "Hiển thị _MENU_ dòng dữ liệu/trang",
        "sInfo":          "Hiển thị _START_ - _END_ của _TOTAL_ dữ liệu",
        "sSearch":        "<i class='fa-solid fa-magnifying-glass'></i>",
    }
});
$('#txtLoaiXe').on( 'keyup click', function () {
       table.columns(2).search(
       		$('#txtLoaiXe').val()
       ).draw();
});
$('#txtBienSo').on( 'keyup click', function () {
       table.columns(3).search(
       		$('#txtBienSo').val()
       ).draw();
}); 
$('#txtNguoiQuanLy').on( 'keyup click', function () {
       table.columns(4).search(
       		$('#txtNguoiQuanLy').val()
       ).draw();
});
$('#ddlNguoiSuDung').on( 'keyup click', function () {
       table.columns(5).search(
       		$('#ddlNguoiSuDung').val()
       ).draw();
});
</script>