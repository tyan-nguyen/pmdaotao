<?php

use yii\bootstrap5\Html;
use yii\widgets\DetailView;
use app\modules\thuexe\models\base\XeCameraLogsBase;

/* @var $this yii\web\View */
/* @var $model app\modules\thuexe\models\XeCameraLogs */
?>
<div class="xe-camera-logs-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'camera_log_id',
                'value' => $model->camera_log_id ? '#' . $model->camera_log_id : 'Chưa có',
            ],
            [
                'attribute' => 'camera',
                'format' => 'raw',
                'value' => $model->getCameraBadge(),
            ],
            [
                'attribute' => 'su_kien',
                'format' => 'raw',
                'value' => $model->getSuKienBadge(),
            ],
            [
                'attribute' => 'bien_so_xe',
                'format' => 'raw',
                'value' => '<span class="badge bg-dark font-monospace fs-13">' . Html::encode($model->bien_so_xe) . '</span>',
            ],
            'ma_xe',
            [
                'label' => 'Xe nội bộ khớp',
                'format' => 'raw',
                'value' => function ($model) {
                    $xe = $model->xe;
                    if ($xe) {
                        return '<strong class="text-primary">' . Html::encode($xe->hieu_xe) . '</strong> (' . Html::encode($xe->bien_so_xe) . ')' .
                            ' - ' . Html::a('<i class="fa fa-external-link"></i> Xem hồ sơ xe', ['/thuexe/xe/view', 'id' => $xe->id], ['target' => '_blank']);
                    }
                    return '<span class="text-muted">Xe ngoài danh mục nội bộ</span>';
                }
            ],
            [
                'attribute' => 'thoi_gian',
                'value' => date('H:i:s d/m/Y', strtotime($model->thoi_gian)),
            ],
            [
                'attribute' => 'trang_thai_ke_hoach',
                'format' => 'raw',
                'value' => function ($model) {
                    switch ($model->trang_thai_ke_hoach) {
                        case 'APPROVED':
                            return '<span class="badge bg-success">Có kế hoạch</span>';
                        case 'UNPLANNED':
                            return '<span class="badge bg-danger">Không kế hoạch</span>';
                        case 'INFO':
                            return '<span class="badge bg-secondary">Xe ngoài</span>';
                        default:
                            return '<span class="badge bg-light text-dark">N/A</span>';
                    }
                }
            ],
            [
                'attribute' => 'is_deleted',
                'format' => 'raw',
                'value' => ($model->is_deleted == XeCameraLogsBase::STATUS_DELETED)
                    ? '<span class="badge bg-secondary">Đã xóa tạm vào thùng rác</span>'
                    : '<span class="badge bg-success">Đang hoạt động</span>',
            ],
            [
                'attribute' => 'thoi_gian_tao',
                'value' => $model->thoi_gian_tao ? date('H:i:s d/m/Y', strtotime($model->thoi_gian_tao)) : '--',
            ],
            'deleted_by',
            [
                'attribute' => 'deleted_at',
                'value' => $model->deleted_at ? date('H:i:s d/m/Y', strtotime($model->deleted_at)) : null,
                'visible' => !empty($model->deleted_at),
            ],
        ],
    ]) ?>

</div>
