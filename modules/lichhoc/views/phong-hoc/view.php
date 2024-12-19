<?php

use yii\widgets\DetailView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\lichhoc\models\PhongHoc */
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
                        'format' => 'html', 
                        'value' => function ($model) {
                            $imageUrl = Yii::$app->urlManager->createUrl($model->so_do_phong);
                            return Html::img($imageUrl, ['class' => 'img-thumbnail', 'style' => 'width:100px;height:100px;']);
                        },
                        'class' =>"img-fluid",
                        'data-target' =>"#businessLicenseModal",
            ],
            'ghi_chu:ntext',
            'nguoi_tao',
            'thoi_gian_tao',
        ],
    ]) ?>

</div>
