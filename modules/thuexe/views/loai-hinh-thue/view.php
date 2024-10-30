<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\thuexe\models\LoaiHinhThue */
?>
<div class="loai-hinh-thue-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'loai_hinh_thue',
            'id_loai_xe',
            'gia_thue',
            'ngay_ap_dung',
            'ngay_ket_thuc',
            'nguoi_tao',
            'thoi_gian_tao',
        ],
    ]) ?>

</div>
