<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\daotao\models\HangMonHoc */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="hang-mon-hoc-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<div class="row">
            <div class="col-md-4">
        <?= $form->field($model, 'id_hang')->textInput() ?>
        </div>
        <div class="col-md-4">
        <?= $form->field($model, 'id_mon')->textInput() ?>
        </div>
        <div class="col-md-4">
        <?= $form->field($model, 'dang_hieu_luc')->checkbox() ?>
        </div>
  
	</div>
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
