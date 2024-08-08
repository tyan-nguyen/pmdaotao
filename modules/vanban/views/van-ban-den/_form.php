<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\VanBan */
/* @var $form yii\widgets\ActiveForm */

$this->title = $model->isNewRecord ? 'Thêm Văn Bản Đến' : 'Sửa Văn Bản Đến';
$this->params['breadcrumbs'][] = ['label' => 'Danh sách văn bản đến', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="van-ban-form">

   

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'so_vb')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'ngay_ky')->input('date') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'trich_yeu')->textarea(['rows' => 6]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'nguoi_ky')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'vbden_ngay_den')->input('date') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'vbden_so_den')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'vbden_nguoi_nhan')->textInput() ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'vbden_ngay_chuyen')->input('date') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'ghi_chu')->textarea(['rows' => 6]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Lưu' : 'Sửa', [
            'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
            'style'=>'text-align:center',
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

