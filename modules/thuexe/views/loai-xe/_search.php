<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

?>

<div class="loai-xe-search">


<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'ten_loai_xe')->textInput(['maxlength' => true]) ?>

    <?php if (!Yii::$app->request->isAjax){ ?>
        <div class="form-group">
            <?= Html::submitButton('Tìm kiếm', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('Xóa tìm kiếm', ['class' => 'btn btn-outline-secondary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>

<style>
.loai-xe-search label {
    font-weight: bold;
}
</style>
