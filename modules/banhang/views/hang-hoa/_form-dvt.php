<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
?>

<div class="dvt-form">

     <?php $form = ActiveForm::begin([
        'action' => '/hanghoa/hang-hoa/create-dvt',
    ]); ?>

    <?= $form->field($model, 'ten_dvt')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ghi_chu')->textarea(['rows' => 3]) ?>

    <?php ActiveForm::end(); ?>
    
</div>
