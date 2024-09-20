<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\kholuutru\models\Ke */
?>
<div class="ke-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_kho',
            'ten_ke',
            'nguoi_tao',
            'thoi_gian_tao',
        ],
    ]) ?>

</div>
