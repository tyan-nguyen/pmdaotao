<?php

use app\custom\CustomFunc;
use kartik\date\DatePicker;
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

$model->ngay_thi = CustomFunc::convertYMDToDMY($model->ngay_thi);

/* @var $this yii\web\View */
/* @var $model app\modules\demxe\models\FileTrichXuat */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="file-trich-xuat-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-8">
            <?= $form->field($model, 'ten_khoa_thi')->textInput() ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'ngay_thi')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Chọn ngày  ...', 'autocomplete' => 'off'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd/mm/yyyy',
                    'todayHighlight' => true,
                    'todayBtn' => true
                ]
            ]); ?>
        </div>
        <!--<div class="col-md-4">
            <?= $form->field($model, 'filename')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'nguoi_tao')->textInput() ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'thoi_gian_tao')->textInput() ?>
        </div>-->
        <div class="col-md-12">
            <?= $form->field($model, 'ghi_chu')->textarea(['rows' => 3]) ?>
        </div>

    </div>
    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>