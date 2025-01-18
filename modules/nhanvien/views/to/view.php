<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\nhanvien\models\To */
?>
<div class="to-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_phong_ban',
            'ten_to',
        ],
    ]) ?>

</div>
