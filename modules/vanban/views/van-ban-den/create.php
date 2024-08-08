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

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'so_vb')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'ngay_ky')->input('date') ?>
    <?= $form->field($model, 'trich_yeu')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'nguoi_ky')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'vbden_ngay_den')->input('date') ?>
    <?= $form->field($model, 'vbden_so_den')->textInput() ?>
    <?= $form->field($model, 'vbden_nguoi_nhan')->textInput() ?>
    <?= $form->field($model, 'vbden_ngay_chuyen')->input('date') ?>
    <?= $form->field($model, 'ghi_chu')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Thêm' : 'Sửa', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
