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
        'attribute' => 'trang_thai',
        'headerOptions' => ['style' => 'width:100px;'],
        'contentOptions' => ['style' => 'min-width:100px;'],
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'autoid',
        'headerOptions' => ['style' => 'width:50px;'],
        'contentOptions' => ['style' => 'min-width:50px;'],
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'ma_tai_san',
        'headerOptions' => ['style' => 'width:75px;'],
        'contentOptions' => ['style' => 'min-width:75px;'],
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'ten_tai_san',
        'headerOptions' => ['style' => 'width:200px;'],
        'contentOptions' => ['style' => 'min-width:200px;'],
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'loai_tai_san_id',
        'value' => function ($model) {
            return $model->loaiTaiSan ? $model->loaiTaiSan->ten : '';
        },
        'headerOptions' => ['style' => 'width:200px;'],
        'contentOptions' => ['style' => 'min-width:200px;'],
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'danh_muc_id',
        'value' => function ($model) {
            return $model->danhMuc ? $model->danhMuc->ten : '';
        },
        'headerOptions' => ['style' => 'width:200px;'],
        'contentOptions' => ['style' => 'min-width:200px;'],
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'phong_ban_id',
        'value' => function ($model) {
            return $model->phongBan ? $model->phongBan->ten_phong_ban : '';
        },
        'headerOptions' => ['style' => 'width:150px;'],
        'contentOptions' => ['style' => 'min-width:150px;'],
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'nguoi_chiu_trach_nhiem_id',
        'value' => function ($model) {
            return $model->nguoiChiuTrachNhiem ? $model->nguoiChiuTrachNhiem->ho_ten : '';
        },
        'headerOptions' => ['style' => 'width:150px;'],
        'contentOptions' => ['style' => 'min-width:150px;'],
    ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'model',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'serial',
    // ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'so_tien',
        'format' => ['decimal', 0],
        'headerOptions' => ['style' => 'width:150px;'],
        'contentOptions' => ['style' => 'min-width:150px;text-align:right'],
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'nha_cung_cap_id',
        'value' => function ($model) {
            return $model->nhaCungCap ? $model->nhaCungCap->ten : '';
        },
        'headerOptions' => ['style' => 'width:200px;'],
        'contentOptions' => ['style' => 'min-width:200px;'],
    ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'so_hoa_don',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'so_hop_dong',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'ngay_mua',
    // ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'thoi_han_bao_hanh',
        'value' => function ($model) {
            return CustomFunc::convertYMDToDMY($model->thoi_han_bao_hanh);
        },
        'headerOptions' => ['style' => 'width:100px;'],
        'contentOptions' => ['style' => 'min-width:100px;text-align:center'],
    ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'ghi_chu_bao_hanh',
    // ],
    /* [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'vi_tri_id',
        'value' => function ($model) {
            return $model->viTri->ten;
        }
    ], */

    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'muc_dich_su_dung',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'ngay_dua_vao_su_dung',
    // ],

    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'ghi_chu',
        'headerOptions' => ['style' => 'width:400px;'],
        'contentOptions' => ['style' => 'min-width:400px;'],
    ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'thoi_gian_tao',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'nguoi_tao',
    // ],
];
