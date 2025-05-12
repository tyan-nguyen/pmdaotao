<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\daotao\models\HangMonHoc */
?>
<div class="hang-mon-hoc-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_hang',
            'id_mon',
            'dang_hieu_luc',
            'nguoi_tao',
            'thoi_gian_tao',
        ],
    ]) ?>

</div>
