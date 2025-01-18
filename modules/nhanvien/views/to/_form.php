<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\nhanvien\models\To */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="to-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_phong_ban')->textInput() ?>

    <?= $form->field($model, 'ten_to')->textInput(['maxlength' => true]) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
