<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\taisan\models\PhieuDeNghi */
?>
<div class="phieu-de-nghi-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'loai_phieu',
            'loai_tai_san',
            'id_tham_chieu',
            'nguoi_de_nghi',
            'loai_yeu_cau',
            'so_km_luc_yeu_cau',
            'noi_dung_de_nghi:ntext',
            'ngay_bat_dau',
            'ngay_hoan_thanh',
            'trang_thai',
            'nguoi_duyet',
            'ngay_duyet',
            'ghi_chu_duyet:ntext',
            'phieu_co_chi_tiet',
            'tong_tien_du_kien',
            'tong_tien_thuc_te',
            'id_dot_tong_hop',
            'thoi_gian_tao',
            'nguoi_tao',
        ],
    ]) ?>

</div>
