<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\lichhoc\models\PhongHoc */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="phong-hoc-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-4">
              <?= $form->field($model, 'ten_phong')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">    
            <?= $form->field($model, 'file')->fileInput(['class' => 'form-control'])->label('Chọn Sơ đồ kho') ?>
               <div class="form-group">
                  <label>&nbsp;</label> 
               </div>
        </div>
        <div class="col-md-4">
              <?= $form->field($model, 'ghi_chu')->textarea(['rows' => 6]) ?>
        </div>
    </div>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
