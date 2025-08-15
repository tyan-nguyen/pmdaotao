<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\thuexe\models\PhieuThu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="phieu-thu-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<div class="row">
            <div class="col-md-4">
        <?= $form->field($model, 'id_lich_thue')->textInput() ?>
        </div>
        <div class="col-md-4">
        <?= $form->field($model, 'loai_phieu')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
        <?= $form->field($model, 'so_tien')->textInput() ?>
        </div>
        <div class="col-md-4">
        <?= $form->field($model, 'chiet_khau')->textInput() ?>
        </div>
        <div class="col-md-4">
        <?= $form->field($model, 'so_tien_con_lai')->textInput() ?>
        </div>
        <div class="col-md-4">
        <?= $form->field($model, 'ma_so_phieu')->textInput() ?>
        </div>
        <div class="col-md-4">
        <?= $form->field($model, 'so_lan_in_phieu')->textInput() ?>
        </div>
        <div class="col-md-4">
        <?= $form->field($model, 'hinh_thuc_thanh_toan')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
        <?= $form->field($model, 'nguoi_tao')->textInput() ?>
        </div>
        <div class="col-md-4">
        <?= $form->field($model, 'thoi_gian_tao')->textInput() ?>
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
