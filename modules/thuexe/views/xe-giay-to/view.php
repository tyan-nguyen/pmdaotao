<?php

use app\widgets\FileDisplayWidget;
use yii\bootstrap5\Html;
use app\custom\CustomFunc;
use app\modules\thuexe\models\XeGiayTo;

/* @var $this yii\web\View */
/* @var $model app\modules\thuexe\models\XeGiayTo */
?>
<div class="xe-giay-to-view">

    <div class="card custom-card">
        <div class="card-header custom-card-header rounded-bottom-0">
            <div>
                <h6 class="card-title mb-0" style="color: red;">Thông tin giấy tờ xe</h6>
            </div>
        </div>
        <div class="card-body">
            <div class="skill-tags">
                <p>
                    <strong>Xe:</strong> <?= $model->xe ? Html::encode($model->xe->bien_so_xe . ' - ' . $model->xe->hieu_xe) : '<span class="text-muted">Chưa rõ</span>' ?>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <strong>Loại giấy tờ:</strong> <?= $model->loaiGiayTo ? Html::encode($model->loaiGiayTo->ten_loai_giay_to) : '<span class="text-muted">Chưa rõ</span>' ?>
                </p>
                <p>
                    <strong>Ngày bắt đầu:</strong> <?= $model->ngay_bat_dau ? CustomFunc::convertYMDToDMY($model->ngay_bat_dau) : '-' ?>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <strong>Ngày hết hạn:</strong> <?= $model->ngay_ket_thuc ? CustomFunc::convertYMDToDMY($model->ngay_ket_thuc) : '-' ?>
                </p>
                <p>
                    <strong>Tình trạng hạn:</strong> <?= $model->getTrangThaiHanLabel() ?>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <strong>Hiệu lực:</strong> <?= $model->getIsActiveLabel() ?>
                </p>
                <p>
                    <strong>Thời gian tạo:</strong> <?= $model->thoi_gian_tao ? CustomFunc::convertYMDHISToDMYHIS($model->thoi_gian_tao) : '-' ?>
                </p>
                <p>
                    <strong>Ghi chú:</strong> <?= $model->ghi_chu ? nl2br(Html::encode($model->ghi_chu)) : '<span class="text-muted">-</span>' ?>
                </p>
            </div>
        </div>
    </div>

    <div class="card custom-card">
        <div class="card-header custom-card-header rounded-bottom-0">
            <div>
                <h6 class="card-title mb-0" style="color: red;">File đính kèm</h6>
            </div>
        </div>
        <div class="card-body">
            <?= FileDisplayWidget::widget([
                'type' => 'ALL',
                'doiTuong' => XeGiayTo::MODEL_ID,
                'idDoiTuong' => $model->id,
            ]) ?>
        </div>
    </div>

</div>