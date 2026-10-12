<?php
use yii\helpers\Url;
use yii\bootstrap5\Html;
use app\custom\CustomFunc;

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
        'header' => '',
        'template' => '{view} {update} {delete}',
        'dropdown' => true,
        'dropdownOptions' => ['class' => 'float-right'],
        'dropdownButton' => [
            'label' => '<i class="fe fe-settings floating"></i>',
            'class' => 'btn dropdown-toggle p-0'
        ],
        'vAlign' => 'middle',
        'width' => '20px',
        'urlCreator' => function($action, $model, $key, $index) {
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
            'data-confirm' => false,
            'data-method' => false,
            'data-request-method' => 'post',
            'data-toggle' => 'tooltip',
            'data-confirm-title' => 'Xác nhận xóa?',
            'data-confirm-message' => 'Bạn có chắc chắn muốn xóa đơn vị sở hữu này?',
            'class' => 'btn ripple btn-secondary btn-sm',
            'data-bs-placement' => 'top',
            'data-bs-toggle' => 'tooltip-secondary'
        ], 
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'ten_don_vi',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'label' => 'Số lượng xe',
        'value' => function ($model) {
            $count = count($model->xes);
            return $count > 0 ? Html::a('<span class="badge bg-primary">' . $count . ' xe</span>', ['/thuexe/xe/index', 'XeSearch[id_don_vi_so_huu]' => $model->id], ['target' => '_blank', 'data-pjax' => '0']) : '<span class="text-muted">0</span>';
        },
        'format' => 'raw',
        'hAlign' => 'center',
        'width' => '120px',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'ghi_chu',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'thoi_gian_tao',
        'value' => function ($model) {
            return CustomFunc::convertYMDHISToDMYHIS($model->thoi_gian_tao);
        },
        'hAlign' => 'center',
        'width' => '160px',
    ],
];
