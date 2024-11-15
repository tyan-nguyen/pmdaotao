<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\vanban\models\DmLoaiVanBan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dm-loai-van-ban-search">

    <?php $form = ActiveForm::begin([
        	'id'=>'myFilterForm',
            'method' => 'get',
            'options' => [
                'class' => 'myFilterForm'
            ]
      	]); ?>
	
    <div class="row">
    	<div class="col-md-6">
        	<?= $form->field($model, 'ten_loai')->textInput(['maxlength' => true]) ?>
    	</div>
    	<div class="col-md-6">
        	<?= $form->field($model, 'ghi_chu')->textInput(['maxlength' => true]) ?>
    	</div>
    </div>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	<div class="col-md-12 text-center">
	  	<div class="form-group">
	        <?= Html::submitButton('Tìm kiếm',['class' => 'btn btn-primary']) ?>
	        <?= Html::resetButton('Xóa tìm kiếm', ['class' => 'btn btn-outline-secondary']) ?>
	    </div>
	</div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
