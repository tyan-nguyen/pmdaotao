<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\nhanvien\models\PhongBan */
?>
<div class="phong-ban-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'ten_phong_ban',
            'nguoi_tao',
            'thoi_gian_tao',
        ],
    ]) ?>

</div>
