<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\giaovien\models\Day */
?>
<div class="day-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_nhan_vien',
            'id_hang_xe',
            'ly_thuyet',
            'thuc_hanh',
            'nguoi_tao',
            'thoi_gian_tao',
        ],
    ]) ?>

</div>
