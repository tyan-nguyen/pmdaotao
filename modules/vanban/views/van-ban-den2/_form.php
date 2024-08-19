<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\vanban\models\VanBanDen */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="van-ban-den-form row">
	<div class="col-md-6">
        <?php $form = ActiveForm::begin(); ?>
    
        <?= $form->field($model, 'id_loai_van_ban')->textInput() ?>
    
        <?= $form->field($model, 'so_vb')->textInput(['maxlength' => true]) ?>
    
        <?= $form->field($model, 'ngay_ky')->textInput() ?>
    
        <?= $form->field($model, 'trich_yeu')->textInput(['maxlength' => true]) ?>
    
        <?= $form->field($model, 'nguoi_ky')->textInput(['maxlength' => true]) ?>
    
        <?= $form->field($model, 'vbden_ngay_den')->textInput() ?>
    
        <?= $form->field($model, 'vbden_so_den')->textInput() ?>
    
        <?= $form->field($model, 'vbden_nguoi_nhan')->textInput() ?>
    
        <?= $form->field($model, 'vbden_ngay_chuyen')->textInput() ?>
    
        <?= $form->field($model, 'ghi_chu')->textInput(['maxlength' => true]) ?>
    
        <?= $form->field($model, 'nguoi_tao')->textInput() ?>
    
        <?= $form->field($model, 'thoi_gian_tao')->textInput() ?>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<p class="mb-2">Toggle switch single</p>
			<label class="custom-switch">
				<input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
				<span class="custom-switch-indicator"></span>
				<span class="custom-switch-description">I agree with terms and
					conditions</span>
			</label>
			<p class="mt-4 mb-2">Toggle switch single Checked</p>
			<label class="custom-switch">
				<input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" checked="">
				<span class="custom-switch-indicator"></span>
				<span class="custom-switch-description">I agree with terms and
					conditions</span>
			</label>
		</div>
	</div>
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
