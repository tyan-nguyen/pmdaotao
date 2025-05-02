<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\hocvien\models\NopHocPhi */
?>

<!-- <link href="/css/print-phieu.css?v=3" rel="stylesheet"> -->
<style>
#table-noi-dung tbody tr td{
    text-align: left;
}
#table-top tbody tr td:nth-child(2){
    text-align: left;
}
.phieu-h1{
font-weight: bold;
font-size:16pt;
margin:10px;
}
</style>

<div class="nop-hoc-phi-view">

<!-- Phần tử ẩn chứa nội dung phiếu -->
  <div style="display:block;">
      <div id="print">
      
      </div>
  </div>

<!--<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'id_hoc_vien',
        'id_hoc_phi',
        'loai_phieu',
        'loai_nop',
        'so_tien_nop',
        'chiet_khau',
        'so_tien_con_lai',
        'ngay_nop',
        'ma_so_phieu',
        'so_lan_in_phieu',
        'hinh_thuc_thanh_toan',
        'nguoi_thu',
        'bien_lai:ntext',
        'nguoi_tao',
        'thoi_gian_tao',
        'da_kiem_tra',
        'ghi_chu:ntext',
    ],
]) ?>-->

</div>

<script>
function InPhieuThu(id,nhap) {
    $.ajax({
        type: 'POST',
        url: '/hocvien/dang-ky-hv/get-phieu-in-ajax?id=' + id + '&type=phieuthu&' + '&nhap=' + nhap,
        success: function (data) {
            if (data.status === 'success') {
                $('#print').html(data.content);
                //printPhieuXuat(); // Gọi hàm in phiếu
				//printPhieu();
                // Khi in xong, cập nhật số lần in
                /*if(nhap == 0){//in thật
                    setTimeout(function() {
                        updatePrintCount(id);
                    }, 1000); // Đợi 1 giây sau khi in để cập nhật
                }*/
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
