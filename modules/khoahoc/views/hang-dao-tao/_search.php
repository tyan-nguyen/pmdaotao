<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

use kartik\date\DatePicker;


/* @var $this yii\web\View */
/* @var $model app\modules\vanban\models\VanBanDen */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="hang-dao-tao-search">

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'ten_hang')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'ghi_chu')->textarea(['rows' => 6]) ?>
    
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