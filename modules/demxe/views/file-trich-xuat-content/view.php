<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\demxe\models\FileTrichXuatContent */
?>
<div class="file-trich-xuat-content-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_file',
            'camera',
            'ma_xe',
            'bien_so_xe',
            'thoi_gian',
            'thoi_gian_tao',
            'nguoi_tao',
        ],
    ]) ?>

</div>
