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
            'ngay_ky'=>[
                'attribute' => 'ngay_ky',
                'value'=>$model->ngayKy
            ],
            'trich_yeu',
            'nguoi_ky',
        'vbden_ngay_den' => [
             'attribute' => 'vbden_ngay_den',
             'value' => function($model) {
             return Yii::$app->formatter->asDate($model->vbden_ngay_den, 'php:d/m/Y');
                },
            ],

            
            'vbden_so_den',
            'vbden_nguoi_nhan',
            'vbden_ngay_chuyen' => [
                'attribute' => 'vbden_ngay_chuyen',
                'value' => function($model) {
                return Yii::$app->formatter->asDate($model->vbden_ngay_chuyen, 'php:d/m/Y');
                   },
               ],
         
          
         
            'ghi_chu',
            'nguoi_tao',
            'thoi_gian_tao',
            'so_loai_van_ban',
        ],
    ]) ?>

</div>
