<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\HvKhoaHoc */
?>
<div class="hv-khoa-hoc-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_hang',
            'ten_khoa_hoc',
            'ngay_bat_dau',
            'ngay_ket_thuc',
            'ghi_chu:ntext',
            'trang_thai',
            'nguoi_tao',
            'thoi_gian_tao',
        ],
    ]) ?>

</div>
