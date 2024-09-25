<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\kholuutru\models\LuuKho */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="luu-kho-search">

    <?php $form = ActiveForm::begin([
        	'id'=>'myFilterForm',
            'method' => 'post',
            'options' => [
                'class' => 'myFilterForm'
            ]
      	]); ?>

    <?= $form->field($model, 'loai_file')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_file')->textInput() ?>

    <?= $form->field($model, 'id_kho')->textInput() ?>

    <?= $form->field($model, 'id_ke')->textInput() ?>

    <?= $form->field($model, 'id_ngan')->textInput() ?>

    <?= $form->field($model, 'id_hop')->textInput() ?>

    <?= $form->field($model, 'nguoi_tao')->textInput() ?>

    <?= $form->field($model, 'thoi_gian_tao')->textInput() ?>

    <?= $form->field($model, 'doi_tuong')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_doi_tuong')->textInput() ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton('Tìm kiếm',['class' => 'btn btn-primary']) ?>
	        <?= Html::resetButton('Xóa tìm kiếm', ['class' => 'btn btn-outline-secondary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
