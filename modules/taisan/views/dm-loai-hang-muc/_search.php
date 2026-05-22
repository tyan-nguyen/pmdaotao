<?php

use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\taisan\models\DmLoaiHangMuc */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dm-loai-hang-muc-search">

  <?php $form = ActiveForm::begin([
    'id' => 'myFilterForm',
    'method' => 'post',
    'options' => [
      'class' => 'myFilterForm'
    ]
  ]); ?>
  <div class="row">
    <div class="col-md-4">
      <?= $form->field($model, 'ten')->textInput() ?>
    </div>
    <div class="col-md-4">
      <?= $form->field($model, 'ghi_chu')->textInput() ?>
    </div>
    <div class="col-md-4">
      <br />
      <?= Html::submitButton('Tìm kiếm', ['class' => 'btn btn-primary', 'style' => 'margin-top:5px']) ?>
    </div>
  </div>

  <?php ActiveForm::end(); ?>

</div>