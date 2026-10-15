<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use app\modules\thuexe\models\XeCameraLogs;

/* @var $this yii\web\View */
/* @var $model app\modules\thuexe\models\search\XeCameraLogsSearch */

$dmKeHoach = [
    'APPROVED' => 'Hợp lệ / Có kế hoạch',
    'UNPLANNED' => 'Đi không lập kế hoạch',
    'INFO' => 'Xe ngoài / Khách',
];
?>

<div class="card custom-card mb-3 border">
    <div class="card-header py-2 bg-light d-flex align-items-center justify-content-between">
        <h6 class="card-title mb-0 fs-13 text-info">
            <i class="fe fe-search me-1"></i> BỘ LỌC NHẬT KÝ CAMERA
        </h6>
    </div>
    <div class="card-body py-2 px-3">
        <?php $form = ActiveForm::begin([
            'id' => 'filterFormLogs',
            'action' => ['index', 'tab' => 'logs'],
            'method' => 'get',
            'options' => [
                'class' => 'myFilterFormLogs',
                'data-pjax' => 1,
            ],
        ]); ?>

        <div class="row g-2 align-items-end">
            <div class="col-md-2 col-sm-6">
                <?= $form->field($model, 'bien_so_xe', ['options' => ['class' => 'mb-0']])
                    ->textInput(['placeholder' => 'Biển số / Mã xe...'])
                    ->label('Biển số xe', ['class' => 'form-label fs-12 mb-1']) ?>
            </div>

            <div class="col-md-3 col-sm-6">
                <?= $form->field($model, 'camera', ['options' => ['class' => 'mb-0']])
                    ->dropDownList(XeCameraLogs::getDmCamera(), ['prompt' => '-- Tất cả camera --'])
                    ->label('Cổng camera', ['class' => 'form-label fs-12 mb-1']) ?>
            </div>

            <div class="col-md-2 col-sm-6">
                <?= $form->field($model, 'su_kien', ['options' => ['class' => 'mb-0']])
                    ->dropDownList(XeCameraLogs::getDmSuKien(), ['prompt' => '-- Góc chụp / Chiều xe --'])
                    ->label('Góc chụp', ['class' => 'form-label fs-12 mb-1']) ?>
            </div>

            <div class="col-md-2 col-sm-6">
                <?= $form->field($model, 'trang_thai_ke_hoach', ['options' => ['class' => 'mb-0']])
                    ->dropDownList($dmKeHoach, ['prompt' => '-- Trạng thái kế hoạch --'])
                    ->label('Trạng thái kế hoạch', ['class' => 'form-label fs-12 mb-1']) ?>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="d-flex gap-1">
                    <div class="flex-fill">
                        <?= $form->field($model, 'tu_ngay', ['options' => ['class' => 'mb-0']])
                            ->input('date')
                            ->label('Từ ngày', ['class' => 'form-label fs-12 mb-1']) ?>
                    </div>
                    <div class="flex-fill">
                        <?= $form->field($model, 'den_ngay', ['options' => ['class' => 'mb-0']])
                            ->input('date')
                            ->label('Đến ngày', ['class' => 'form-label fs-12 mb-1']) ?>
                    </div>
                </div>
            </div>

            <div class="col-12 text-end pt-2 border-top mt-2">
                <?= Html::submitButton('<i class="fa fa-search me-1"></i> Tìm kiếm', ['class' => 'btn btn-info text-white btn-sm px-3']) ?>
                <?= Html::a('<i class="fa fa-refresh me-1"></i> Đặt lại', ['index', 'tab' => 'logs'], [
                    'class' => 'btn btn-outline-secondary btn-sm px-3',
                    'data-pjax' => 1
                ]) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
