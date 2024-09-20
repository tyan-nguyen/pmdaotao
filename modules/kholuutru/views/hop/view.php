<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\kholuutru\models\Hop */
?>
<div class="hop-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_ngan',
            'ten_hop',
            'nguoi_tao',
            'thoi_gian_tao',
        ],
    ]) ?>

</div>
