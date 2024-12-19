<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\lichhoc\models\LichHoc */
?>
<div class="lich-hoc-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_khoa_hoc',
            'hoc_phan',
            'id_nhom',
            'id_phong',
            'id_giao_vien',
            'ngay',
            'thu',
            'tiet_bat_dau',
            'tiet_ket_thuc',
            'nguoi_tao',
            'thoi_gian_tao',
        ],
    ]) ?>

</div>
