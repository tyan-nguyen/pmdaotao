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

    [
        'class' => 'kartik\grid\ActionColumn',
        'header'=>'',
        'template' => '{view} {update} {delete} ',
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
                      'data-confirm'=>false, 'data-method'=>false,
                      'data-request-method'=>'post',
                      'data-toggle'=>'tooltip',
                      'data-confirm-title'=>'Xác nhận xóa dữ liệu?',
                      'data-confirm-message'=>'Bạn có chắc chắn thực hiện hành động này?',
                       'class'=>'btn ripple btn-secondary btn-sm',
                       'data-bs-placement'=>'top',
                       'data-bs-toggle'=>'tooltip-secondary'], 
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ten_phan_thi',
        'width' => '250px',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'id_hang',
        'width' => '100px',
        'value' => function($model) {
            return $model->hangDaoTao ? $model->hangDaoTao->ten_hang : 'N/A';
        },
        'label' => 'Hạng đào tạo',
        'contentOptions' => [
            'style' => 'font-weight: bold;',
        ],
    ],
    
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'diem_dat_toi_thieu',
        'width' => '200px',
        'contentOptions' => [
            'style' => 'color: red; font-weight: bold; font-size: 16px;',
        ],
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'thu_tu_thi',
        'width' => '100px',
    ],
    
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'trang_thai',
        'width' => '150px',
        'format' => 'raw', 
        'value' => function ($model) {
            if ($model->trang_thai == 'Đang áp dụng') {
                return '<span class="badge bg-primary">Đang áp dụng</span>';
            }
            return '<span class="badge bg-secondary">Không xác định</span>'; 
        },
    ],
];   