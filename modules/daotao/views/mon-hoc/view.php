<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\daotao\models\MonHoc */
?>
<div class="mon-hoc-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'ma_mon',
            'ten_mon',
            'ten_mon_sub',
            'so_gio_qd',
            'so_gio_tt',
            'ghi_chu:ntext',
            'nguoi_tao',
            'thoi_gian_tao',
        ],
    ]) ?>

</div>
