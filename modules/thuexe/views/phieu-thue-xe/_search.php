<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

?>

<div class="phieu-thue-xe-search">

<?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-3">
             <?= $form->field($model, 'ngay_thue_xe')->textInput() ?>
        </div>
        <div class="col-md-3">
             <?= $form->field($model, 'id_hoc_vien')->textInput() ?>
        </div>
        <div class="col-md-3">
             <?= $form->field($model, 'ho_ten_nguoi_thue')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
             <?= $form->field($model, 'so_cccd_nguoi_thue')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
             <?= $form->field($model, 'dia_chi_nguoi_thue')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
             <?= $form->field($model, 'so_dien_thoai_nguoi_thue')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
             <?= $form->field($model, 'id_xe')->textInput() ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'id_loai_hinh_thue')->textInput() ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'id_nhan_vien_cho_thue')->textInput() ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'ngay_tra_xe')->textInput() ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'id_nhan_vien_ky_tra')->textInput() ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'id_nguoi_gui')->textInput() ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'id_nguoi_duyet')->textInput() ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'trang_thai')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <?php if (!Yii::$app->request->isAjax){ ?>
    <div class="col-md-12 text-center">
        <div class="form-group mb-0">
	        <?= Html::submitButton('<i class="fe fe-search"></i> Tìm kiếm',['class' => 'btn btn-primary']) ?>
	        <?= Html::resetButton('<i class="fe fe-x"></i> Xóa tìm kiếm', ['class' => 'btn btn-info']) ?>
	    </div>
    </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>

<style>
.phieu-thue-xe-search label {
    font-weight: bold;
}
</style>
