<?php
use yii\helpers\Url;
use app\modules\thuexe\models\LoaiXe;
use yii\bootstrap5\Html;
return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],

    [
        'class' => 'kartik\grid\ActionColumn',
        'header'=>'',
        'template' => '{image} {view} {update} {delete}',
        'dropdown' => true,
        'dropdownOptions' => ['class' => 'float-right'],
        'dropdownButton'=>[
            'label'=>'<i class="fe fe-settings floating"></i>',
            'class'=>'btn dropdown-toggle p-0'
        ],
        'vAlign'=>'middle',
        'width' => '20px',
   
        'urlCreator' => function($action, $model, $key, $index) { 
            if ($action === 'image') {
                         return Url::to(['add-image', 'id' => $key]);
            }
                        return Url::to([$action,'id'=>$key]);
              },
        
        'buttons' => [
          
            'image' => function($url, $model, $key) {
                return Html::a('<i class="fa fa-image"></i> Thêm hình ảnh', $url, [
                    'title' => 'Thêm hình ảnh',
                    'role' => 'modal-remote-2',
                    'class' => 'btn ripple btn-success dropdown-item',
                    'data-bs-placement' => 'top',
                    'data-bs-toggle' => 'tooltip-success',
                ]);
                
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
        // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
       'attribute'=>'id_loai_xe',
       'value' => function($model) {
            $loaiXe = LoaiXe::findOne($model->id_loai_xe);
            return $loaiXe ? $loaiXe->ten_loai_xe : '<span style="color: red;">Trống </span>'; 
        },
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'hieu_xe',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'bien_so_xe',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'tinh_trang_xe',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'trang_thai',
        'value' => function ($model) {
            return $model->trang_thai === 'Khả dụng' ? 'Khả dụng' : 'Không khả dụng';
        },
        'contentOptions' => function ($model) {
            return [
                'class' => $model->trang_thai === 'Khả dụng' ? 'text-success' : 'text-danger',
                'style' => 'font-weight: bold;', 
            ];
        },
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