<?php

use yii\helpers\Url;
use yii\bootstrap5\Html;
use app\modules\thuexe\models\base\LoaiGiayToBase;

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
        'urlCreator' => function ($action, $model, $key, $index) {
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
            'data-confirm-message' => 'Bạn có chắc chắn muốn xóa loại giấy tờ này?',
            'class' => 'btn ripple btn-secondary btn-sm',
            'data-bs-placement' => 'top',
            'data-bs-toggle' => 'tooltip-secondary'
        ],
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'ten_loai_giay_to',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'la_bat_buoc',
        'format' => 'raw',
        'value' => function ($model) {
            return $model->la_bat_buoc ? $model->getLaBatBuocLabel() : '';
        },
        'filter' => LoaiGiayToBase::getDmLaBatBuoc(),
        'hAlign' => 'center',
        'width' => '140px',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'check_het_han',
        'format' => 'raw',
        'value' => function ($model) {
            return $model->getCheckHetHanLabel();
        },
        'filter' => LoaiGiayToBase::getDmCheckHetHan(),
        'hAlign' => 'center',
        'width' => '150px',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'so_ngay_bao_truoc',
        'value' => function ($model) {
            if ($model->check_het_han == LoaiGiayToBase::CHECK_HET_HAN_KHONG) {
                return '<span class="text-muted">-</span>';
            }
            return ($model->so_ngay_bao_truoc ? $model->so_ngay_bao_truoc : LoaiGiayToBase::DEFAULT_SO_NGAY_BAO_TRUOC) . ' ngày';
        },
        'format' => 'raw',
        'hAlign' => 'center',
        'width' => '130px',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'ghi_chu',
    ],
];
