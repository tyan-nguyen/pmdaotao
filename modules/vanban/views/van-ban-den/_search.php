<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\VanBanSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="van-ban-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_loai_van_ban') ?>

    <?= $form->field($model, 'so_vb') ?>

    <?= $form->field($model, 'ngay_ky') ?>

    <?= $form->field($model, 'trich_yeu') ?>

    <?php // echo $form->field($model, 'nguoi_ky') ?>

    <?php // echo $form->field($model, 'vbden_ngay_den') ?>

    <?php // echo $form->field($model, 'vbden_so_den') ?>

    <?php // echo $form->field($model, 'vbden_nguoi_nhan') ?>

    <?php // echo $form->field($model, 'vbden_ngay_chuyen') ?>

    <?php // echo $form->field($model, 'vbdi_noi_nhan') ?>

    <?php // echo $form->field($model, 'vbdi_so_luong_ban') ?>

    <?php // echo $form->field($model, 'vbdi_ngay_chuyen') ?>

    <?php // echo $form->field($model, 'ghi_chu') ?>

    <?php // echo $form->field($model, 'nguoi_tao') ?>

    <?php // echo $form->field($model, 'thoi_gian_tao') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
