<?php

use app\custom\CustomFunc;
use kartik\date\DatePicker;
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

$model->ngay_thi = CustomFunc::convertYMDToDMY($model->ngay_thi);

/* @var $this yii\web\View */
/* @var $model app\modules\hocvien\models\FileThiXeMay */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="file-thi-xe-may-search">

    <?php $form = ActiveForm::begin([
        'id' => 'myFilterForm',
        'method' => 'post',
        'options' => [
            'class' => 'myFilterForm'
        ]
    ]); ?>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'ten_khoa_thi')->textInput() ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'ngay_thi')->widget(DatePicker::classname(), [
                'options' => [
                    'placeholder' => 'Chọn ngày thi ...',
                    'autocomplete' => 'off'
                ],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd/mm/yyyy',
                    'zIndexOffset' => '9999',
                    'todayHighlight' => true,
                    'todayBtn' => true
                ]
            ]); ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'filename')->textInput(['maxlength' => true]) ?>
        </div>
        <!-- <div class="col-md-4">    
    	<?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-4">    
    	<?= $form->field($model, 'nguoi_tao')->textInput() ?>
    </div>
    <div class="col-md-4">    
    	<?= $form->field($model, 'thoi_gian_tao')->textInput() ?>
    </div>-->
        <div class="col-md-2">
            <?= $form->field($model, 'ghi_chu')->textInput() ?>
        </div>
        <div class="col-md-3" style="padding-top:5px">
            <br />
            <?= Html::submitButton('<i class="fa fa-search"></i> Tìm kiếm', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>