<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\kholuutru\models\LoaiFile */
?>
<div class="loai-file-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'loai',
            'ho_so_bat_buoc',
            'ghi_chu:ntext',
            'nguoi_tao',
            'thoi_gian_tao',
            'doi_tuong',
        ],
    ]) ?>

</div>
