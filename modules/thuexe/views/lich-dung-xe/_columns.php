<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\custom\CustomFunc;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'header'=>'',
        'template' => '{view} {update} {delete}',
        'dropdown' => true,
        'dropdownOptions' => ['class' => 'float-right'],
        'dropdownButton'=>[
            'label'=>'<i class="fe fe-settings floating"></i>',
            'class'=>'btn dropdown-toggle p-0'
        ],
        'vAlign'=>'middle',
        'width' => '20px',
        'urlCreator' => function($action, $model, $key, $index) {
        	return Url::to([$action,'id'=>$key]);
        },
        'visibleButtons' => [
            'view' => function ($model, $key, $index) {
                return Yii::$app->params['showView'];
            },
        ],
        'viewOptions'=>['role'=>'modal-remote','title'=>'View','title'=>'Xem',
               'class'=>'btn ripple btn-primary btn-sm',
              'data-bs-placement'=>'top',
              'data-bs-toggle'=>'tooltip-primary'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Sửa', 
            'class'=>'btn ripple btn-info btn-sm',
            'data-bs-placement'=>'top',
            'data-bs-toggle'=>'tooltip-info'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Xóa', 
                      'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                      'data-request-method'=>'post',
                      'data-toggle'=>'tooltip',
                      'data-confirm-title'=>'Xác nhận xóa dữ liệu?',
                      'data-confirm-message'=>'Bạn có chắc chắn thực hiện hành động này?',
                       'class'=>'btn ripple btn-secondary btn-sm',
                       'data-bs-placement'=>'top',
                       'data-bs-toggle'=>'tooltip-secondary'], 

    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'trang_thai',
        'value'=>function($model){
        return $model->getDmTrangThaiLabelWithBadge($model->trang_thai);
        },
        'format'=>'raw',
        'contentOptions' => [ 'style' => 'text-align:center' ],
        'width' => '75px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label'=>'Hình ảnh',
        'value'=>function($model){
        return $model->xe->anhDaiDien ? Html::img(Yii::getAlias('@web/images/hinh-xe/' . $model->xe->anhDaiDien->hinh_anh), [
            'alt' => $model->xe->bien_so_xe,
            'class'=>'img-fluid rounded uniform-img',
            'data-fancybox'=>'gallery',
            'data-caption'=>$model->xe->anhDaiDien->hinh_anh,
            'style'=>'max-height:50px'
        ]) : '<span class="badge bg-warning">Chưa có hình</span>';
        },
        'format'=>'raw',
        'contentOptions' => [ 'style' => 'text-align:center' ],
        'width' => '200px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id_xe',
        'value'=>function($model){
            return $model->xe?$model->xe->tenXeShort2:'';
        },
        'width' => '150px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id_nguoi_phu_trach',
        'value'=>function($model){
            return $model->nguoiPhuTrach?$model->nguoiPhuTrach->ho_ten:'';
        },
        'label'=>'Người phụ trách',
        'width' => '200px',
    ],
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id_tai_xe',
    ], */
    
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'thoi_gian_bat_dau',
        'value'=>function($model){
            return CustomFunc::convertYMDHISToDMYHI($model->thoi_gian_bat_dau);
        },
        'contentOptions' => ['style' => 'text-align:center'],
        'width' => '100px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'thoi_gian_ket_thuc',
        'value'=>function($model){
            return CustomFunc::convertYMDHISToDMYHI($model->thoi_gian_ket_thuc);
        },
        'contentOptions' => ['style' => 'text-align:center'],
        'width' => '100px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'noi_dung',
        'width' => '300px',
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'so_gio',
    // ],
    
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ghi_chu',
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'nguoi_tao',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'thoi_gian_tao',
    // ],
];   