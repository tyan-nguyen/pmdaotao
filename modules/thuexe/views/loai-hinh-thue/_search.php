<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

?>

<div class="loai-hinh-thue-search">

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'loai_hinh_thue')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'id_loai_xe')->textInput() ?>

<?= $form->field($model, 'gia_thue')->textInput() ?>

<?= $form->field($model, 'ngay_ap_dung')->textInput() ?>

<?= $form->field($model, 'ngay_ket_thuc')->textInput() ?>

    <?php if (!Yii::$app->request->isAjax){ ?>
        <div class="form-group">
            <?= Html::submitButton('Tìm kiếm', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('Xóa tìm kiếm', ['class' => 'btn btn-outline-secondary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>

<style>
.loai-hinh-thue-search label {
    font-weight: bold;
}
</style>
