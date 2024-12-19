
<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

use kartik\date\DatePicker;

use app\widgets\CardWidget;

/* @var $this yii\web\View */
/* @var $model app\models\HvHocVien */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="hv-nhom-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php CardWidget::begin(['title'=>'Thêm nhóm học']) ?>
   <div class ='row'>
        <div class="col-md-4">
            <?= $form->field($model, 'ten_nhom')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
           <?= $form->field($model, 'ghi_chu')->textarea(['rows' => 8]) ?>
        </div>
            
    </div>
    <?php CardWidget::end() ?>
</div>
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>
    <?php ActiveForm::end(); ?>
</div>
