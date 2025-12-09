<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\demxe\models\FileTrichXuat */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="file-trich-xuat-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<div class="row">
            <div class="col-md-4">
        <?= $form->field($model, 'thoi_gian_tu')->textInput() ?>
        </div>
        <div class="col-md-4">
        <?= $form->field($model, 'thoi_gian_den')->textInput() ?>
        </div>
        <div class="col-md-4">
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
