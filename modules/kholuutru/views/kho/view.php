<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\kholuutru\models\Kho */
?>
<div class="kho-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'ten_kho',
            'so_do_kho',
            'nguoi_tao',
            'thoi_gian_tao',
        ],
    ]) ?>

</div>
