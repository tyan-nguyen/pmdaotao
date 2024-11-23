<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

?>

<div class="loai-xe-search">


<?php $form = ActiveForm::begin([
        'id' => 'myFilterForm',
        'method' => 'get', 
        'options' => [
            'class' => 'myFilterForm'
        ]
]); ?>
<div class="col-md-3">
    <?= $form->field($model, 'ten_loai_xe')->textInput(['maxlength' => true]) ?>
</div>
<div class="row">
   <?php if (!Yii::$app->request->isAjax){ ?>
    <div class="col-md-12 text-left">
        <div class="form-group mb-0">
	        <?= Html::submitButton('<i class="fe fe-search"></i> Tìm kiếm',['class' => 'btn btn-primary']) ?>
	        <?= Html::resetButton('<i class="fe fe-x"></i> Xóa tìm kiếm', ['class' => 'btn btn-info']) ?>
	    </div>
    </div>
    <?php } ?>
</div>
    <?php ActiveForm::end(); ?>
    
</div>

<style>
.loai-xe-search label {
    font-weight: bold;
}
</style>
