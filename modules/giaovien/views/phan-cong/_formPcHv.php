<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\modules\giaovien\models\GiaoVien;
use app\modules\thuexe\models\Xe;
use app\modules\daotao\models\GvXe;
use app\modules\daotao\models\GvHv;

?>

<link href="/js/datatables/datatables.min.css" rel="stylesheet">
<script src="/js/datatables/datatables.min.js"></script>
<div class="row">
    <div class="col-xl-12 col-md-12 col-sm-12 mb-4">
        <fieldset id="fs-search" class="fs-custom">
            <div class="search">
            	<table>
            		<tr>
            			
            			<th>Họ và tên</th>
            			<th>Mã học viên</th>
            			<th>Số điện thoại</th>
            		</tr>
            		<tr>
            			<td>
            				<input id="txtHoTen" type="text" class="form-control-sm" placeholder="Họ và tên" />
            			</td>
            			<td>
            				<input id="txtCCCD" type="text" class="form-control-sm" placeholder="Mã học viên" />
            			</td>
            			<td>
            				<input id="txtSoDienThoai" type="text" class="form-control-sm" placeholder="Số điện thoại" />
            			</td>
            		</tr>
            	</table>
            </div>
        </fieldset>
    </div>
</div>

<?php $form = ActiveForm::begin(['action'=>'/giaovien/phan-cong/pc-hv?id='.$model->id . '&idKh='.$modelKhoaHoc->id]); ?>


<div class="row">
	<div class="col-md-12">
		<?= $form->errorSummary($model) ?>
	</div>
	<div class="col-md-12" style="display:none">
	<?= Html::textInput('GiaoVien[id]', $model->id, []) ?>
	</div>
	<div class="col-md-12">
        <table id="tblDsHv" class="table table-bordered table-hover">
            <thead style="font-weight: bold">
                <tr>
                	<td style="width:3%"><span id="s-all" style="cursor:pointer" >All</span>
                		<span id="us-all" style="cursor:pointer;display:none">xAll</span></td>
                	<td style="width:3%">STT</td>
                	<td style="width:12%">Mã học viên</td>
                	<td style="width:12%">Họ và tên</td>
                	<td style="width:20%">Hạng đăng ký</td>
                	<td style="width:17%">Số điện thoại</td>
                	<td style="width:30%">Giáo viên</td>
                	<td></td>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($modelKhoaHoc->hvHocViens as $indexHv=>$hv){
                    $selected = false;
                    $idGvHv = null;
                    if($model->hvs){
                        if(in_array($hv->id, $model->arrHvHuongDan)){
                            $selected = true;
                            $idGvHv = GvHv::find()->where(['id_giao_vien'=>$model->id, 'id_hoc_vien'=>$hv->id])->one();
                        }
                    }
                ?>
                <tr>
                	<td><?= Html::checkbox('GiaoVien[listHocVien]['.$hv->id.']', $selected, ['class'=>'chk','value'=>1]) ?></td>
                	<td style="text-align:center;vertical-align:middle"><?= $indexHv+1 ?></td>
                	<td style="text-align:center;vertical-align:middle"><?= $hv->so_cccd ?></td>
                	<td style="vertical-align:middle"><?= $hv->ho_ten ?></td>
                	<td style="vertical-align:middle"><?= $hv->hangDaoTao->ten_hang  ?></td>
                	<td style="vertical-align:middle"><?= $hv->so_dien_thoai  ?></td>
                	<td style="vertical-align:middle"></td>
                	<td><?= $selected?Html::a('<i class="fa-solid fa-circle-minus"></i> Hủy', '/giaovien/phan-cong/xoa-pc-hv?id='.$idGvHv->id.'&idKh='.$modelKhoaHoc->id, [
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

var table = new DataTable('#tblDsHv',{
	//paging: false,
    pageLength: 20,
    "language": {
        "sLengthMenu":    "Hiển thị _MENU_ dòng dữ liệu/trang",
        "sInfo":          "Hiển thị _START_ - _END_ của _TOTAL_ dữ liệu",
        "sSearch":        "<i class='fa-solid fa-magnifying-glass'></i>",
    }
});
$('#txtHoTen').on( 'keyup click', function () {
       table.columns(2).search(
       		$('#txtHoTen').val()
       ).draw();
});
$('#txtCCCD').on( 'keyup click', function () {
       table.columns(1).search(
       		$('#txtCCCD').val()
       ).draw();
}); 
$('#txtSoDienThoai').on( 'keyup click', function () {
       table.columns(4).search(
       		$('#txtSoDienThoai').val()
       ).draw();
});
</script>