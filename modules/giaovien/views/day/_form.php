<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\modules\hocvien\models\HangDaoTao;
/* @var $this yii\web\View */
/* @var $model app\modules\giaovien\models\Day */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="day-form">

    <?php $form = ActiveForm::begin(); ?>

   
    <?= $form->field($model, 'id_hang_xe')->dropDownList(
    HangDaoTao::getList(), 
    [
        'prompt' => 'Chọn hạng xe',
        'class' => 'form-control dropdown-with-arrow',
    ]
    ) ?>

    <?= $form->field($model, 'ly_thuyet')->checkbox() ?>

    <?= $form->field($model, 'thuc_hanh')->checkbox() ?>


  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
