<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\custom\CustomFunc;

if($model->thoi_gian_bd){
    $model->thoi_gian_bd = CustomFunc::convertYMDHISToDMYHIS($model->thoi_gian_bd);
}
if($model->thoi_gian_kt){
    $model->thoi_gian_kt = CustomFunc::convertYMDHISToDMYHIS($model->thoi_gian_kt);
}

/* @var $this yii\web\View */
/* @var $model app\modules\daotao\models\DmThoiGian */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dm-thoi-gian-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<div class="row">
        <div class="col-md-4 flatpickr">
        	<?= $form->field($model, 'ten_thoi_gian')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
        	<?= $form->field($model, 'stt')->textInput() ?>
        </div>
        <div class="col-md-4 flatpickr">
        	<?= $form->field($model, 'thoi_gian_bd')->textInput(['id'=>'timebd']) ?>
        	
        </div>
        <div class="col-md-4">
        	<?= $form->field($model, 'thoi_gian_kt')->textInput(['id'=>'timekt']) ?>
        </div>
        <div class="col-md-4">
        	<?= $form->field($model, 'active')->checkbox() ?>
        </div>
        <div class="col-md-4">
        	<?= $form->field($model, 'ghi_chu')->textarea(['rows' => 6]) ?>
        </div>
        
  
	</div>
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>

<script>
flatpickr.localize(flatpickr.l10ns.vn);
$("#timebd").flatpickr({
	enableTime: true,
    dateFormat: "d/m/Y H:i:ss",
});
$("#timekt").flatpickr({
	enableTime: true,
    dateFormat: "d/m/Y H:i:ss",
});
</script>
