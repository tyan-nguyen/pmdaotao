<?php

use app\modules\taisan\models\DmLoaiHangMuc;
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\taisan\models\DmHangMuc */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dm-hang-muc-search">

    <?php $form = ActiveForm::begin([
        'id' => 'myFilterForm',
        'method' => 'post',
        'options' => [
            'class' => 'myFilterForm'
        ]
    ]); ?>
    <div class="row">
        <div class="col-md-2">
            <?= $form->field($model, 'id_loai_hang_muc')->dropDownList(DmLoaiHangMuc::getList(), ['prompt' => 'Chọn loại hạng mục']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'ten')->textInput() ?>
        </div>
        <div class="col-md-1">
            <?= $form->field($model, 'dvt')->textInput() ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'ghi_chu')->textInput() ?>
        </div>
        <div class="col-md-3">
            <br />
            <?= Html::submitButton('Tìm kiếm', ['class' => 'btn btn-primary', 'style' => 'margin-top:5px']) ?>
        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>