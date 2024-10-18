<?php
use yii\helpers\Url;
use yii\bootstrap5\Html;
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
        'attribute'=>'ten_hang',
        'width' => '100px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ghi_chu',
        'width' => '200px',
    ],
   // [
   //     'class'=>'\kartik\grid\DataColumn',
    //    'attribute'=>'nguoi_tao',
  //  ],
   // [
   //     'class'=>'\kartik\grid\DataColumn',
   //     'attribute'=>'thoi_gian_tao',
  //  ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{tuition} {listHP} {view} {update} {delete} ',
        'dropdown' => false,
        'vAlign'=>'middle',
        'width' => '300px',
    'urlCreator' => function($action, $model, $key, $index) {
          if ($action === 'tuition') {
             return Url::to(['tuition', 'id' => $key]);
          }
          if ($action === 'listHP') {
             return Url::to(['list-hoc-phi', 'id' => $key]);
          }
         return Url::to([$action, 'id' => $key]);
    },

        'buttons' => [
            'tuition' => function($url, $model, $key) {
                return Html::a('<i class="fas fa-dollar-sign"></i>', $url, [
                    'title' => 'Thêm Học phí',
                    'role' => 'modal-remote-2',
                    'class' => 'btn ripple btn-warning btn-sm',
                    'style' => 'width: 30px; text-align: center;',
                    'data-bs-placement' => 'top',
                    'data-bs-toggle' => 'tooltip-warning',
                ]);
            },

            'listHP' => function($url, $model, $key) {
                return Html::a('<i class="fa fa-list"></i>', $url, [
                    'title' => 'Danh sách Học phí',
                    'role' => 'modal-remote',
                    'class' => 'btn ripple btn-success btn-sm',
                    'style' => 'width: 30px; text-align: center;',
                    'data-bs-placement' => 'top',
                    'data-bs-toggle' => 'tooltip-success',
                ]);
            }
        ],
     
        'viewOptions'=>['role'=>'modal-remote-2','title'=>'View','title'=>'Xem thông tin',
            'class'=>'btn ripple btn-primary btn-sm',
            'data-bs-placement'=>'top',
            'data-bs-toggle'=>'tooltip-primary'],
        'updateOptions'=>['role'=>'modal-remote-2','title'=>'Cập nhật dữ liệu', 
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