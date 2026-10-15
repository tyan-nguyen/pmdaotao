<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use app\modules\thuexe\models\base\XeLuotRaVaoBase;
use app\modules\thuexe\models\base\XeCameraLogsBase;

/* @var $this yii\web\View */
/* @var $model app\modules\thuexe\models\XeLuotRaVao */
/* @var $form yii\bootstrap5\ActiveForm */
?>

<div class="xe-luot-ra-vao-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'bien_so_xe')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'trang_thai')->dropDownList(XeLuotRaVaoBase::getDmTrangThai()) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'thoi_gian_di')->textInput(['placeholder' => 'Y-m-d H:i:s']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'camera_di')->dropDownList(array_merge(['' => '-- Chọn cổng --'], XeCameraLogsBase::getDmCamera())) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'thoi_gian_ve')->textInput(['placeholder' => 'Y-m-d H:i:s']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'camera_ve')->dropDownList(array_merge(['' => '-- Chọn cổng --'], XeCameraLogsBase::getDmCamera())) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'trang_thai_ke_hoach')->dropDownList(array_merge(['' => '-- Chưa xác định --'], XeLuotRaVaoBase::getDmKeHoach())) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'thoi_gian_o_ngoai_label')->textInput(['maxlength' => true, 'placeholder' => 'VD: 2:35 (2 giờ 35 phút)']) ?>
        </div>
    </div>

    <?= $form->field($model, 'ghi_chu')->textarea(['rows' => 3, 'placeholder' => 'Nhập ghi chú đính chính nếu có']) ?>

    <?php if (!Yii::$app->request->isAjax): ?>
        <div class="form-group text-end mt-3">
            <?= Html::submitButton('Lưu lại', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php endif; ?>

    <?php ActiveForm::end(); ?>

</div>
