<?php

use yii\widgets\DetailView;
use yii\helpers\Html;

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
                    if ($model->so_do_kho) {
                        $imageUrl = Yii::$app->request->baseUrl . '/' . $model->so_do_kho;
                        return Html::a(
                            Html::img($imageUrl, ['class' => 'img-thumbnail', 'style' => 'width:100px;height:100px;']),
                            $imageUrl,
                            ['data-fancybox' => 'gallery', 'class' => 'img-fluid']
                        );
                    }
                    return null;
                },
            ],
            'nguoi_tao',
            'thoi_gian_tao',
        ],
    ]) ?>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    Fancybox.bind("[data-fancybox]", {}); // Đảm bảo Fancybox được kích hoạt sau khi load
});

</script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css" />
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>
