<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\vanban\models\DmLoaiVanBan */
?>
<div class="dm-loai-van-ban-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'ten_loai',
            'ghi_chu:ntext',
           // 'nguoi_tao',
            //'thoi_gian_tao',
        ],
    ]) ?>

</div>
