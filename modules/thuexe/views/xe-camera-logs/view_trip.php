<?php

use yii\bootstrap5\Html;
use yii\widgets\DetailView;
use app\modules\thuexe\models\base\XeCameraLogsBase;
use app\modules\thuexe\models\XeLuotRaVao;

/* @var $this yii\web\View */
/* @var $model app\modules\thuexe\models\XeLuotRaVao */

$isNoiBo = ($model->loai_xe === XeLuotRaVao::LOAI_XE_NOI_BO);
$titleLeft = $isNoiBo ? 'LƯỢT ĐI (MẶT TRƯỚC)' : 'LƯỢT VÀO (MẶT SAU)';
$iconLeft = $isNoiBo ? 'fa-arrow-circle-up' : 'fa-sign-in';
$colorLeft = $isNoiBo ? 'text-primary' : 'text-secondary';
$timeLabelLeft = $isNoiBo ? 'Thời gian đi:' : 'Thời gian vào:';

$titleRight = $isNoiBo ? 'LƯỢT VỀ (MẶT SAU)' : 'LƯỢT RA (MẶT TRƯỚC)';
$iconRight = $isNoiBo ? 'fa-arrow-circle-down' : 'fa-sign-out';
$colorRight = $isNoiBo ? 'text-info' : 'text-dark';
$timeLabelRight = $isNoiBo ? 'Thời gian về:' : 'Thời gian ra:';
$durationTitle = $isNoiBo ? 'Thời gian ở ngoài:' : 'Thời gian ở trong sân:';
?>
<div class="xe-luot-ra-vao-view">
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="p-3 border rounded bg-light">
                <h6 class="<?= $colorLeft ?> border-bottom pb-2 mb-2"><i class="fa <?= $iconLeft ?> me-1"></i> <?= $titleLeft ?></h6>
                <p><strong><?= $timeLabelLeft ?></strong> <?= $model->thoi_gian_di ? date('H:i:s d/m/Y', strtotime($model->thoi_gian_di)) : '<span class="text-danger">Chưa ghi nhận</span>' ?></p>
                <p><strong>Cổng camera:</strong> <?= Html::encode($model->getTenCameraDi()) ?></p>
                <?php if ($isNoiBo): ?>
                    <p><strong>Kế hoạch lúc đi:</strong> <?= $model->getKeHoachBadge() ?></p>
                <?php endif; ?>
                <p><strong>Mã log:</strong> <?= $model->log_di_id ? '#' . $model->log_di_id : '--' ?></p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="p-3 border rounded bg-light">
                <h6 class="<?= $colorRight ?> border-bottom pb-2 mb-2"><i class="fa <?= $iconRight ?> me-1"></i> <?= $titleRight ?></h6>
                <p><strong><?= $timeLabelRight ?></strong> <?= $model->thoi_gian_ve ? date('H:i:s d/m/Y', strtotime($model->thoi_gian_ve)) : '<span class="text-muted">Chưa ghi nhận</span>' ?></p>
                <p><strong>Cổng camera:</strong> <?= Html::encode($model->getTenCameraVe()) ?></p>
                <p><strong><?= $durationTitle ?></strong> <?= !empty($model->thoi_gian_o_ngoai_label) ? '<strong class="text-success">' . Html::encode($model->thoi_gian_o_ngoai_label) . '</strong>' : '--' ?></p>
                <p><strong>Mã log:</strong> <?= $model->log_ve_id ? '#' . $model->log_ve_id : '--' ?></p>
            </div>
        </div>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'loai_xe',
                'format' => 'raw',
                'value' => $model->getLoaiXeBadge()
            ],
            [
                'attribute' => 'bien_so_xe',
                'format' => 'raw',
                'value' => '<span class="badge bg-dark fs-13 font-monospace">' . Html::encode($model->bien_so_xe) . '</span> (' . Html::encode($model->ma_xe) . ')'
            ],
            [
                'attribute' => 'id_xe',
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
                'attribute' => 'trang_thai',
                'format' => 'raw',
                'value' => $model->getTrangThaiBadge()
            ],
            [
                'attribute' => 'qua_dem',
                'format' => 'raw',
                'value' => $model->getQuaDemBadge() ?: '<span class="text-muted">Không qua đêm</span>',
            ],
            'ghi_chu:ntext',
            [
                'attribute' => 'created_at',
                'value' => function ($model) {
                    return $model->created_at ? date('H:i:s d/m/Y', strtotime($model->created_at)) : '--';
                }
            ],
            [
                'attribute' => 'updated_at',
                'value' => function ($model) {
                    return $model->updated_at ? date('H:i:s d/m/Y', strtotime($model->updated_at)) : '--';
                }
            ],
        ],
    ]) ?>
</div>
