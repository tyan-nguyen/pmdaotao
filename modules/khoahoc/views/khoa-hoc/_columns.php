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
        'attribute'=>'ten_khoa_hoc',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'id_hang',
        'value' => function($model) {
            return $model->hang ? $model->hang->ten_hang : 'N/A';
        },
        'label' => 'Hạng đào tạo',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ngay_bat_dau',
        'value'=>function($model){
            return $model->ngayBatDau;
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ngay_ket_thuc',
        'value'=>function($model){
            return $model->ngayKetThuc;
        }
    ],
    //[
      //  'class'=>'\kartik\grid\DataColumn',
      //  'attribute'=>'ghi_chu',
   // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'trang_thai',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'nguoi_tao',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'thoi_gian_tao',
    // ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{adduser} {view} {update} {delete} ',
        'dropdown' => false,
        'vAlign'=>'middle',
        'width' => '200px',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
            // Đặt buttons bên trong cấu hình của ActionColumn
            'buttons' => [
                'adduser' => function($url, $model, $key) {
                    return Html::a('<i class="fa fa-user-plus"></i>', $url, [
                        'title' => 'Thêm Học viên',
                        'role' => 'modal-remote',
                        'class' => 'btn ripple btn-warning btn-sm',
                        'style' => 'width: 30px; text-align: center;',
                        'data-bs-placement' => 'top',
                        'data-bs-toggle' => 'tooltip-warning',
                    ]);
                }
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

];   