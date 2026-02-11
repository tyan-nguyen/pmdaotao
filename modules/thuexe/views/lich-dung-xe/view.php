<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\thuexe\models\LichDungXe */
?>
<div class="lich-dung-xe-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_xe',
            'id_nguoi_phu_trach',
            'id_tai_xe',
            'noi_dung:ntext',
            'thoi_gian_bat_dau',
            'thoi_gian_ket_thuc',
            'so_gio',
            'trang_thai',
            'ghi_chu:ntext',
            'nguoi_tao',
            'thoi_gian_tao',
        ],
    ]) ?>

</div>
