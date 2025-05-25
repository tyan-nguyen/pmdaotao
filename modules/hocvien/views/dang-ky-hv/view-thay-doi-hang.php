<?php
use app\widgets\CardWidget;
use app\custom\CustomFunc;
use yii\helpers\Html;
?>

<?php CardWidget::begin(['title'=>'Danh sách thay đổi' ]) ?>

<div class="table-responsive border p-0 pt-3">
    <table class="table table-bordered mg-b-0">
        <thead>
            <tr style="font-weight:bold">
                <td width="50px" align="center">STT</td>
                <td align="center">Ngày</td>
                <td align="center">Lý do</td>
                <td align="center">Học phí cũ</td>
                <td align="center">Học phí mới</td>
                <td align="center">Số tiền thay đổi</td>     
                <td align="center">Ghi chú</td>
                <td></td>  
            </tr>
        </thead>
        <tbody>
        <?php foreach ($model->thayDoiHangs as $itdh=>$tdh){
        ?>
        <tr>
    	<td><?= ($itdh+1) ?></td>
    	<td align="center"><strong><?= CustomFunc::convertYMDHISToDMYHI($tdh->thoi_gian_thay_doi) ?></strong></td>
    	<td align="center"><strong><?= $tdh->ly_do ?></strong></td>
    	<td align="center"><?= number_format($tdh->hocPhiCu->hoc_phi) ?></td>
    	<td align="center"><?= number_format($tdh->hocPhiMoi->hoc_phi) ?></td>
    	<td align="center"><?= number_format($tdh->so_tien) ?></td>
    	<td align="center"><?= $tdh->ghi_chu ?></td>
    	<td><?= Html::button('<i class="fa fa-print"> </i> In', [
    	    'class' => 'btn btn-default', 
    	    'style'=>'width:100%', 
    	    'onclick' => 'InPhieuThayDoiHang('.$tdh->id.')']) ?>
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
function InPhieuThayDoiHang(id) {
    $.ajax({
        type: 'POST',
        url: '/hocvien/bao-cao/rp-bien-ban-thay-doi-hang-print?idbb=' + id,
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