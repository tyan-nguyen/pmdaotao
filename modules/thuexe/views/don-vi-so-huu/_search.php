<?php

use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\thuexe\models\search\DonViSoHuuSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="don-vi-so-huu-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1,
            'class' => 'myFilterForm'
        ],
    ]); ?>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'ten_don_vi') ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Tìm kiếm', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Xóa tìm kiếm', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
