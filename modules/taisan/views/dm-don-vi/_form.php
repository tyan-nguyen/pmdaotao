<?php

use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\taisan\models\DmDonVi */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dm-don-vi-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-2">
            <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-8">
            <?= $form->field($model, 'ten')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'stt')->textInput() ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'co_sua_chua')->checkbox() ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'co_ban_hang')->checkbox() ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'ten_sort')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'ghi_chu')->textarea(['rows' => 1]) ?>
        </div>

    </div>
    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>