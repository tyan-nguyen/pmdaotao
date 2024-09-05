<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\vanban\models\VanBanDi */
?>
<div class="van-ban-di-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_loai_van_ban',
           
            'ngay_ky'=>[
                'attribute' => 'ngay_ky',
                'value'=>$model->ngayKy
            ],
            'nguoi_ky',
            'vbdi_noi_nhan',
            'vbdi_ngay_chuyen' => [
                'attribute' => 'vbdi_ngay_chuyen',
                'value' => function($model) {
                return Yii::$app->formatter->asDate($model->vbdi_ngay_chuyen, 'php:d/m/Y');
                   },
               ],
            'ghi_chu',
            'nguoi_tao',
            'thoi_gian_tao',
            'so_loai_van_ban',
        ],
    ]) ?>

</div>
