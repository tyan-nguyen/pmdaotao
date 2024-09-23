<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\khoahoc\models\HangDaoTao */
?>
<div class="hang-dao-tao-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'ten_hang',
            'ghi_chu:ntext',
            'nguoi_tao',
            'thoi_gian_tao',
        ],
    ]) ?>

</div>
