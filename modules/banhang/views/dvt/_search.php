<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\banhang\models\DVT */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dvt-search">

    <?php $form = ActiveForm::begin([
        	'id'=>'myFilterForm',
            'method' => 'post',
            'options' => [
                'class' => 'myFilterForm'
            ]
      	]); ?>
	<div class="row">
<div class="col-md-4">    <?= $form->field($model, 'ten_dvt')->textInput(['maxlength' => true]) ?>

</div><div class="col-md-4">    <?= $form->field($model, 'ghi_chu')->textarea(['rows' => 6]) ?>

</div><div class="col-md-4">    <?= $form->field($model, 'nguoi_tao')->textInput() ?>

</div><div class="col-md-4">    <?= $form->field($model, 'thoi_gian_tao')->textInput() ?>

</div>  
	</div>
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton('Tìm kiếm',['class' => 'btn btn-primary']) ?>
	        <?= Html::resetButton('Xóa tìm kiếm', ['class' => 'btn btn-outline-secondary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
