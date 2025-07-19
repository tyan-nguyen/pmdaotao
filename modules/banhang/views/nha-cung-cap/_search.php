<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\banhang\models\NhaCungCap */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="nha-cung-cap-search">
    <?php $form = ActiveForm::begin([
        	'id'=>'myFilterForm',
            'method' => 'post',
            'options' => [
                'class' => 'myFilterForm'
            ]
      	]); ?>
	<div class="row">
        <div class="col-md-3">
        	<?= $form->field($model, 'ten_nha_cung_cap')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
        	<?= $form->field($model, 'so_dien_thoai')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
        	<?= $form->field($model, 'dia_chi')->textInput(['maxlength' => true]) ?>
        </div> 	
    	<div class="col-md-3">
    		<br/>
	        <?= Html::submitButton('Tìm kiếm',['class' => 'btn btn-primary']) ?>
	        <?= Html::resetButton('Xóa tìm kiếm', ['class' => 'btn btn-outline-secondary']) ?>
	    </div>	
	</div>
    <?php ActiveForm::end(); ?>
    
</div>
