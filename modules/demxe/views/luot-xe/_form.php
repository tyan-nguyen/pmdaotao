<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\demxe\models\DemXe */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dem-xe-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<div class="row">
            <div class="col-md-4">
        <?= $form->field($model, 'id_xe')->textInput() ?>
        </div>
        <div class="col-md-4">
        <?= $form->field($model, 'ma_xe')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
        <?= $form->field($model, 'ma_cong')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
        <?= $form->field($model, 'thoi_gian_bd')->textInput() ?>
        </div>
        <div class="col-md-4">
        <?= $form->field($model, 'thoi_gian_kt')->textInput() ?>
        </div>
        <div class="col-md-4">
        <?= $form->field($model, 'so_gio')->textInput() ?>
        </div>
        <div class="col-md-4">
        <?= $form->field($model, 'so_phut')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
        <?= $form->field($model, 'nguoi_tao')->textInput() ?>
        </div>
        <div class="col-md-4">
        <?= $form->field($model, 'thoi_gian_tao')->textInput() ?>
        </div>
        <div class="col-md-4">
        <?= $form->field($model, 'id_file')->textInput() ?>
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
