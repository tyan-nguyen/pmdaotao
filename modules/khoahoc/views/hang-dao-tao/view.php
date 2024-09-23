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
            [
                'attribute' => 'nguoi_tao',
                'value' => function($model) {
                    return $model->nguoi_tao = Yii::$app->user->identity->username;  
                },
                'label' => 'Người tạo',
            ],
            'thoi_gian_tao',
        ],
    ]) ?>

</div>
