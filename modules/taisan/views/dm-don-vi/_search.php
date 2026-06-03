<?php

use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\taisan\models\DmDonVi */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dm-don-vi-search">

  <?php $form = ActiveForm::begin([
    'id' => 'myFilterForm',
    'method' => 'post',
    'options' => [
      'class' => 'myFilterForm'
    ]
  ]); ?>
  <div class="row">
    <div class="col-md-1">
      <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-3">
      <?= $form->field($model, 'ten')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-1">
      <label>Sửa chữa</label>
      <?= $form->field($model, 'co_sua_chua')->checkbox(['label'=>false]) ?>
    </div>
    <div class="col-md-1">
      <label>Bán hàng</label>
      <?= $form->field($model, 'co_ban_hang')->checkbox(['label'=>false]) ?>
    </div>
    <div class="col-md-3">
      <?= $form->field($model, 'ghi_chu')->textInput() ?>
    </div>
    <div class="col-md-3">
      <br/>
       <?= Html::submitButton('Tìm kiếm', ['class' => 'btn btn-primary', 'style'=>'margin-top:5px']) ?>
        <?= Html::resetButton('Xóa TK', ['class' => 'btn btn-outline-secondary', 'style'=>'margin-top:5px']) ?>
    </div>
  </div>

  <?php ActiveForm::end(); ?>

</div>