<?php

use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\modules\thuexe\models\base\LoaiGiayToBase;

/* @var $this yii\web\View */
/* @var $model app\modules\thuexe\models\search\LoaiGiayToSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="loai-giay-to-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1,
            'class' => 'myFilterForm'
        ],
    ]); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'ten_loai_giay_to') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'check_het_han')->dropDownList(LoaiGiayToBase::getDmCheckHetHan(), ['prompt' => '-- Tất cả --']) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Tìm kiếm', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Xóa tìm kiếm', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
