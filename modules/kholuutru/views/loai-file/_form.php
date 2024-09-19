<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\kholuutru\models\LoaiFile */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="loai-file-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ten_loai')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ho_so_bat_buoc')->checkbox() ?>

    <?= $form->field($model, 'ghi_chu')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'doi_tuong')->textInput(['readonly' => true, 'value'=>($model->isNewRecord?$doiTuong:$model->doi_tuong)]) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
         
</div>
<style>
    .loai-file-form .form-control {
    border-color: #0000FF; 
    border-width: 1px; 
}
.loai-file-form label {
    font-weight: bold;
}
</style>