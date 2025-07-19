<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\banhang\models\NhaCungCap */
?>
<div class="nha-cung-cap-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'ten_nha_cung_cap',
            'so_dien_thoai',
            'dia_chi',
            'tong_hop_cong_no',
            'da_thanh_toan',
            'con_lai',
            'nguoi_tao',
            'thoi_gian_tao',
        ],
    ]) ?>

</div>
