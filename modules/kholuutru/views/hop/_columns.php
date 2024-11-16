<?php
use yii\helpers\Url;
use yii\bootstrap5\Html;

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
        // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id',
    // ],
 
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ten_hop',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'id_ngan',
        'value' => function ($model) {
            return $model->ngan ? $model->ngan->ten_ngan : 'N/A';
        },
    ],
    //[
      //  'class'=>'\kartik\grid\DataColumn',
       // 'attribute'=>'nguoi_tao',
   // ],
   // [
     //   'class'=>'\kartik\grid\DataColumn',
      //  'attribute'=>'thoi_gian_tao',
    //],
   

];   