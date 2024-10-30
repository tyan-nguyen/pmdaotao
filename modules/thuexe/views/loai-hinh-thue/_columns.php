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
        'attribute'=>'loai_hinh_thue',
    ],
   
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id_loai_xe',
        'width' => '150px',
        'value'=>function($model){
            return $model->loaiXe->ten_loai_xe;
        }
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'gia_thue',
        'value' => function ($model) {
            return Yii::$app->formatter->asDecimal($model->gia_thue, 0) . ' VND';
        },
    ],
    
   
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ngay_ap_dung',
        'width' => '150px',
        'value'=>function($model){
            return $model->ngayApDung;
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ngay_ket_thuc',
        'width' => '150px',
        'value'=>function($model){
            return $model->ngayKetThuc;
        }
    ],
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