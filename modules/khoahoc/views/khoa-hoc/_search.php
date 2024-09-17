<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

use kartik\date\DatePicker;


/* @var $this yii\web\View */
/* @var $model app\modules\vanban\models\VanBanDen */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="khoa-hoc-search">

    <?php $form = ActiveForm::begin([
        	'id'=>'myFilterForm',
            'method' => 'POST',
            'options' => [
                'class' => 'myFilterForm'
            ]
      	]); ?>

    <?= $form->field($model, 'ten_khoa_hoc')->textInput() ?>
    
    <?= $form->field($model, 'ngay_bat_dau')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => 'Chọn ngày đến ...'],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'dd/mm/yyyy',
        ]
    ]); ?>
     <?= $form->field($model, 'ngay_ket_thuc')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => 'Chọn ngày chuyển  ...'],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'dd/mm/yyyy',
        ]
        ]); ?>

    <?= $form->field($model, 'trang_thai')->textInput() ?>
    
       

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton('Tìm kiếm',['class' => 'btn btn-primary']) ?>
	        <?= Html::resetButton('Xóa tìm kiếm', ['class' => 'btn btn-outline-secondary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
<style>
    .khoa-hoc-search label {
    font-weight: bold;
}
</style>