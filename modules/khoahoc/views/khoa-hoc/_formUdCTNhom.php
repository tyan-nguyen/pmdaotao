<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;


$this->registerCssFile('@web/css/hocphiKH.css', [
    'depends' => [\yii\bootstrap5\BootstrapAsset::className()],
]);
$idKhoaHoc= $model->id_khoa_hoc;
?>
                 

<div class="chi-tiet-nhom-form">

    <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-md-4">
                 <?= $form->field($model, 'ten_nhom')->textInput(['maxlength' => true]) ?>
             </div>
            <div class="col-md-4">
                <?= $form->field($model,'so_luong_hoc_vien')->textInput(['maxlength'=>true])?>
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
    .select2-dropdown {
     z-index: 12000 !important; 
}
</style>
