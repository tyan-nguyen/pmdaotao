<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\custom\CustomFunc;
/* @var $this yii\web\View */
/* @var $model app\modules\thuexe\models\PhieuThueXe */
/* @var $form yii\widgets\ActiveForm */
?>

<?php

$model->ngay_thue_xe = CustomFunc::convertYMDToDMY($model->ngay_thue_xe);
?>

<div class="phieu-thue-xe-form">

    <?php $form = ActiveForm::begin(); ?>
       <div class="row">
           <div class="col-md-12">
                  <?= $form->field($model, 'ghi_chu_nguoi_gui')->textarea(['rows' => 6]) ?>
           </div>
       </div>
     
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>

<style>
 .phieu-thue-xe-form label {
   color:blue;
}
</style>