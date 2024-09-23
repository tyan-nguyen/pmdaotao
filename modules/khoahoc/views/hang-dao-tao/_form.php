<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\khoahoc\models\HangDaoTao */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="hang-dao-tao-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ten_hang')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ghi_chu')->textarea(['rows' => 6]) ?>

	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
<style>
    .hang-dao-tao-form .form-control {
    border-color: #0000FF; 
    border-width: 1px; 
}
</style>