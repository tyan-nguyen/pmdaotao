<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\modules\giaovien\models\GiaoVien;
use app\modules\thuexe\models\Xe;
use app\modules\daotao\models\GvXe;

$xes = Xe::find()->all();
?>

<link href="/js/datatables/datatables.min.css" rel="stylesheet">
<script src="/js/datatables/datatables.min.js"></script>
<div class="row">
    <div class="col-xl-12 col-md-12 col-sm-12 mb-4">
        <fieldset id="fs-search" class="fs-custom">
            <div class="search">
            	<table>
            		<tr>
            			
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

<?php $form = ActiveForm::begin(['action'=>'/giaovien/phan-cong/pc-xe?id='.$model->id]); ?>


<div class="row">
	<div class="col-md-12">
		<?= $form->errorSummary($model) ?>
	</div>
	<div class="col-md-12" style="display:none">
	<?= Html::textInput('GiaoVien[id]', $model->id, []) ?>
	</div>
	<div class="col-md-12">
        <table id="tblDsXe" class="table table-bordered table-hover">
            <thead style="font-weight: bold">
                <tr>
                	<td style="width:3%"><span id="s-all" style="cursor:pointer" >All</span>
                		<span id="us-all" style="cursor:pointer;display:none">xAll</span></td>
                	<td style="width:3%">STT</td>
                	<td style="width:12%">Loại xe</td>
                	<td style="width:20%">Biển số</td>
                	<td style="width:17%">Người quản lý</td>
                	<td style="width:30%">Người sử dụng</td>
                	<td></td>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($xes as $indexXe=>$xe){
                    $selected = false;
                    $idGvXe = null;
                    if($model->xes){
                        if(in_array($xe->id, $model->arrXeDuocSuDung)){
                            $selected = true;
                            $idGvXe = GvXe::find()->where(['id_giao_vien'=>$model->id, 'id_xe'=>$xe->id])->one();
                        }
                    }
                ?>
                <tr>
                	<td><?= Html::checkbox('GiaoVien[listXe]['.$xe->id.']', $selected, ['class'=>'chk','value'=>1]) ?></td>
                	<td style="text-align:center;vertical-align:middle"><?= $indexXe+1 ?></td>
                	<td style="text-align:center;vertical-align:middle"><?= $xe->loaiXe->ten_loai_xe ?></td>
                	<td style="vertical-align:middle"><?= $xe->bien_so_xe ?></td>
                	<td style="vertical-align:middle"><?= $xe->giaoVien?$xe->giaoVien->ho_ten:''  ?></td>
                	<td style="vertical-align:middle"></td>
                	<td><?= $selected?Html::a('<i class="fa-solid fa-circle-minus"></i> Hủy', '/giaovien/phan-cong/xoa-pc-xe?id='.$idGvXe->id, [
                	    'role'=>'modal-remote',
                	    'style'=>'color:red'
                	]):'' ?></td>
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
	 $(this).hide();
	$('#us-all').show();
});
$('#us-all').on('click', function(){
	 $('.chk').removeAttr('checked');
	 $(this).hide();
	$('#s-all').show();
});

var table = new DataTable('#tblDsXe',{
	//paging: false,
    pageLength: 20,
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