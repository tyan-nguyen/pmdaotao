<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\VanBan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="van-ban-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_loai_van_ban')->textInput() ?>

    <?= $form->field($model, 'so_vb')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ngay_ky')->textInput() ?>

    <?= $form->field($model, 'trich_yeu')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nguoi_ky')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vbden_ngay_den')->textInput() ?>

    <?= $form->field($model, 'vbden_so_den')->textInput() ?>

    <?= $form->field($model, 'vbden_nguoi_nhan')->textInput() ?>

    <?= $form->field($model, 'vbden_ngay_chuyen')->textInput() ?>

    <?= $form->field($model, 'vbdi_noi_nhan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vbdi_so_luong_ban')->textInput() ?>

    <?= $form->field($model, 'vbdi_ngay_chuyen')->textInput() ?>

    <?= $form->field($model, 'ghi_chu')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nguoi_tao')->textInput() ?>

    <?= $form->field($model, 'thoi_gian_tao')->textInput() ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
