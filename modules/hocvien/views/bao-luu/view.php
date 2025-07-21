<?php
use app\widgets\CardWidget;
use app\custom\CustomFunc;
use yii\helpers\Html;
?>

<?php CardWidget::begin(['title'=>'Danh sách bảo lưu' ]) ?>

<div class="table-responsive border p-0 pt-3">
    <table class="table table-bordered mg-b-0">
        <thead>
            <tr style="font-weight:bold">
                <td width="50px" align="center">STT</td>
                <td align="center">Ngày</td>
                <td align="center">Ngày khai giảng</td>
                <td align="center">Ngày bắt đầu</td>   
                <td align="center">Ngày kết thúc</td>   
                <td align="center">Lý do</td>  
                <td align="center">Ghi chú</td>
                <td></td>  
            </tr>
        </thead>
        <tbody>
        <?php foreach ($model->baoLuus as $iBl=>$bl){
        ?>
        <tr>
    	<td><?= ($iBl+1) ?></td>
    	<td align="center"><strong><?= CustomFunc::convertYMDHISToDMYHI($bl->thoi_gian_tao) ?></strong></td>
    	
    	<td align="center"><?= CustomFunc::convertYMDToDMY($bl->ngay_khai_giang) ?></td>
    	<td align="center"><?= CustomFunc::convertYMDToDMY($bl->ngay_bat_dau) ?></td>
    	<td align="center"><?= CustomFunc::convertYMDToDMY($bl->ngay_ket_thuc) ?></td>    	
    	<td align="center"><strong><?= $bl->ly_do ?></strong></td>
    	<td align="center"><?= $bl->ghi_chu ?></td>
    	<td><?= Html::a('<i class="fas fa-pencil-alt"></i> Sửa', ['bao-luu/update', 'id'=>$bl->id], [
    	    'class' => 'btn btn-default btn-sm', 
    	    'role'=>'modal-remote-2'
    	   ]) ?>
    	    &nbsp;
    	    <?= Html::button('<i class="fa fa-print"></i> In', [
    	    'class' => 'btn btn-default btn-sm', 
    	    'onclick' => 'InPhieuBaoLuu('.$bl->id.')']) ?>
    	</td>
    </tr>
        <?php 
        }
        ?>

        </tbody>
    </table>
</div>
<?php CardWidget::end()?>

<!-- Phần tử ẩn chứa nội dung phiếu -->
<div style="display:none">
  <div id="printDoiHang"></div>
</div>

<script>
function InPhieuBaoLuu(id) {
    $.ajax({
        type: 'POST',
        url: '/hocvien/bao-luu/rp-bao-luu-print?id=' + id,
        success: function (data) {
            if (data.status === 'success') {
                $('#printDoiHang').html(data.content);
				printPhieuDoiHang();
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