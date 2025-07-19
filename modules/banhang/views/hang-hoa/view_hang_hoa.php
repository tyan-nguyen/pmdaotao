<?php

use yii\widgets\DetailView;
use app\custom\CustomFunc;
use app\modules\user\models\User;

/* @var $this yii\web\View */
/* @var $model app\modules\banhang\models\HangHoa */
?>
<div class="row">
<div class="col-md-6">
<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id_loai_hang_hoa'=>[
            'attribute' => 'id_loai_hang_hoa',
            'value' => $model->loaiHangHoa->ten_loai_hang_hoa
        ],
        'ma_hang_hoa',
        'ten_hang_hoa',
        'ngay_san_xuat'=>[
            'attribute' => 'ngay_san_xuat',
            'value' => CustomFunc::convertYMDToDMY($model->ngay_san_xuat)
        ],
        'don_gia'=>[
            'attribute' => 'don_gia',
            'value' => number_format($model->don_gia)
        ],
        'dvt'=>[
            'attribute' => 'dvt',
            'value' => $model->donViTinh->ten_dvt
        ]
    ],
    'options' => [
        'class' => 'table table-responsive border p-0 pt-6'
    ],
]) ?>
</div>
<div class="col-md-6">
<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'co_ton_kho' => [
            'attribute' => 'co_ton_kho',
            'format' => 'html',
            'value' => $model->co_ton_kho ? '<i class="text-primary ion-checkmark-round"></i>' : '<i class="ion-close-round"></i>'
        ],
        'so_luong'=>[
            'attribute' => 'so_luong',
            'value' => number_format($model->so_luong),
            'visible' => $model->co_ton_kho
        ],
        'xuat_xu',
        'ghi_chu:ntext',
        'nguoi_tao'=>[
            'attribute' => 'nguoi_tao',
            'value' => User::findOne($model->nguoi_tao)?User::findOne($model->nguoi_tao)->username:''
        ],
        'thoi_gian_tao'=>[
            'attribute' => 'thoi_gian_tao',
            'value' => CustomFunc::convertYMDHISToDMYHIS($model->thoi_gian_tao)
        ],
    ],
    'options' => [
        'class' => 'table table-responsive border p-0 pt-6'
    ],
]) ?>
</div>
</div>