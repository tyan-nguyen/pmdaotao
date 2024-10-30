<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\thuexe\models\LoaiXe */
?>
<div class="loai-xe-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'ten_loai_xe',
            'ghi_chu:ntext',
            'nguoi_tao',
            'thoi_gian_tao',
        ],
    ]) ?>

</div>
