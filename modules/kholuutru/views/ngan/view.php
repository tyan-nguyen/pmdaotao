<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\kholuutru\models\Ngan */
?>
<div class="ngan-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_ke',
            'ten_ngan',
            'nguoi_tao',
            'thoi_gian_tao',
        ],
    ]) ?>

</div>
