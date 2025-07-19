<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\banhang\models\DVT */
?>
<div class="dvt-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'ten_dvt',
            'ghi_chu:ntext',
            'nguoi_tao',
            'thoi_gian_tao',
        ],
    ]) ?>

</div>
