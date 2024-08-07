<?php
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use app\modules\user\models\User;

/* @var $this yii\web\View */
/* @var $model app\modules\kholuutru\models\KhoLuuTru */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="kho-luu-tru-search">

    <?php $form = ActiveForm::begin([
            'id'=>'myFilterForm',
            'method' => 'post',
            'options' => [
                'class' => 'myFilterForm form-horizontal'
            ],
            'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => '<div class="col-sm-4">{label}</div><div class="col-sm-8">{input}{error}</div>',
                'labelOptions' => ['class' => 'col-md-12 control-label'],
            ],
      	]); ?>

          <?= $form->field($model->loadDefaultValues(), 'status')
        		->dropDownList(User::getStatusList()) ?>
        
            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
        
            <?php // $form->field($model, 'status')->textInput() ?>
        
            <?= $form->field($model, 'bind_to_ip')->textInput(['maxlength' => true]) ?>
        
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton('Tìm kiếm',['class' => 'btn btn-primary']) ?>
	        <?= Html::resetButton('Xóa tìm kiếm', ['class' => 'btn btn-outline-secondary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
