<?php

use app\custom\CustomFunc;
use yii\helpers\Url;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
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
        'urlCreator' => function ($action, $model, $key, $index) {
            return Url::to([$action, 'id' => $key]);
        },
        'visibleButtons' => [
            'view' => function ($model, $key, $index) {
                return Yii::$app->params['showView'];
            },
        ],
        'viewOptions' => [
            'role' => 'modal-remote',
            'title' => 'View',
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
            'data-method' => false, // for overide yii data api
            'data-request-method' => 'post',
            'data-toggle' => 'tooltip',
            'data-confirm-title' => 'Xác nhận xóa dữ liệu?',
            'data-confirm-message' => 'Bạn có chắc chắn thực hiện hành động này?',
            'class' => 'btn ripple btn-secondary btn-sm',
            'data-bs-placement' => 'top',
            'data-bs-toggle' => 'tooltip-secondary'
        ],

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
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'id_loai_hang_muc',
        'width' => '10%',
        'value' => function ($model) {
            return $model->loaiHangMuc->ten ?? '';
        }
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'ten',
        'width' => '15%'
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'dvt',
        'width' => '5%',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'don_gia',
        'width' => '10%',
        'vAlign' => 'middle',
        'hAlign' => 'right',
        'format' => ['decimal', 0],
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'label' => 'Sử dụng',
        'width' => '10%',
        'value' => function ($model) {
            return number_format($model->getSoLanSuDung()) . ' (' .$model->dvt . ')';
        },
        
        'vAlign' => 'right',
        'hAlign' => 'right'
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'thoi_gian_tao',
        'value' => function ($model) {
            return CustomFunc::convertYMDHISToDMYHI($model->thoi_gian_tao);
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'nguoi_tao',
        'value' => function ($model) {
            return $model->nguoiTao ? $model->nguoiTao->hoTen : '';
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'ghi_chu',
        'width' => '20%',
        'vAlign' => 'middle',
    ],
    
];
