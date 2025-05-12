<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\daotao\models\DmThoiGian */
?>
<div class="dm-thoi-gian-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'ten_thoi_gian',
            'stt',
            'thoi_gian_bd',
            'thoi_gian_kt',
            'ghi_chu:ntext',
            'nguoi_tao',
            'thoi_gian_tao',
        ],
    ]) ?>

</div>
