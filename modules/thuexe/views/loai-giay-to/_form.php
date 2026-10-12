<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\widgets\CardWidget;
use app\modules\thuexe\models\base\LoaiGiayToBase;

/* @var $this yii\web\View */
/* @var $model app\modules\thuexe\models\LoaiGiayTo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="loai-giay-to-form">

    <?php $form = ActiveForm::begin(); ?>  

    <?php CardWidget::begin(['title' => 'Thông tin Loại giấy tờ xe']) ?>
    
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'ten_loai_giay_to')->textInput(['maxlength' => true, 'placeholder' => 'Ví dụ: Đăng kiểm, Bảo hiểm bắt buộc...']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'la_bat_buoc')->dropDownList(LoaiGiayToBase::getDmLaBatBuoc(), ['class' => 'form-select']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'check_het_han')->dropDownList(LoaiGiayToBase::getDmCheckHetHan(), ['id' => 'check_het_han_select', 'class' => 'form-select']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'so_ngay_bao_truoc')->textInput(['type' => 'number', 'min' => 1, 'placeholder' => 'Mặc định 30 ngày']) ?>
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
.loai-giay-to-form label {
    font-weight: bold;
}
</style>
