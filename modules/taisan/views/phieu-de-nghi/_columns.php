<?php

use app\custom\CustomFunc;
use app\modules\taisan\models\PhieuDeNghi;
use app\modules\user\models\User;
use yii\helpers\Html;
use yii\helpers\Url;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'header' => '',
        'template' => '{duyetPhieu} {chiTiet} {delete}',
        'dropdown' => true,
        'dropdownOptions' => ['class' => 'float-right'],
        'dropdownButton' => [
            'label' => '<i class="fe fe-settings floating"></i>',
            'class' => 'btn dropdown-toggle p-0'
        ],
        'vAlign' => 'middle',
        'width' => '20px',
        'urlCreator' => function ($action, $model, $key, $index) {
            if ($action === 'chiTiet') {
                return Url::to(['update', 'id' => $key]);
            } else if ($action === 'duyetPhieu') {
                return Url::to(['duyet', 'id' => $key]);
            }
            return Url::to([$action, 'id' => $key]);
        },
        'buttons' => [
            'chiTiet' => function ($url, $model, $key) {
                return Html::a('<i class="fa fa-folder-open"></i> Chi tiết', $url, [
                    'title' => 'Xem chi tiết',
                    'role' => 'modal-remote',
                    'class' => 'btn ripple btn-warning dropdown-item',
                    'data-bs-placement' => 'top',
                    'data-bs-toggle' => 'tooltip',
                ]);
            },
            'duyetPhieu' => function ($url, $model, $key) {
                return Html::a('<i class="fa fa-check"></i> Duyệt phiếu', $url, [
                    'title' => 'Duyệt phiếu',
                    'role' => 'modal-remote',
                    'class' => 'btn ripple btn-success dropdown-item',
                    'data-bs-placement' => 'top',
                    'data-bs-toggle' => 'tooltip',
                ]);
            }
        ],
        'visibleButtons' => [
            'view' => function ($model, $key, $index) {
                return Yii::$app->params['showView'];
            },
            'duyetPhieu' => function ($model, $key, $index) {
                return $model->trang_thai == PhieuDeNghi::TRANGTHAI_CHODUYET && User::canRoute('taisan/phieu-de-nghi/duyet');
            },
        ],
        'viewOptions' => [
            'role' => 'modal-remote',
            'title' => 'View',
            'class' => 'btn ripple btn-primary btn-sm',
            'data-bs-placement' => 'top',
            'data-bs-toggle' => 'tooltip-primary'
        ],
        'updateOptions' => [
            'role' => 'modal-remote',
            'title' => 'Chi tiết phiếu',
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
        'value' => function ($model) {
            return PhieuDeNghi::getTrangThaiLabel($model->trang_thai);
        },
        'format' => 'html',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'da_thanh_toan',
        'value' => function ($model) {
            return PhieuDeNghi::getTrangThaiThanhToanLabel($model->da_thanh_toan);
        },
        'format' => 'html',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],

    /*  [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'loai_phieu',
        'value' => function ($model) {
            return PhieuDeNghi::getLoaiPhieuLabel($model->loai_phieu);
        },
        'format' => 'html',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ], */
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'loai_yeu_cau',
        'value' => function ($model) {
            return PhieuDeNghi::getLoaiSuaXeLabel($model->loai_yeu_cau);
        },
        'format' => 'html',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],

    /* [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'loai_tai_san',
        'value' => function ($model) {
            return PhieuDeNghi::getLoaiTaiSanLabel($model->loai_tai_san);
        },
        'format' => 'html',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ], */
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'id_tham_chieu',
        'label' => 'Tên xe/thiết bị',
        'value' => function ($model) {
            return Html::a($model->tenThamChieu ? $model->tenThamChieu : '', $model->linkThamChieu, [
                'role' => 'modal-remote',
                'title' => 'Xem thông tin',
                //'class' => 'btn ripple btn-primary btn-sm',
                'data-bs-placement' => 'top',
                'data-bs-toggle' => 'tooltip-primary',
                'style' => 'font-weight:bold'
            ]);
        },
        'format' => 'raw',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'nguoi_de_nghi',
        'value' => function ($model) {
            return $model->nguoiDeNghi ? $model->nguoiDeNghi->hoTen : '';
        },
    ],

    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'so_km_luc_yeu_cau',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'noi_dung_de_nghi',
    // ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'ngay_bat_dau',
        'value' => function ($model) {
            return CustomFunc::convertYMDHISToDMY($model->ngay_bat_dau);
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'ngay_hoan_thanh',
        'value' => function ($model) {
            return CustomFunc::convertYMDHISToDMY($model->ngay_hoan_thanh);
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],

    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'id_don_vi_thuc_hien',
        'value' => function ($model) {
            return $model->donViThucHien ? $model->donViThucHien->tenSort    : '';
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],

    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'nguoi_duyet',
        'value' => function ($model) {
            return $model->nguoiDuyet ? $model->nguoiDuyet->hoTen : '';
        },
        'pageSummary' => 'Tổng cộng',
        'pageSummaryOptions' => ['class' => 'text-right text-end'],
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'ngay_duyet',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'ghi_chu_duyet',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'phieu_co_chi_tiet',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'tong_tien_du_kien',
    // ],
    [
        'class' => '\kartik\grid\DataColumn',
        'label' => 'Tổng tiền',
        'value' => function ($model) {
            return $model->tongTien;
        },
        'hAlign' => 'right',
        'vAlign' => 'middle',
        'contentOptions' => ['style' => 'text-align:right'],
        'format' => ['decimal', 0],
        'pageSummary' => true,
        'pageSummaryOptions' => ['class' => 'text-right text-end'],
    ],
    /* [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'id_dot_tong_hop',
    ], */
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'thoi_gian_tao',
        'value' => function ($model) {
            return CustomFunc::convertYMDHISToDMY($model->thoi_gian_tao);
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'nguoi_tao',
        'value' => function ($model) {
            return $model->nguoiTao ? $model->nguoiTao->hoTen : '';
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
];
