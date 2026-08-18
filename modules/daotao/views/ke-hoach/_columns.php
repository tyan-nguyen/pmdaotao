<?php

use yii\helpers\Url;
use app\custom\CustomFunc;
use app\modules\daotao\models\KeHoach;
use yii\helpers\Html;
use app\modules\daotao\models\HinhAnh;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'header' => '',
        'template' => '{duyet} {view} {update} {delete}',
        'dropdown' => true,
        'dropdownOptions' => ['class' => 'float-right'],
        'dropdownButton' => [
            'label' => '<i class="fe fe-settings floating"></i>',
            'class' => 'btn dropdown-toggle p-0'
        ],
        'vAlign' => 'middle',
        'width' => '20px',
        'urlCreator' => function ($action, $model, $key, $index) {
            if ($action === 'duyet') {
                return Url::to(['duyet', 'id' => $key]);
            }
            return Url::to([$action, 'id' => $key]);
        },
        'visibleButtons' => [
            'view' => function ($model, $key, $index) {
                return Yii::$app->params['showView'];
            },
            'duyet' => function ($model, $key, $index) {
                return $model->trang_thai_duyet == KeHoach::TT_CHODUYET;
            },
        ],
        'buttons' => [
            'duyet' => function ($url, $model, $key) {
                return Html::a('<i class="fa-solid fa-list-check"></i> Duyệt', $url, [
                    'title' => 'Duyệt kế hoạch',
                    'role' => 'modal-remote',
                    'class' => 'btn ripple btn-warning dropdown-item',
                    'data-bs-placement' => 'top',
                    'data-bs-toggle' => 'tooltip',
                ]);
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
        'attribute' => 'trang_thai_duyet',
        'value' => function ($model) {
            return KeHoach::getLabelTrangThaiBadge($model->trang_thai_duyet);
        },
        'format' => 'raw',
        'width' => '75px',
        'contentOptions' => ['style' => 'text-align:center'],
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'id_giao_vien',
        'value' => function ($model) {
            return $model->giaoVien ? $model->giaoVien->ho_ten : '';
        },
        'width' => '175px',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'ngay_thuc_hien',
        'label' => 'Ngày thực hiện',
        'value' => function ($model) {
            return CustomFunc::convertYMDToDMY($model->ngay_thuc_hien);
        },
        'width' => '100px',
        'contentOptions' => ['style' => 'text-align:center'],
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'label' => 'Ảnh lấy xe',
        'value' => function ($model) {
            $hinhAnh = HinhAnh::find()->where([
                'id_giao_vien' => $model->id_giao_vien,
                'date' => $model->ngay_thuc_hien,
                'loai' => HinhAnh::LOAI_KEHOACH,
                'luot' => HinhAnh::LUOT_DI,
            ])->orderBy(['id' => SORT_DESC])->one();

            if ($hinhAnh && !empty($hinhAnh->file_name)) {
                return '<a href="javascript:void(0);" onclick="showHinhAnhPopup(\'' . $hinhAnh->getUrlAnh() . '\')"><span class="badge bg-success" style="cursor:pointer;"><i class="fa fa-camera me-1"></i>Đã có</span></a>';
            }
            return '<span class="badge bg-default">Chưa có</span>';
        },
        'format' => 'raw',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'label' => 'Ảnh trả xe',
        'value' => function ($model) {
            $hinhAnh = HinhAnh::find()->where([
                'id_giao_vien' => $model->id_giao_vien,
                'date' => $model->ngay_thuc_hien,
                'loai' => HinhAnh::LOAI_KEHOACH,
                'luot' => HinhAnh::LUOT_VE,
            ])->orderBy(['id' => SORT_DESC])->one();

            if ($hinhAnh && !empty($hinhAnh->file_name)) {
                return '<a href="javascript:void(0);" onclick="showHinhAnhPopup(\'' . $hinhAnh->getUrlAnh() . '\')"><span class="badge bg-success" style="cursor:pointer;"><i class="fa fa-camera me-1"></i>Đã có</span></a>';
            }
            return '<span class="badge bg-default">Chưa có</span>';
        },
        'format' => 'raw',
        'hAlign' => 'center',
        'vAlign' => 'middle',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'thoi_gian_gui_duyet',
        'label' => 'TG. gửi duyệt',
        'value' => function ($model) {
            return $model->thoi_gian_gui_duyet ? CustomFunc::convertYMDHISToDMYHI($model->thoi_gian_gui_duyet) : '';
        },
        'width' => '125px',
        'contentOptions' => ['style' => 'text-align:center'],
    ],

    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'id_nguoi_duyet',
        'value' => function ($model) {
            return $model->nguoiDuyet ? ($model->nguoiDuyet->ho_ten ? $model->nguoiDuyet->ho_ten : $model->nguoiDuyet->username) : '';
        },
        'width' => '150px',
        'contentOptions' => ['style' => 'text-align:center'],
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'thoi_gian_duyet',
        'value' => function ($model) {
            return CustomFunc::convertYMDHISToDMYHI($model->thoi_gian_duyet);
        },
        'width' => '125px',
        'contentOptions' => ['style' => 'text-align:center'],
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'noi_dung_duyet',
        //'width' => '250px',
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
