<?php

use yii\helpers\Url;
use yii\bootstrap5\Html;
use app\modules\thuexe\models\XeLuotRaVao;
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
        'template' => '{view} {update} {delete}',
        'dropdown' => true,
        'dropdownOptions' => ['class' => 'float-right'],
        'dropdownButton' => [
            'label' => '<i class="fe fe-settings floating"></i>',
            'class' => 'btn dropdown-toggle p-0'
        ],
        'vAlign' => 'middle',
        'width' => '30px',
        'urlCreator' => function ($action, $model, $key, $index) {
            return Url::to([$action . '-trip', 'id' => $key]);
        },
        'viewOptions' => [
            'role' => 'modal-remote',
            'title' => 'Xem chi tiết',
            'class' => 'btn ripple btn-primary btn-sm',
            'data-bs-placement' => 'top',
            'data-bs-toggle' => 'tooltip-primary'
        ],
        'updateOptions' => [
            'role' => 'modal-remote',
            'title' => 'Sửa đính chính',
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
            'data-confirm-message' => 'Bạn có chắc muốn xóa lượt xe này?',
            'class' => 'btn ripple btn-secondary btn-sm',
            'data-bs-placement' => 'top',
            'data-bs-toggle' => 'tooltip-secondary'
        ],
    ],
    /* [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'loai_xe',
        'label' => 'Loại xe',
        'format' => 'raw',
        'filter' => XeLuotRaVao::getDmLoaiXe(),
        'width' => '100px',
        'value' => function ($model) {
            return $model->getLoaiXeBadge();
        }
    ], */
    [
        'class' => '\kartik\grid\DataColumn',
        'label' => 'Cổng',
        //'attribute' => 'camera',
        'value' => function ($model) {
            // return XeCameraLogsBase::getDmCong()[$model->cong_kiem_soat];
            return '-';
        },
        'format' => 'html',
        'contentOptions' => ['style' => 'text-align:center'],
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'id_xe',
        'label' => 'Loại xe',
        'value' => function ($model) {
            // return $model->id_xe != null ? '<span class="badge bg-primary">Xe nội bộ</span>'
            //: '<span class="badge bg-info">Xe khách</span>';
            return $model->loaiXe;
        },
        'format' => 'html',
        'contentOptions' => ['style' => 'text-align:center'],
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'label' => 'Sự kiện',
        'format' => 'raw',
        'value' => function ($model) {
            $html = '';
            if ($model->trang_thai_ke_hoach == XeLuotRaVaoBase::KE_HOACH_UNPLANNED) {
                $html .= $model->suKienIcon;
            }
            if ($model->qua_dem) {
                $html .= $model->getQuaDemBadge();
            }
            return $html;
        },
        'contentOptions' => ['style' => 'text-align:center'],
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'bien_so_xe',
        'label' => 'Phương tiện',
        'format' => 'raw',
        'value' => function ($model) {
            $xe = $model->xe;
            if ($xe) {
                return Html::encode($model->bien_so_xe ?: $model->ma_xe);
            } else {
                return '';
            }
        },
        'contentOptions' => ['style' => 'text-align:center'],
        /* 'value' => function ($model) {
            $plateHtml = '<span class="badge bg-dark fs-13 text-uppercase font-monospace px-2 py-1">' . Html::encode($model->bien_so_xe ?: $model->ma_xe) . '</span>';
            $xe = $model->xe;
            if ($xe) {
                $sub = '<div class="small mt-1 text-primary"><i class="fa fa-car me-1"></i>' . Html::a(Html::encode($xe->hieu_xe ?: 'Xe nội bộ'), ['/thuexe/xe/view', 'id' => $xe->id], ['target' => '_blank', 'data-pjax' => 0]) . '</div>';
            } else {
                $sub = '<div class="small mt-1 text-muted"><i class="fa fa-globe me-1"></i>Xe khách ngoài</div>';
            }
            return $plateHtml . $sub;
        } */
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'thoi_gian_di',
        'label' => 'Lượt 1 (Đi / Vào)',
        'format' => 'raw',
        'value' => function ($model) {
            $isNoiBo = ($model->loai_xe === XeLuotRaVao::LOAI_XE_NOI_BO);
            $typeBadge = $isNoiBo
                ? '<span class="badge bg-primary-transparent text-primary me-1"><i class="fa fa-arrow-circle-up me-1"></i>Đi (Trước)</span>'
                : '<span class="badge bg-secondary-transparent text-secondary me-1"><i class="fa fa-sign-in me-1"></i>Vào (Sau)</span>';

            if (empty($model->thoi_gian_di)) {
                /*  return $typeBadge . '<span class="text-danger"><i class="fa fa-times-circle me-1"></i>-</span>'; */
                return '<span class="text-muted">-</span>';
            }
            $timeStr = date('d/m/Y H:i:s', strtotime($model->thoi_gian_di));
            $camLabel = $model->getTenCameraDi();
            $camBadge = '<div class="small mt-1">' . $typeBadge . '<span class="badge bg-light text-dark"><i class="fa fa-video-camera me-1"></i>' . Html::encode($camLabel) . '</span></div>';
            return $timeStr /* . $camBadge */;
        }
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'thoi_gian_ve',
        'label' => 'Lượt 2 (Về / Ra)',
        'format' => 'raw',
        'value' => function ($model) {
            $isNoiBo = ($model->loai_xe === XeLuotRaVao::LOAI_XE_NOI_BO);
            $typeBadge = $isNoiBo
                ? '<span class="badge bg-info-transparent text-info me-1"><i class="fa fa-arrow-circle-down me-1"></i>Về (Sau)</span>'
                : '<span class="badge bg-dark-transparent text-dark me-1"><i class="fa fa-sign-out me-1"></i>Ra (Trước)</span>';

            if (empty($model->thoi_gian_ve)) {
                return '<span class="text-muted">-</span>';
            }
            $timeStr = date('d/m/Y H:i:s', strtotime($model->thoi_gian_ve));
            $camLabel = $model->getTenCameraVe();
            $camBadge = '<div class="small mt-1">' . $typeBadge . '<span class="badge bg-light text-dark"><i class="fa fa-video-camera me-1"></i>' . Html::encode($camLabel) . '</span></div>';
            return $timeStr /* . $camBadge */;
        }
    ],


    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'so_phut_o_ngoai',
        'label' => 'Thời gian',
        'format' => 'raw',
        'contentOptions' => ['style' => 'text-align:center'],
        'value' => function ($model) {
            $isNoiBo = ($model->loai_xe === XeLuotRaVao::LOAI_XE_NOI_BO);
            $locTag = $isNoiBo
                ? '<span class="badge bg-primary text-white me-1">Ở ngoài</span>'
                : '<span class="badge bg-info text-white me-1">Trong sân</span>';

            if ($model->trang_thai === XeLuotRaVao::TRANG_THAI_HOAN_THANH && $model->so_phut_o_ngoai !== null) {
                return Html::encode($model->thoi_gian_o_ngoai_label);
            } elseif (($model->trang_thai === XeLuotRaVao::TRANG_THAI_DANG_O_NGOAI || $model->trang_thai === XeLuotRaVao::TRANG_THAI_DANG_TRONG_SAN) && !empty($model->thoi_gian_di)) {
                $elapsedMinutes = max(0, (int)round((time() - strtotime($model->thoi_gian_di)) / 60));
                return XeLuotRaVao::formatPhutToLabel($elapsedMinutes) . ' <i class="fa fa-spinner fa-spin me-1"></i>';
            }
            return '<span class="text-muted">--</span>';
        }
        /* 'value' => function ($model) {
            $isNoiBo = ($model->loai_xe === XeLuotRaVao::LOAI_XE_NOI_BO);
            $locTag = $isNoiBo
                ? '<span class="badge bg-primary text-white me-1">Ở ngoài</span>'
                : '<span class="badge bg-info text-white me-1">Trong sân</span>';

            if ($model->trang_thai === XeLuotRaVao::TRANG_THAI_HOAN_THANH && $model->so_phut_o_ngoai !== null) {
                return $locTag . '<strong class="text-success fs-14"><i class="fa fa-clock-o me-1"></i>' . Html::encode($model->thoi_gian_o_ngoai_label) . '</strong>';
            } elseif (($model->trang_thai === XeLuotRaVao::TRANG_THAI_DANG_O_NGOAI || $model->trang_thai === XeLuotRaVao::TRANG_THAI_DANG_TRONG_SAN) && !empty($model->thoi_gian_di)) {
                $elapsedMinutes = max(0, (int)round((time() - strtotime($model->thoi_gian_di)) / 60));
                return $locTag . '<span class="badge bg-warning text-dark"><i class="fa fa-spinner fa-spin me-1"></i> Tạm tính: ' . XeLuotRaVao::formatPhutToLabel($elapsedMinutes) . '</span>';
            }
            return '<span class="text-muted">--</span>';
        } */
    ],

    /*  [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'trang_thai_ke_hoach',
        'label' => 'Kế hoạch',
        'format' => 'raw',
        'filter' => XeLuotRaVao::getDmKeHoach(),
        'value' => function ($model) {
            if ($model->trang_thai_ke_hoach == XeLuotRaVaoBase::KE_HOACH_UNPLANNED) {
                //return $model->getKeHoachBadge();
                return $model->suKienIcon;
            } else {
                return '';
            }
        }
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'qua_dem',
        'label' => 'Qua đêm',
        'format' => 'raw',
        'hAlign' => 'center',
        'width' => '100px',
        'value' => function ($model) {
            return $model->getQuaDemBadge() ?: '';
        }
    ], */
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'trang_thai',
        'label' => 'Trạng thái',
        'format' => 'raw',
        'filter' => XeLuotRaVao::getDmTrangThai(),
        'value' => function ($model) {
            return $model->getTrangThaiBadge();
        }
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'ghi_chu',
    ]
];
