<?php
use app\custom\CustomFunc;
use app\modules\user\models\User;
?>

<link href="/js/datatables/datatables.min.css" rel="stylesheet">
<script src="/js/datatables/datatables.min.js"></script>

<h3>Lịch sử tồn kho</h3>
<table id="tblTonKho" class="table table-striped table-hover">
<thead>
	<tr>
    	<th width="5%">STT</th>
    	<th width="8%">SL thay đổi</th>
    	<th width="8%">SL cũ</th>	
    	<th width="8%">SL mới</th>
    	<th width="20%">Ghi chú</th>
    	<th width="21%">Nhà cung cấp</th>
    	<th width="15%">Ngày thay đổi</th>
    	<th width="15%">Người thực hiện</th>
	</tr>
</thead>
<tbody>
<?php
foreach ($model as $index=>$history):
?>
<tr>
	<td><?= (++$index) ?></td>
	<td><?= $history->so_luong ?> <?= showIconUpDown($history->so_luong) ?></td>
	<td><?= $history->so_luong_cu ?></td>
	<td><?= $history->so_luong_moi ?></td>
	<td><?= $history->ghi_chu ?></td>
	<td><?= $history->nhaCungCap?$history->nhaCungCap->ten_nha_cung_cap:'' ?></td>
	<td><?= CustomFunc::convertYMDHISToDMYHI($history->thoi_gian_tao) ?></td>
	<td><?= User::findOne($history->nguoi_tao)?User::findOne($history->nguoi_tao)->username:'' ?></td>
</tr>

<?php endforeach; ?>
</tbody>
</table>

<?php 

function showIconUpDown($number){
    if($number < 0){
        return '<i class="fa-solid fa-down-long" style="color:red"></i>';
    } else {
        return '<i class="fa-solid fa-up-long" style="color:green"></i>';
    }
}

?>

<script>
var table = new DataTable('#tblTonKho',{
	//paging: false,
    pageLength: 20,
    "language": {
        "sLengthMenu":    "Hiển thị _MENU_ dòng dữ liệu/trang",
        "sInfo":          "Hiển thị _START_ - _END_ của _TOTAL_ dữ liệu",
        "sSearch":        "<i class='fa-solid fa-magnifying-glass'></i>",
    }
});
</script>