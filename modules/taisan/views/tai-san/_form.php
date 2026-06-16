<?php

use app\modules\taisan\models\DanhMucTaiSan;
use app\modules\taisan\models\DmDonVi;
use app\modules\taisan\models\LoaiTaiSan;
use app\widgets\CardWidget;
use kartik\select2\Select2;
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\taisan\models\TaiSan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tai-san-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php CardWidget::begin(['title' => 'THÔNG TIN TÀI SẢN']) ?>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'ma_tai_san')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'ten_tai_san')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'model')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'serial')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'loai_tai_san_id')->widget(Select2::class, [
                'data' =>  LoaiTaiSan::getList(),
                'language' => 'vi',
                'options' => [
                    'placeholder' => 'Chọn loại tài sản...',
                    'class' => 'form-control dropdown-with-arrow',
                    'id' => 'idLoaiTaiSan'
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'width' => '100%',
                    'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'),
                ],
            ]); ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'danh_muc_id')->widget(Select2::class, [
                'data' =>  DanhMucTaiSan::getList(),
                'language' => 'vi',
                'options' => [
                    'placeholder' => 'Chọn danh mục...',
                    'class' => 'form-control dropdown-with-arrow',
                    'id' => 'idDanhMuc'
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'width' => '100%',
                    'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'),
                ],
            ]); ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'trang_thai')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-12">
            <?= $form->field($model, 'ghi_chu')->textarea(['rows' => 1]) ?>
        </div>
    </div>
    <?php CardWidget::end() ?>

    <?php CardWidget::begin(['title' => 'THÔNG TIN QUẢN LÝ']) ?>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'nha_cung_cap_id')->widget(Select2::class, [
                'data' =>  DmDonVi::getList('ban_hang'),
                'language' => 'vi',
                'options' => [
                    'placeholder' => 'Chọn đơn vị...',
                    'class' => 'form-control dropdown-with-arrow',
                    'id' => 'idNhaCungCap'
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'width' => '100%',
                    'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'),
                ],
            ]); ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'so_tien')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'so_hoa_don')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'so_hop_dong')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'ngay_mua')->textInput() ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'thoi_han_bao_hanh')->textInput() ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'ghi_chu_bao_hanh')->textarea(['rows' => 1]) ?>
        </div>
    </div>
    <?php CardWidget::end() ?>

    <?php CardWidget::begin(['title' => 'THÔNG TIN QUẢN LÝ']) ?>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'ngay_dua_vao_su_dung')->textInput() ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'muc_dich_su_dung')->textarea(['rows' => 1]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'nguoi_chiu_trach_nhiem_id')->textInput() ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'phong_ban_id')->textInput() ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'vi_tri_id')->textInput() ?>
        </div>
    </div>
    <?php CardWidget::end() ?>

    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>