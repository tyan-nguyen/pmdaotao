<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\modules\giaovien\models\GiaoVien;
use kartik\select2\Select2;
use app\custom\CustomFunc;
use app\modules\khoahoc\models\KhoaHoc;

$khoaHocs = KhoaHoc::find()->orderBy(['id'=>SORT_DESC])->all();
?>
<link href="/js/datatables/datatables.min.css" rel="stylesheet">
<script src="/js/datatables/datatables.min.js"></script>
<?php $form = ActiveForm::begin(); ?>

<?= $form->errorSummary($model) ?>

<table class="table table-bordered">
    <thead style="font-weight: bold">
        <tr>
        	<td>STT</td>
        	<td>Họ và tên</td>
        	<td>Số CCCD</td>
        	<td>Ngày sinh</td>
        	<td>Điện thoại</td>
        </tr>
    </thead>
    <tbody>
        <tr>
        	<td style="text-align:center;vertical-align:middle">1</td>
        	<td style="text-align:center;vertical-align:middle"><?= $model->ho_ten ?></td>
        	<td style="vertical-align:middle"><?= $model->so_cccd ?></td>
        	<td style="vertical-align:middle"><?= CustomFunc::convertYMDToDMY($model->ngay_sinh)  ?></td>
			<td style="vertical-align:middle"><?= $model->dien_thoai ?></td>
        </tr>
    </tbody>
</table>

<div class="row">
    <div class="col-xl-12 col-md-12 col-sm-12 mb-4">
        <fieldset id="fs-search" class="fs-custom">
            <div class="search">
            	<table>
            		<tr>
            			
            			<th>Năm</th>
            			<th></th>
            			<th></th>
            			<th></th>
            		</tr>
            		<tr>
            			<td><?= Html::dropDownList('Nam', null, ['2025'=>'2025','2026'=>'2026'], ['id'=>'ddlNam', 'class'=>'form-control-sm', 'prompt'=>'-Chọn-']) ?></td>
            			<td></td>
            			<td></td>
            			<td></td>
            		</tr>
            	</table>
            </div>
        </fieldset>
    </div>
</div>

<table id="tblDsKh" class="table table-bordered table-hover">
    <thead style="font-weight: bold">
        <tr>
        	<td>STT</td>
        	<td>Tên khóa học</td>
        	<td width="15%">Trạng thái</td>
        	<td>Số lượng</td>
        	<td>Ngày BĐ</td>
        	<td>Ngày KT</td>
        	<td width="20%"></td>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($khoaHocs as $indexKh=>$kh){
        ?>
        <tr>
        	<td style="text-align:center;vertical-align:middle"><?= $indexKh+1 ?></td>
        	<td style="text-align:left;vertical-align:middle"><?= $kh->ten_khoa_hoc ?></td>
        	<td style="vertical-align:middle"><?= $kh->tenTrangThai ?></td>
        	<td style="vertical-align:middle"><?= $kh->showSoLuong  ?></td>
        	<td style="vertical-align:middle"><?= CustomFunc::convertYMDToDMY($kh->ngay_bat_dau)  ?></td>
        	<td style="vertical-align:middle"><?= CustomFunc::convertYMDToDMY($kh->ngay_ket_thuc)  ?></td>
        	       	
        	<td><?= Html::a('<i class="fa-solid fa-up-right-from-square"></i> Vào phân công', [
        	    '/giaovien/phan-cong/pc-hv',
        	    'id'=>$model->id,
        	    'idKh'=>$kh->id
        	], [
        	    'role'=>'modal-remote',
        	    'style'=>'color:red'
        	]) ?></td>
        </tr>
       <?php } ?>
    </tbody>
</table>

<?php ActiveForm::end(); ?>

<script>

var table = new DataTable('#tblDsKh',{
	paging: false,
    //pageLength: 20,
    "language": {
        "sLengthMenu":    "Hiển thị _MENU_ dòng dữ liệu/trang",
        "sInfo":          "Hiển thị _START_ - _END_ của _TOTAL_ dữ liệu",
        "sSearch":        "<i class='fa-solid fa-magnifying-glass'></i>",
    }
});
$('#ddlNam').on( 'keyup click', function () {
       table.columns(1).search(
       		$('#ddlNam').val()
       ).draw();
});
</script>
