<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

?>

<div class="loai-hinh-thue-search">

<?php $form = ActiveForm::begin(); ?>
<div class="row" style="text-align: left;">
    <div class="col-md-3">
         <?= $form->field($model, 'loai_hinh_thue')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-3">
         <?= $form->field($model, 'id_loai_xe')->textInput() ?>
    </div>
    <div class="col-md-3">    
         <?= $form->field($model, 'gia_thue')->textInput() ?>
    </div>
    <div class="col-md-3">
         <?= $form->field($model, 'ngay_ap_dung')->textInput() ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'ngay_ket_thuc')->textInput() ?>
    </div>
    <div class="col-md-3">
             <?= $form->field($model, 'dang_ap_dung', [
                  'template' => "{label}<br>{input}\n{error}",
                   ])->checkbox(['class' => 'form-check-input ','id'=>'gray-checkbox'], false) ?>
    </div>
</div>

    <?php if (!Yii::$app->request->isAjax){ ?>
    <div class="col-md-12 text-left">
        <div class="form-group mb-0">
	        <?= Html::submitButton('<i class="fe fe-search"></i> Tìm kiếm',['class' => 'btn btn-primary']) ?>
	        <?= Html::resetButton('<i class="fe fe-x"></i> Xóa tìm kiếm', ['class' => 'btn btn-info']) ?>
	    </div>
    </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>

<style>
.loai-hinh-thue-search label {
    font-weight: bold;

}
</style>
