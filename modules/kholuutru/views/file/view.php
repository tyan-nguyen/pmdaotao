<?php

use yii\widgets\DetailView;
use app\custom\CustomFunc;

/* @var $this yii\web\View */
/* @var $model app\modules\kholuutru\models\File */
?>
<div class="file-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            [
                'attribute'=>'Loại file',
                'value'=>($model->loaiFile?$model->loaiFile->ten_loai:''),
            ],
            'file_name',
            'file_type',
            'file_size',
            'file_display_name',
            [
                'attribute'=>'nguoi_tao',
                'value'=>($model->taiKhoan?$model->taiKhoan->username:''),
            ],
            [
                'attribute'=>'thoi_gian_tao',
                'value'=>CustomFunc::convertYMDHISToDMYHIS($model->thoi_gian_tao),
            ],
        ],
        'template' => "<tr><th style='width: 30%;'>{label}</th><td>{value}</td></tr>"
    ]) ?>

</div>
