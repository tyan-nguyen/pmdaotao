<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\demxe\models\FileTrichXuat */
?>
<div class="file-trich-xuat-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'thoi_gian_tu',
            'thoi_gian_den',
            'filename',
            'url:url',
            'nguoi_tao',
            'thoi_gian_tao',
            'ghi_chu:ntext',
        ],
    ]) ?>

</div>
