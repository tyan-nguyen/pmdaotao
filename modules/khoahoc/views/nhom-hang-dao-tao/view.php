<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\khoahoc\models\NhomHangDaoTao */
?>
<div class="nhom-hang-dao-tao-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'ma_nhom_hang',
            'ten_nhom_hang',
            'stt',
            'nguoi_tao',
            'thoi_gian_tao',
            'ghi_chu:ntext',
        ],
    ]) ?>

</div>
