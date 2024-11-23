<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

use kartik\time\TimePicker;

?>

<div class="config-loai-hinh-thue-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'ten_loai_hinh_thue')->dropDownList(
                [
                    'Buổi' => 'Buổi',
                    'Ngày' => 'Ngày',
                    '1 Ngày 1 Đêm' =>'1 Ngày 1 Đêm',
                ],
                [
                    'prompt' => 'Chọn loại hình thuê',
                    'id' => 'loai-hinh-thue',
                ]
            ) ?>
        </div>
        <div class="col-md-6">
             <div id="buoi-options" style="display: none;">
                 <?= $form->field($model, 'buoi')->dropDownList(
                    [
                       'Sáng' => 'Sáng',
                       'Trưa' => 'Trưa',
                       'Chiều' => 'Chiều',
                    ],
                 ['prompt' => 'Chọn buổi']
                  ) ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
             <?= $form->field($model, 'gio_bat_dau')->widget(TimePicker::class, [
                'pluginOptions' => [
                'showSeconds' => false,
                'showMeridian' => false,
                'minuteStep' => 1,
              ],
             ]) ?>
        </div>
        <div class="col-md-6">
             <?= $form->field($model, 'gio_ket_thuc')->widget(TimePicker::class, [
                'pluginOptions' => [
                'showSeconds' => false,
                'showMeridian' => false,
                'minuteStep' => 1,
              ],
             ]) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<?php
$script = <<< JS
$('#loai-hinh-thue').on('change', function () {
    if ($(this).val() === 'Buổi') {
        $('#buoi-options').show();
    } else {
        $('#buoi-options').hide();
    }
});
JS;
$this->registerJs($script);
?>

