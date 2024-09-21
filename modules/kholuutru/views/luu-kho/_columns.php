<?php
use yii\helpers\Url;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
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
        'attribute'=>'loai_file',
        'value' => function($model) {
            return $model->getLoaiFileName(); 
        },
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id_file',
        'value' => function($model) {
            return $model->getFileName(); 
        },
    ],
    
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'doi_tuong',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'id_kho',
        'value' => function ($model) {
            // Kiểm tra xem phongBan có tồn tại hay không
            return $model->kho ? $model->kho->ten_kho : 'N/A';
        },
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'id_ke',
        'value' => function ($model) {
            // Kiểm tra xem phongBan có tồn tại hay không
            return $model->ke ? $model->ke->ten_ke : 'N/A';
        },
    ],
  
    //[
      //  'class'=>'\kartik\grid\DataColumn',
     //   'attribute'=>'id_ke',
   // ],
  //  [
  //      'class'=>'\kartik\grid\DataColumn',
   //     'attribute'=>'id_ngan',
  //  ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id_hop',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'nguoi_tao',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'thoi_gian_tao',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'doi_tuong',
    // ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'width' => '200px',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'View','title'=>'Xem thông tin',
            'class'=>'btn ripple btn-primary btn-sm',
            'data-bs-placement'=>'top',
            'data-bs-toggle'=>'tooltip-primary'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Cập nhật dữ liệu', 
            'class'=>'btn ripple btn-info btn-sm',
            'data-bs-placement'=>'top',
            'data-bs-toggle'=>'tooltip-info'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Xóa dữ liệu này', 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Xác nhận xóa dữ liệu?',
                          'data-confirm-message'=>'Bạn có chắc chắn thực hiện hành động này?',
                           'class'=>'btn ripple btn-secondary btn-sm',
                           'data-bs-placement'=>'top',
                           'data-bs-toggle'=>'tooltip-secondary'], 
    ],

];   