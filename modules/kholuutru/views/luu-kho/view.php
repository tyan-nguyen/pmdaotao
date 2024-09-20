<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\kholuutru\models\LuuKho */
?>
<div class="luu-kho-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'loai_file',
            'id_file',
            'id_kho',
            'id_ke',
            'id_ngan',
            'id_hop',
            'nguoi_tao',
            'thoi_gian_tao',
            'doi_tuong',
        ],
    ]) ?>

</div>
