<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\HvKhoaHoc */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="hv-khoa-hoc-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_hang')->textInput() ?>

    <?= $form->field($model, 'ten_khoa_hoc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ngay_bat_dau')->textInput() ?>

    <?= $form->field($model, 'ngay_ket_thuc')->textInput() ?>

    <?= $form->field($model, 'ghi_chu')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'trang_thai')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nguoi_tao')->textInput() ?>

    <?= $form->field($model, 'thoi_gian_tao')->textInput() ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
