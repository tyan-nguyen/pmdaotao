<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\kholuutru\models\LuuKho */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="luu-kho-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_kho')->textInput() ?>

    <?= $form->field($model, 'id_ke')->textInput() ?>

    <?= $form->field($model, 'id_ngan')->textInput() ?>

    <?= $form->field($model, 'id_hop')->textInput() ?>

    <?= $form->field($model, 'nguoi_tao')->textInput() ?>

    <?= $form->field($model, 'thoi_gian_tao')->textInput() ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
