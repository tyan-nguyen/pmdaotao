<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\kholuutru\models\LuuKho */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="luu-kho-form">

    <?php $form = ActiveForm::begin(); ?>

      <div class="row">
            <div class="col-md-6">
               <?= $form->field($model, 'doi_tuong')->textInput() ?>
            </div>
            <div class ="col-md-6">
                <?= $form->field($model, 'loai_file')->textInput() ?>
            </div>
      </div>
      <div class ="row">
            <div class="col-md-6">
                <?= $form->field($model, 'id_file')->textInput() ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'id_kho')->textInput() ?>
            </div>
      </div>
      <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'id_ke')->textInput() ?> 
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'id_ngan')->textInput() ?>
            </div>
      </div>
      <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'id_hop')->textInput() ?>
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
    .luu-kho-form label {
    font-weight: bold;
}
</style>