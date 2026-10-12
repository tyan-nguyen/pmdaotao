<?php
use yii\helpers\Url;
use yii\bootstrap5\Html;
use app\custom\CustomFunc;
use app\modules\thuexe\models\XeGiayTo;
use app\modules\thuexe\models\LoaiGiayTo;
use app\modules\thuexe\models\base\XeGiayToBase;

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
            'data-confirm-message' => 'Bạn có chắc chắn muốn xóa giấy tờ xe này?',
            'class' => 'btn ripple btn-secondary btn-sm',
            'data-bs-placement' => 'top',
            'data-bs-toggle' => 'tooltip-secondary'
        ], 
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'id_xe',
        'label' => 'Xe (Biển số)',
        'value' => function ($model) {
            return $model->xe ? ($model->xe->bien_so_xe . ($model->xe->hieu_xe ? ' (' . $model->xe->hieu_xe . ')' : '')) : '';
        },
        'filter' => XeGiayTo::getListXe(),
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'id_loai_giay_to',
        'label' => 'Loại giấy tờ',
        'format' => 'raw',
        'value' => function ($model) {
            if (!$model->loaiGiayTo) {
                return '';
            }
            $txt = Html::encode($model->loaiGiayTo->ten_loai_giay_to);
            if ($model->loaiGiayTo->la_bat_buoc == \app\modules\thuexe\models\base\LoaiGiayToBase::BAT_BUOC_CO) {
                $txt .= ' <span class="badge bg-danger ms-1" style="font-size: 10px;">Bắt buộc</span>';
            }
            return $txt;
        },
        'filter' => LoaiGiayTo::getListLoaiGiayTo(),
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'ngay_bat_dau',
        'label' => 'Ngày bắt đầu',
        'value' => function ($model) {
            return CustomFunc::convertYMDToDMY($model->ngay_bat_dau);
        },
        'hAlign' => 'center',
        'width' => '120px',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'ngay_ket_thuc',
        'label' => 'Ngày hết hạn',
        'value' => function ($model) {
            return CustomFunc::convertYMDToDMY($model->ngay_ket_thuc);
        },
        'hAlign' => 'center',
        'width' => '120px',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'tinh_trang_han',
        'label' => 'Tình trạng hạn',
        'format' => 'raw',
        'value' => function ($model) {
            return $model->getTrangThaiHanLabel();
        },
        'filter' => \app\modules\thuexe\models\search\XeGiayToSearch::getDmTinhTrangHan(),
        'hAlign' => 'center',
        'width' => '140px',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'is_active',
        'format' => 'raw',
        'value' => function ($model) {
            return $model->getIsActiveLabel();
        },
        'filter' => XeGiayToBase::getDmIsActive(),
        'hAlign' => 'center',
        'width' => '120px',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'ghi_chu',
    ],
];
