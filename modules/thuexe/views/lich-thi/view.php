<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\thuexe\models\LichThi */
?>
<div class="lich-thi-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'phan_loai',
            'ten_ky_thi',
            'thoi_gian_bd',
            'thoi_gian_kt',
            'ghi_chu:ntext',
            'nguoi_tao',
            'thoi_gian_tao',
        ],
    ]) ?>

</div>
