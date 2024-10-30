<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\widgets\CardWidget;
/* @var $this yii\web\View */
/* @var $model app\modules\thuexe\models\LoaiXe */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="loai-xe-form">

    <?php $form = ActiveForm::begin(); ?>  

    <?php CardWidget::begin(['title'=>'Thông tin Loại xe']) ?>

    <?= $form->field($model, 'ten_loai_xe')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ghi_chu')->textarea(['rows' => 6]) ?>

    <?php CardWidget::end() ?>
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
<style>
 .loai-xe-form label {
    font-weight: bold;
}
</style>
