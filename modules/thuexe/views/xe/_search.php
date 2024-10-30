<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

?>

<div class="xe-search">

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'id_loai_xe')->textInput() ?>

<?= $form->field($model, 'hieu_xe')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'bien_so_xe')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'trang_thai')->textInput(['maxlength' => true]) ?>

    <?php if (!Yii::$app->request->isAjax){ ?>
        <div class="form-group">
            <?= Html::submitButton('Tìm kiếm', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('Xóa tìm kiếm', ['class' => 'btn btn-outline-secondary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>

<style>
.xe-search label {
    font-weight: bold;
}
</style>
