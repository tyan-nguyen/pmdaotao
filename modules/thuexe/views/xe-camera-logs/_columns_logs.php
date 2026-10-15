<?php

use yii\helpers\Url;
use yii\bootstrap5\Html;
use app\modules\thuexe\models\base\XeCameraLogsBase;
use app\modules\thuexe\models\base\XeLuotRaVaoBase;

return [
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'header' => '',
        'template' => '{view} {delete} {restore}',
        'dropdown' => true,
        'dropdownOptions' => ['class' => 'float-right'],
        'dropdownButton' => [
            'label' => '<i class="fe fe-settings floating"></i>',
            'class' => 'btn dropdown-toggle p-0'
        ],
        'vAlign' => 'middle',
        'width' => '30px',
        'buttons' => [
            'view' => function ($url, $model) {
                return Html::a('<i class="fa fa-eye me-1"></i> Xem chi tiết', ['view-log', 'id' => $model->id], [
                    'class' => 'dropdown-item',
                    'role' => 'modal-remote',
                    'title' => 'Xem chi tiết'
                ]);
            },
            'delete' => function ($url, $model) {
                if ($model->is_deleted == XeCameraLogsBase::STATUS_DELETED) {
                    return '';
                }
                return Html::a('<i class="fa fa-trash me-1 text-danger"></i> Xóa tạm (Thùng rác)', ['delete-log', 'id' => $model->id], [
                    'class' => 'dropdown-item text-danger',
                    'role' => 'modal-remote',
                    'data-confirm' => false,
                    'data-method' => false,
                    'data-request-method' => 'post',
                    'data-confirm-title' => 'Xác nhận xóa?',
                    'data-confirm-message' => 'Bạn có chắc muốn xóa tạm log này? Dữ liệu chuyến đi sẽ tự động tính toán lại.',
                ]);
            },
            'restore' => function ($url, $model) {
                if ($model->is_deleted != XeCameraLogsBase::STATUS_DELETED) {
                    return '';
                }
                return Html::a('<i class="fa fa-undo me-1 text-success"></i> Khôi phục', ['restore-log', 'id' => $model->id], [
                    'class' => 'dropdown-item text-success',
                    'role' => 'modal-remote',
                    'data-confirm' => false,
                    'data-method' => false,
                    'data-request-method' => 'post',
                    'data-confirm-title' => 'Xác nhận khôi phục?',
                    'data-confirm-message' => 'Bạn có muốn khôi phục log camera này? Dữ liệu chuyến đi sẽ tự động tính toán lại.',
                ]);
            },
        ],
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'thoi_gian',
        'label' => 'Thời gian quét',
        'format' => 'raw',
        'value' => function ($model) {
            return '<strong>' . date('H:i:s d/m/Y', strtotime($model->thoi_gian)) . '</strong>';
        }
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'camera',
        'label' => 'Cổng Camera',
        'format' => 'raw',
        'filter' => XeCameraLogsBase::getDmCamera(),
        'value' => function ($model) {
            return $model->getCameraBadge();
        }
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'su_kien',
        'label' => 'Hướng chụp',
        'format' => 'raw',
        'filter' => XeCameraLogsBase::getDmSuKien(),
        'value' => function ($model) {
            return $model->getSuKienBadge();
        }
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'bien_so_xe',
        'label' => 'Biển số xe',
        'format' => 'raw',
        'value' => function ($model) {
            $plateHtml = '<span class="badge bg-dark font-monospace fs-13 px-2 py-1">' . Html::encode($model->bien_so_xe) . '</span>';
            $xe = $model->xe;
            if ($xe) {
                $sub = '<div class="small mt-1 text-primary"><i class="fa fa-car me-1"></i>' . Html::a(Html::encode($xe->hieu_xe ?: 'Xe nội bộ'), ['/thuexe/xe/view', 'id' => $xe->id], ['target' => '_blank', 'data-pjax' => 0]) . '</div>';
            } else {
                $sub = '<div class="small mt-1 text-muted"><i class="fa fa-globe me-1"></i>Xe ngoài</div>';
            }
            return $plateHtml . $sub;
        }
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'ma_xe',
        'label' => 'Mã sạch',
        'width' => '110px',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'trang_thai_ke_hoach',
        'label' => 'Kế hoạch',
        'format' => 'raw',
        'filter' => XeLuotRaVaoBase::getDmKeHoach(),
        'value' => function ($model) {
            switch ($model->trang_thai_ke_hoach) {
                case XeLuotRaVaoBase::KE_HOACH_APPROVED:
                    return '<span class="badge bg-success">Có kế hoạch</span>';
                case XeLuotRaVaoBase::KE_HOACH_UNPLANNED:
                    return '<span class="badge bg-danger">Không kế hoạch</span>';
                case XeLuotRaVaoBase::KE_HOACH_INFO:
                    return '<span class="badge bg-secondary">Xe ngoài</span>';
                default:
                    return '<span class="badge bg-light text-dark">N/A</span>';
            }
        }
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'camera_log_id',
        'label' => 'ANPR ID',
        'width' => '90px',
        'value' => function ($model) {
            return $model->camera_log_id ? '#' . $model->camera_log_id : '--';
        }
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'is_deleted',
        'label' => 'Trạng thái',
        'format' => 'raw',
        'filter' => [0 => 'Đang hoạt động', 1 => 'Đã xóa tạm'],
        'value' => function ($model) {
            return ($model->is_deleted == XeCameraLogsBase::STATUS_DELETED)
                ? '<span class="badge bg-secondary">Đã xóa tạm</span>'
                : '<span class="badge bg-success">Hoạt động</span>';
        }
    ],
];
