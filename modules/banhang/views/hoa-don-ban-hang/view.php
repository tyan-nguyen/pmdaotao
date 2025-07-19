<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\banhang\models\HoaDon */
?>
<div class="hoa-don-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_khach_hang',
            'so_don_hang',
            'so_vao_so',
            'nam',
            'trang_thai',
            'ngay_dat_hang',
            'ngay_xuat',
            'hinh_thuc_thanh_toan',
            'so_lan_in',
            'da_giao_hang',
            'ngay_giao_hang',
            'chi_phi_van_chuyen',
            'ghi_chu:ntext',
            'nguoi_tao',
            'thoi_gian_tao',
        ],
    ]) ?>

</div>
