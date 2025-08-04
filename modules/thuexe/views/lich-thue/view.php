<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\thuexe\models\LichThue */
?>
<div class="lich-thue-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'loai_giao_vien',
            'id_giao_vien',
            'loai_khach_hang',
            'id_khach_hang',
            'id_xe',
            'thoi_gian_bat_dau',
            'thoi_gian_ket_thuc',
            'so_gio',
            'don_gia',
            'trang_thai',
            'ghi_chu:ntext',
            'nguoi_tao',
            'thoi_gian_tao',
        ],
    ]) ?>

</div>
