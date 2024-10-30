<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\thuexe\models\PhieuThueXe */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="phieu-thue-xe-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ngay_thue_xe')->textInput() ?>

    <?= $form->field($model, 'id_hoc_vien')->textInput() ?>

    <?= $form->field($model, 'ho_ten_nguoi_thue')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'so_cccd_nguoi_thue')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dia_chi_nguoi_thue')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'so_dien_thoai_nguoi_thue')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_xe')->textInput() ?>

    <?= $form->field($model, 'id_loai_hinh_thue')->textInput() ?>

    <?= $form->field($model, 'thoi_gian_bat_dau_thue')->textInput() ?>

    <?= $form->field($model, 'thoi_gian_tra_xe_du_kien')->textInput() ?>

    <?= $form->field($model, 'chi_phi_thue_du_kien')->textInput() ?>

    <?= $form->field($model, 'thoi_gian_tra_xe')->textInput() ?>

    <?= $form->field($model, 'chi_phi_thue')->textInput() ?>

    <?= $form->field($model, 'id_nhan_vien_cho_thue')->textInput() ?>

    <?= $form->field($model, 'noi_dung_thue')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'ngay_tra_xe')->textInput() ?>

    <?= $form->field($model, 'tinh_trang_xe_khi_tra')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'id_nhan_vien_ky_tra')->textInput() ?>

    <?= $form->field($model, 'id_nguoi_gui')->textInput() ?>

    <?= $form->field($model, 'thoi_gian_gui')->textInput() ?>

    <?= $form->field($model, 'ghi_chu_nguoi_gui')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'id_nguoi_duyet')->textInput() ?>

    <?= $form->field($model, 'thoi_gian_duyet')->textInput() ?>

    <?= $form->field($model, 'ghi_chu_nguoi_duyet')->textInput() ?>

    <?= $form->field($model, 'trang_thai')->textInput(['maxlength' => true]) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
