<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\hocvien\models\DmLienKet */
?>
<div class="dm-lien-ket-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'loai_lien_ket',
            'ten_lien_ket',
            'ghi_chu:ntext',
            'thoi_gian_tao',
            'nguoi_tao',
        ],
    ]) ?>

</div>
