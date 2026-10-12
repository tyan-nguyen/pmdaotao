<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\widgets\CardWidget;

/* @var $this yii\web\View */
/* @var $model app\modules\thuexe\models\DonViSoHuu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="don-vi-so-huu-form">

    <?php $form = ActiveForm::begin(); ?>  

    <?php CardWidget::begin(['title' => 'Thông tin Đơn vị sở hữu xe']) ?>
    
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'ten_don_vi')->textInput(['maxlength' => true, 'placeholder' => 'Ví dụ: Trung tâm Đào tạo Lái xe, Công ty TNHH...']) ?>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'ghi_chu')->textarea(['rows' => 3, 'placeholder' => 'Ghi chú thêm...']) ?>
        </div>
    </div>

    <?php CardWidget::end() ?>

    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group mt-3">
            <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
<style>
.don-vi-so-huu-form label {
    font-weight: bold;
}
</style>
