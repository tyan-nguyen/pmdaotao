<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\khachhang\models\LoaiKhachHang */
?>
<div class="loai-khach-hang-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'ten_loai_khach_hang',
            'ghi_chu',
            'nguoi_tao',
            'thoi_gian_tao',
        ],
    ]) ?>

</div>
