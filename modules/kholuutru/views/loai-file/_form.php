<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\kholuutru\models\LoaiFile */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="loai-file-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'loai')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ho_so_bat_buoc')->textInput() ?>

    <?= $form->field($model, 'ghi_chu')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'nguoi_tao')->textInput() ?>

    <?= $form->field($model, 'thoi_gian_tao')->textInput() ?>

    <?= $form->field($model, 'doi_tuong')->textInput(['maxlength' => true]) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>