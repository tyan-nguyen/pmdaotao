<?php

use yii\widgets\DetailView;
use yii\helpers\html;
/* @var $this yii\web\View */
/* @var $model app\modules\kholuutru\models\Kho */
?>
<div class="kho-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'ten_kho',
            [
                'attribute' => 'so_do_kho',
                        'label' => 'Sơ đồ kho',
                        'format' => 'html', 
                        'value' => function ($model) {
                            $imageUrl = Yii::$app->urlManager->createUrl($model->so_do_kho);
                            return Html::img($imageUrl, ['class' => 'img-thumbnail', 'style' => 'width:100px;height:100px;']);
                        },
                        'class' =>"img-fluid",
                        'data-target' =>"#businessLicenseModal",
            ],
            'nguoi_tao',
            'thoi_gian_tao',
        ],
    ]) ?>

</div>
