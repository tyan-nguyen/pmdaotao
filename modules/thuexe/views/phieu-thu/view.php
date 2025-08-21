<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\thuexe\models\PhieuThu */
?>
<style>
#table-content tr td{
    border: 1px solid #212121;
}
.phieu-h1{
     font-size:35px;
     font-weight:bold;
}
#table-noi-dung tr td{
    text-align:left;
}
</style>
<div class="phieu-thu-view">
 	
 	<!-- Phần tử ẩn chứa nội dung phiếu -->
    <div style="display:block">
      <div id="print"></div>
    </div>

	<!-- 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_lich_thue',
            'loai_phieu',
            'so_tien',
            'chiet_khau',
            'so_tien_con_lai',
            'ma_so_phieu',
            'so_lan_in_phieu',
            'hinh_thuc_thanh_toan',
            'nguoi_tao',
            'thoi_gian_tao',
            'ghi_chu:ntext',
        ],
    ]) ?>
     -->

</div>

<script>
function InPhieuThu(id,nhap) {
    $.ajax({
        type: 'POST',
        url: '/thuexe/phieu-thu/get-phieu-in-ajax?id=' + id + '&nhap=' + nhap,
        success: function (data) {
            if (data.status === 'success') {
                $('#print').html(data.content);
                //printPhieuXuat(); // Gọi hàm in phiếu
				//printPhieu();
                // Khi in xong, cập nhật số lần in
                //if(nhap == 0){//in thật
                //    setTimeout(function() {
                //        updatePrintCount(id);
                //    }, 1000); // Đợi 1 giây sau khi in để cập nhật
               // }
            } else {
                alert('Không thể tải phiếu!');
            }
        },
        error: function () {
            alert('Đã xảy ra lỗi.');
        }
    });
}
InPhieuThu(<?= $model->id ?>,0);
</script>
