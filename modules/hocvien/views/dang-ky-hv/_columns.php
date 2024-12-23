<?php
use yii\helpers\Url;
use yii\bootstrap5\Html;
return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],

        // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id',
    // ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'header'=>'',
        'template' => '{payment} {view} {update} {delete} ',
        'dropdown' => true,
        'dropdownOptions' => ['class' => 'float-right'],
        'dropdownButton'=>[
            'label'=>'<i class="fe fe-settings floating"></i>',
            'class'=>'btn dropdown-toggle p-0'
        ],
        'vAlign'=>'middle',
        'width' => '20px',
        'urlCreator' => function($action, $model, $key, $index) { 
            if ($action === 'payment') {
                return Url::to(['create2', 'id' => $key]);
            }
            return Url::to([$action, 'id' => $key]);
        },
        'viewOptions' => [
            'role' => 'modal-remote',
            'title' => 'Xem',
            'class' => 'btn ripple btn-primary btn-sm',
            'data-bs-placement' => 'top',
            'data-bs-toggle' => 'tooltip-primary'
        ],
        'updateOptions' => [
            'role' => 'modal-remote',
            'title' => 'Sửa', 
            'class' => 'btn ripple btn-info btn-sm',
            'data-bs-placement' => 'top',
            'data-bs-toggle' => 'tooltip-info'
        ],
        'deleteOptions' => [
            'role' => 'modal-remote',
            'title' => 'Xóa', 
            'class' => 'btn ripple btn-success btn-sm',
            'data-bs-placement' => 'top',
            'data-bs-toggle' => 'tooltip-success'
        ],
    'buttons' => [
    'payment' => function ($url, $model, $key) {
        return Html::a('<i class="fas fa-dollar-sign"></i> Đóng học phí', $url, [
            'title' => 'Đóng học phí',
            'role' => 'modal-remote',
            'class' => 'btn ripple btn-warning dropdown-item', 
            'data-bs-placement' => 'top',
            'data-bs-toggle' => 'tooltip',
        ]);
    },
],

    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ho_ten',
        'width' => '150px',
    ],
   // [
      //  'class'=>'\kartik\grid\DataColumn',
      //  'attribute'=>'so_dien_thoai',
   // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'so_cccd',
        'width' => '100px',
    ],

    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'loai_dang_ky',
        'width' => '200px',
        'format' => 'raw', 
        'value' => function ($model) {
            if (strtolower($model->loai_dang_ky) == 'nhập trực tiếp') {
                return '<span style="color: green;">Nhập trực tiếp</span>';
            } else {
                return '<span style="color: orange;">' . $model->loai_dang_ky . '</span>';
            }
        },
    ],
    
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'trang_thai_duyet',
        'width' => '100px',
        'format' => 'raw', 
        'value' => function ($model) {
            if ($model->trang_thai_duyet == 'CHO_DUYET') {
                return '<span class="badge bg-primary">Chờ duyệt</span>';
            } elseif ($model->trang_thai_duyet == 'KHONG_DUYET') {
                return '<span class="badge bg-danger">Không duyệt</span>';
            } elseif ($model->trang_thai_duyet == 'DA_DUYET') {
                return '<span class="badge bg-danger">Đã duyệt</span>';
            }
            return '<span class="badge bg-secondary">Không xác định</span>'; 
        },
    ],
    
    
 
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'id_hang',
        'width' => '100px',
        'value' => function($model) {
            return $model->hangDaoTao ? $model->hangDaoTao->ten_hang : 'N/A';
        },
        'label' => 'Hạng đào tạo',
    ],
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
  
    
 
];   