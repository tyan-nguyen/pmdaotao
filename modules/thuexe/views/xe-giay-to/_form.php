<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\widgets\CardWidget;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use app\modules\thuexe\models\XeGiayTo;
use app\modules\thuexe\models\LoaiGiayTo;
use app\modules\thuexe\models\base\XeGiayToBase;

/* @var $this yii\web\View */
/* @var $model app\modules\thuexe\models\XeGiayTo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="xe-giay-to-form">

    <?php $form = ActiveForm::begin(); ?>  

    <?php CardWidget::begin(['title' => 'Thông tin Giấy tờ xe']) ?>
    
    <?php if (Yii::$app->request->get('modalType')): ?>
        <input type="hidden" name="modalType" value="<?= Html::encode(Yii::$app->request->get('modalType')) ?>">
    <?php endif; ?>

    <div class="row">
        <div class="col-md-6">
            <?php if ($model->id_xe && Yii::$app->request->get('id_xe')): ?>
                <?= $form->field($model, 'id_xe')->hiddenInput()->label(false) ?>
                <div class="mb-3">
                    <label class="form-label font-weight-bold">Xe</label>
                    <input type="text" class="form-control" value="<?= $model->xe ? $model->xe->bien_so_xe . ' - ' . $model->xe->hieu_xe : '' ?>" readonly disabled>
                </div>
            <?php else: ?>
                <?= $form->field($model, 'id_xe')->dropDownList(
                    XeGiayTo::getListXe(),
                    ['prompt' => '-- Chọn xe --', 'class' => 'form-select']
                ) ?>
            <?php endif; ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'id_loai_giay_to')->dropDownList(
                LoaiGiayTo::getListLoaiGiayTo(),
                ['prompt' => '-- Chọn loại giấy tờ --', 'class' => 'form-select']
            ) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'ngay_bat_dau')->widget(DatePicker::classname(), [
                'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                'options' => ['placeholder' => 'dd/mm/yyyy', 'autocomplete' => 'off'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd/mm/yyyy',
                    'todayHighlight' => true,
                ],
            ]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'ngay_ket_thuc')->widget(DatePicker::classname(), [
                'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                'options' => ['placeholder' => 'dd/mm/yyyy', 'autocomplete' => 'off'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd/mm/yyyy',
                    'todayHighlight' => true,
                ],
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'is_active')->dropDownList(XeGiayToBase::getDmIsActive()) ?>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'ghi_chu')->textarea(['rows' => 4, 'placeholder' => 'Ghi chú thêm...']) ?>
        </div>
    </div>

    <?php CardWidget::end() ?>

    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group mt-3">
            <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
<style>
.xe-giay-to-form label {
    font-weight: bold;
}
.xe-giay-to-form .input-group-text {
    cursor: pointer;
}
</style>
<?php
$js = <<<JS
$('.field-xegiayto-ngay_bat_dau .input-group-text, .field-xegiayto-ngay_ket_thuc .input-group-text').on('click', function() {
    $(this).siblings('input.krajee-datepicker').focus();
});
JS;
$this->registerJs($js);
?>
