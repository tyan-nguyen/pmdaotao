<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

?>

<div class="xe-search">

<?php $form = ActiveForm::begin(); ?>

<div class="row">
    <div class="col-md-3">
         <?= $form->field($model, 'id_loai_xe')->textInput() ?>
    </div>
    <div class="col-md-3">
         <?= $form->field($model, 'hieu_xe')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-3">
         <?= $form->field($model, 'bien_so_xe')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-3">
         <?= $form->field($model, 'trang_thai')->textInput(['maxlength' => true]) ?>
    </div>
</div>

<?php if (!Yii::$app->request->isAjax){ ?>
    <div class="col-md-12 text-left">
        <div class="form-group mb-0">
	        <?= Html::submitButton('<i class="fe fe-search"></i> Tìm kiếm',['class' => 'btn btn-primary']) ?>
	        <?= Html::resetButton('<i class="fe fe-x"></i> Xóa tìm kiếm', ['class' => 'btn btn-info']) ?>
	    </div>
    </div>
<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>

<style>
.xe-search label {
    font-weight: bold;
}
</style>
