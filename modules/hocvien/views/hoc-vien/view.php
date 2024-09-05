<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\HvHocVien */
?>
<div class="hv-hoc-vien-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_khoa_hoc',
            'ho_ten',
            'so_dien_thoai',
            'so_cccd',
            'dia_chi',
            'id_hang',
            'trang_thai',
            'nguoi_tao',
            'thoi_gian_tao',
        ],
    ]) ?>

</div>
