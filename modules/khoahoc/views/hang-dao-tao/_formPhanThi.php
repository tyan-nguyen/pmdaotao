<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

$this->registerCssFile('@web/css/khoaHoc.css', [
    'depends' => [\yii\bootstrap5\BootstrapAsset::className()],
]);
?>

<div class="phan-thi-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
         <div class="col-md-4">
            <?= $form->field($model, 'ten_phan_thi')->textInput(['maxlength' => true]) ?>
         </div>
         <div class="col-md-4">
            <?= $form->field($model, 'thu_tu_thi')->textInput()?>
         </div>
         <div class="col-md-4">
            <?= $form->field($model,'diem_dat_toi_thieu')->textInput()?>
        </div>
   </div>
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
<style>
 .phan-thi-form label {
    font-weight: bold;
}
</style>
