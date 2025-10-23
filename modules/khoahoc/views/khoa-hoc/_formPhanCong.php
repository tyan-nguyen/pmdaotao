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
            			<th>Mã số</th>
            			<th>Họ tên</th>
            			<th>Địa chỉ</th>
            			<th>GVHD</th>
            		</tr>
            		<tr>
            			<td>
            				<input id="txtMaSo" type="text" class="form-control-sm" placeholder="Mã số" />
            			</td>
            			<td>
            				<input id="txtHoTen" type="text" class="form-control-sm" placeholder="Họ tên" />
            			</td>
            			<td>
            				<input id="txtDiaChi" type="text" class="form-control-sm" placeholder="Địa chỉ" />
            			</td>
            			<td>
            				<?= Html::dropDownList('GiaoVien', null, GiaoVien::getListName(), ['id'=>'ddlGiaoVien', 'class'=>'form-control-sm', 'prompt'=>'-Chọn-']) ?>
            			</td>
            		</tr>
            	</table>
            </div>
        </fieldset>
    </div>
</div>

<?php $form = ActiveForm::begin(); ?>
<div class="row">
	<div class="col-md-2">
		<?= $form->field($model, 'idGiaoVien')->dropDownList(GiaoVien::getList(), ['prompt'=>'-Chọn giáo viên-']) ?>
		
	</div>
	<div class="col-md-10">
        <table id="tblDsHocVien" class="table table-bordered table-hover">
            <thead style="font-weight: bold">
                <tr>
                	<td style="width:3%"><span id="s-all" style="cursor:pointer" >All</span></td>
                	<td style="width:3%">STT</td>
                	<td style="width:12%">Mã học viên</td>
                	<td style="width:20%">Tên học viên</td>
                	<td style="width:17%">Ngày sinh</td>
                	<td style="width:30%">Địa chỉ</td>
                	<td style="width:20%">GVHD</td>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($model->hvHocViens as $indexHocVien=>$hocVien){
                ?>
                <tr>
                	<td><?= Html::checkbox('KhoaHoc[listIdHocVien]['.$hocVien->id.']', false, ['class'=>'chk','value'=>1, 'disabled'=>$hocVien->id_giao_vien != null]) ?></td>
                	<td style="text-align:center;vertical-align:middle"><?= $indexHocVien+1 ?></td>
                	<td style="text-align:center;vertical-align:middle"><?= $hocVien->so_cccd ?></td>
                	<td style="vertical-align:middle"><?= $hocVien->ho_ten ?></td>
                	<td style="vertical-align:middle"><?= $hocVien->getNgaySinh()  ?></td>
                	<td style="vertical-align:middle"><?= $hocVien->diaChi ?></td>
                	<td style="vertical-align:middle"><?= $hocVien->giaoVien?$hocVien->giaoVien->ho_ten:'' ?></td>
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

var table = new DataTable('#tblDsHocVien',{
    pageLength: 10,
    "language": {
        "sLengthMenu":    "Hiển thị _MENU_ dòng dữ liệu/trang",
        "sInfo":          "Hiển thị _START_ - _END_ của _TOTAL_ dữ liệu",
        "sSearch":        "<i class='fa-solid fa-magnifying-glass'></i>",
    }
});
$('#txtMaSo').on( 'keyup click', function () {
       table.columns(2).search(
       		$('#txtMaSo').val()
       ).draw();
});
$('#txtHoTen').on( 'keyup click', function () {
       table.columns(3).search(
       		$('#txtHoTen').val()
       ).draw();
}); 
$('#txtDiaChi').on( 'keyup click', function () {
       table.columns(5).search(
       		$('#txtDiaChi').val()
       ).draw();
});
$('#ddlGiaoVien').on( 'keyup click', function () {
       table.columns(6).search(
       		$('#ddlGiaoVien').val()
       ).draw();
});
</script>