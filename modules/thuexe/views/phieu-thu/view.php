<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\thuexe\models\PhieuThu */
?>
<div class="phieu-thu-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_lich_thue',
            'loai_phieu',
            'so_tien',
            'chiet_khau',
            'so_tien_con_lai',
            'ma_so_phieu',
            'so_lan_in_phieu',
            'hinh_thuc_thanh_toan',
            'nguoi_tao',
            'thoi_gian_tao',
            'ghi_chu:ntext',
        ],
    ]) ?>

</div>
