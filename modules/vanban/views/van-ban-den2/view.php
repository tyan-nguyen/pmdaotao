<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\vanban\models\VanBanDen */
?>
<div class="van-ban-den-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_loai_van_ban',
            'so_vb',
            'ngay_ky',
            'trich_yeu',
            'nguoi_ky',
            'vbden_ngay_den',
            'vbden_so_den',
            'vbden_nguoi_nhan',
            'vbden_ngay_chuyen',
            'vbdi_noi_nhan',
            'vbdi_so_luong_ban',
            'vbdi_ngay_chuyen',
            'ghi_chu',
            'nguoi_tao',
            'thoi_gian_tao',
        ],
    ]) ?>

</div>
