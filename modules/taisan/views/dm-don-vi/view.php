<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\taisan\models\DmDonVi */
?>
<div class="dm-don-vi-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'code',
            'ten',
            'co_sua_chua',
            'co_ban_hang',
            'ghi_chu:ntext',
            'stt',
            'nguoi_tao',
            'thoi_gian_tao',
        ],
    ]) ?>

</div>
