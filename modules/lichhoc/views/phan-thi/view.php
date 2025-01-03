<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\lichhoc\models\PhanThi */
?>
<div class="phan-thi-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'ten_phan_thi',
            'phan_hang',
            'diem_dat_toi_thieu',
            'trang_thai',
            'nguoi_tao',
            'thoi_gian_tao',
        ],
    ]) ?>

</div>
