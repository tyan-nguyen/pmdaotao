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
        'template' => '{tuition} {listHP} {listPhanThi} {view} {update} {delete}  ',
        'dropdown' => true,
        'dropdownOptions' => ['class' => 'float-right'],
        'dropdownButton'=>[
            'label'=>'<i class="fe fe-settings floating"></i>',
            'class'=>'btn dropdown-toggle p-0'
        ],
        'vAlign'=>'middle',
        'width' => '20px',
        'urlCreator' => function($action, $model, $key, $index) {
            if ($action === 'tuition') {
               return Url::to(['tuition', 'id' => $key]);
            }
            if ($action === 'listHP') {
               return Url::to(['list-hoc-phi', 'id' => $key]);
            }
            if ($action === 'listPhanThi'){
                return Url::to(['list-phan-thi','id'=>$key]);
            }
           return Url::to([$action, 'id' => $key]);
      },
        'buttons' => [
            'tuition' => function($url, $model, $key) {
                return Html::a('<i class="fas fa-dollar-sign"></i> Thêm học phí', $url, [
                    'title' => 'Thêm Học phí',
                    'role' => 'modal-remote-2',
                    'class' => 'btn ripple btn-danger dropdown-item',
                    'data-bs-placement' => 'top',
                    'data-bs-toggle' => 'tooltip-warning',
                ]);
            },

            'listHP' => function($url, $model, $key) {
                return Html::a('<i class="fa fa-list"></i> Danh sách học phí', $url, [
                    'title' => 'Danh sách Học phí',
                    'role' => 'modal-remote',
                    'class' => 'btn ripple btn-success dropdown-item',
                    'data-bs-placement' => 'top',
                    'data-bs-toggle' => 'tooltip-success',
                ]);
            },
            'listPhanThi'=>function($url, $model, $key)
            {
              return Html::a('<i class="fa fa-book"></i> Danh sách phần thi',$url,[
                   'title'=>'Danh sách phần thi',
                   'role' =>'modal-remote',
                   'class'=>'btn ripple btn-warning dropdown-item',
                   'data-bs-placement'=>'top',
                   'data-bs-toggle' => 'tooltip-success',
                ]);
            },
        ],
     
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
        'attribute'=>'check_phan_hang',
        'width' => '100px',
        'value' => function ($model) {
            return $model->check_phan_hang === 'OTO' ? 'Xe Ô tô' : ($model->check_phan_hang === 'MOTO' ? 'Xe Mô tô' : $model->check_phan_hang);
        },
        'format' => 'text', 
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
   

];   