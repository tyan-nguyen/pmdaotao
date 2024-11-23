<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\modules\kholuutru\models\Ngan;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model app\modules\kholuutru\models\LoaiFile */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="hop-search">

    <?php $form = ActiveForm::begin([
        	'id'=>'myFilterForm',
            'method' => 'get',
            'options' => [
                'class' => 'myFilterForm'
            ]
      	]); ?>
    <div class="row">
         <div class="col-md-3">
               <?= $form->field($model, 'ten_hop')->textInput(['maxlength' => true]) ?>
         </div>
         <div class="col-md-3">
             <?= $form->field($model, 'id_ngan')->widget(Select2::classname(), [
                 'data' => Ngan::getList(),
                    'language' => 'vi',
                    'options' => ['placeholder' => 'Chọn ngăn...'],  
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
             ]);?> 
         </div>
    </div>

    <?php if (!Yii::$app->request->isAjax){ ?>
    <div class="col-md-12 text-left">
        <div class="form-group mb-0">
	        <?= Html::submitButton('<i class="fe fe-search"></i> Tìm kiếm',['class' => 'btn btn-primary']) ?>
	        <?= Html::resetButton('<i class="fe fe-x"></i> Xóa tìm kiếm', ['class' => 'btn btn-info']) ?>
	    </div>
    </div>
    <?php } ?>
    <?php ActiveForm::end(); ?> 
</div>
<style>
    .select2-container {
        width: 100% !important;  
        display: block;
    }
</style>
