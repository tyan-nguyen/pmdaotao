<?php

use yii\widgets\DetailView;
use app\custom\CustomFunc;

/* @var $this yii\web\View */
/* @var $model app\modules\thuexe\models\DonViSoHuu */
?>
<div class="don-vi-so-huu-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'ten_don_vi',
            [
                'label' => 'Số lượng xe trực thuộc',
                'format' => 'raw',
                'value' => count($model->xes) . ' xe',
            ],
            'ghi_chu:ntext',
            [
                'attribute' => 'thoi_gian_tao',
                'value' => CustomFunc::convertYMDHISToDMYHIS($model->thoi_gian_tao),
            ],
        ],
    ]) ?>

</div>
