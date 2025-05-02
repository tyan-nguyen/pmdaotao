<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\hocvien\models\NopHocPhi */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="nop-hoc-phi-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_hoc_vien')->textInput() ?>

    <?= $form->field($model, 'id_hoc_phi')->textInput() ?>

    <?= $form->field($model, 'loai_phieu')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'loai_nop')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'so_tien_nop')->textInput() ?>

    <?= $form->field($model, 'chiet_khau')->textInput() ?>

    <?= $form->field($model, 'so_tien_con_lai')->textInput() ?>

    <?= $form->field($model, 'ngay_nop')->textInput() ?>

    <?= $form->field($model, 'ma_so_phieu')->textInput() ?>

    <?= $form->field($model, 'so_lan_in_phieu')->textInput() ?>

    <?= $form->field($model, 'hinh_thuc_thanh_toan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nguoi_thu')->textInput() ?>

    <?= $form->field($model, 'bien_lai')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'nguoi_tao')->textInput() ?>

    <?= $form->field($model, 'thoi_gian_tao')->textInput() ?>

    <?= $form->field($model, 'da_kiem_tra')->textInput() ?>

    <?= $form->field($model, 'ghi_chu')->textarea(['rows' => 6]) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
