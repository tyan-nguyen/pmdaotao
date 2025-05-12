<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\daotao\models\TietHoc */
?>
<div class="tiet-hoc-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_ke_hoach',
            'id_hoc_vien',
            'id_giao_vien',
            'id_xe',
            'id_mon_hoc',
            'id_thoi_gian_hoc',
            'so_gio',
            'thoi_gian_bd',
            'thoi_gian_kt',
            'ghi_chu:ntext',
            'trang_thai',
            'trang_thai_duyet',
            'ngay_duyet',
            'id_nguoi_duyet',
            'nguoi_tao',
            'thoi_gian_tao',
        ],
    ]) ?>

</div>
