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
        'attribute'=>'ho_ten',
    ],
   // [
      //  'class'=>'\kartik\grid\DataColumn',
      //  'attribute'=>'so_dien_thoai',
   // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'so_cccd',
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'dia_chi',
    ],
 
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'id_hang',
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
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{view} {update} {payment}', // Thêm {payment} vào template
        'dropdown' => false,
        'vAlign' => 'middle',
        'width' => '200px',
        'urlCreator' => function($action, $model, $key, $index) { 
            if ($action === 'payment') {
                return Url::to(['create2', 'id' => $key]);
            }
            return Url::to([$action, 'id' => $key]);
        },
        'viewOptions' => [
            'role' => 'modal-remote',
            'title' => 'Xem phiếu',
            'class' => 'btn ripple btn-primary btn-sm',
            'data-bs-placement' => 'top',
            'data-bs-toggle' => 'tooltip-primary'
        ],
        'updateOptions' => [
            'role' => 'modal-remote',
            'title' => 'Cập nhật phiếu', 
            'class' => 'btn ripple btn-info btn-sm',
            'data-bs-placement' => 'top',
            'data-bs-toggle' => 'tooltip-info'
        ],
        'buttons' => [
            'payment' => function($url, $model, $key) {
                return Html::a('<i class="fas fa-dollar-sign"></i>', $url, [
                    'title' => 'Đóng học phí',
                    'role' => 'modal-remote',
                    'class' => 'btn ripple btn-warning btn-sm',
                    'style' => 'width: 30px; text-align: center;',
                    'data-bs-placement' => 'top',
                    'data-bs-toggle' => 'tooltip-warning',
                ]);
            }
        ],
    ],
    
 
];   