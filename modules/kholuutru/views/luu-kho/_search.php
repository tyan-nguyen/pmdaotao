<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\kholuutru\models\LoaiFile */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="loai-file-search">

    <?php $form = ActiveForm::begin([
        	'id'=>'myFilterForm',
            'method' => 'post',
            'options' => [
                'class' => 'myFilterForm'
            ]
      	]); ?>

<?= $form->field($model, 'id_kho')->textInput() ?>

<?= $form->field($model, 'id_ke')->textInput() ?>

<?= $form->field($model, 'id_ngan')->textInput() ?>

<?= $form->field($model, 'id_hop')->textInput() ?>

<?= $form->field($model, 'nguoi_tao')->textInput() ?>

<?= $form->field($model, 'thoi_gian_tao')->textInput() ?>


  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton('Tìm kiếm',['class' => 'btn btn-primary']) ?>
	        <?= Html::resetButton('Xóa tìm kiếm', ['class' => 'btn btn-outline-secondary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
