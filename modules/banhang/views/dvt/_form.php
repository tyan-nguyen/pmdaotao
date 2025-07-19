<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\banhang\models\DVT */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dvt-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<div class="row">
            <div class="col-md-4">
        <?= $form->field($model, 'ten_dvt')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-8">
        <?= $form->field($model, 'ghi_chu')->textarea(['rows' => 3]) ?>
        </div>
  
	</div>
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
