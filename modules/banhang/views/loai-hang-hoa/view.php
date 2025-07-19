<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\hanghoa\models\LoaiHangHoa */
?>
<div class="loai-hang-hoa-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'ten_loai_hang_hoa',
            'ghi_chu:ntext',
            'nguoi_tao',
            'thoi_gian_tao',
        ],
    ]) ?>

</div>
