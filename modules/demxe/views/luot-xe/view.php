<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\demxe\models\DemXe */
?>
<div class="dem-xe-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_xe',
            'ma_xe',
            'ma_cong',
            'thoi_gian_bd',
            'thoi_gian_kt',
            'so_gio',
            'so_phut',
            'nguoi_tao',
            'thoi_gian_tao',
            'id_file',
            'ghi_chu:ntext',
        ],
    ]) ?>

</div>
