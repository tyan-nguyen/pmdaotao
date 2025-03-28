<?php

use yii\widgets\DetailView;

$this->registerCssFile("https://cdnjs.cloudflare.com/ajax/libs/fancybox/4.0.31/fancybox.min.css");
$this->registerJsFile("https://cdnjs.cloudflare.com/ajax/libs/fancybox/4.0.31/fancybox.umd.min.js", ['depends' => [\yii\web\JqueryAsset::class]]);
?>

<div class="phong-hoc-view">
 
<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'ten_phong',
        [
            'attribute' => 'so_do_phong',
            'label' => 'Sơ đồ phòng',
            'format' => 'raw', 
            'value' => function ($model) {
                $imageUrl = Yii::$app->urlManager->createUrl($model->so_do_phong);
                return '
                <a href="'.$imageUrl.'" data-fancybox="gallery" data-caption="Sơ đồ phòng">
                    <img src="'.$imageUrl.'" class="img-thumbnail" style="width: 100px; height: 100px;">
                </a>';
            },
        ],
        'ghi_chu:ntext',
        'nguoi_tao',
        'thoi_gian_tao',
    ],
]) ?>

</div>

