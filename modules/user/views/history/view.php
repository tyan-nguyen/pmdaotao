<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\dungchung\models\History */
?>
<div class="history-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'loai',
            'id_tham_chieu',
            'noi_dung:ntext',
            'thoi_gian_tao',
            'nguoi_tao',
        ],
    ]) ?>

</div>
