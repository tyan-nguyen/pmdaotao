<?php

use app\custom\CustomFunc;
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\demxe\models\DemXe */
/* @var $form yii\widgets\ActiveForm */

$oldTGBD = $model->thoi_gian_bd;
$oldTGKT = $model->thoi_gian_kt;
if (!$model->isNewRecord) {
    if ($model->thoi_gian_bd != null)
        $model->thoi_gian_bd = CustomFunc::convertYMDHISToDMYHIS($model->thoi_gian_bd);
    if ($model->thoi_gian_kt != null)
        $model->thoi_gian_kt = CustomFunc::convertYMDHISToDMYHIS($model->thoi_gian_kt);
}

?>

<div class="dem-xe-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">

        <div class="col-md-6">
            <?= $form->field($model, 'thoi_gian_bd')->textInput(['id' => 'timebd']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'thoi_gian_kt')->textInput(['id' => 'timekt']) ?>
        </div>

        <div class="col-md-12">
            <?= $form->field($model, 'ghi_chu')->textarea(['rows' => 3]) ?>
        </div>

    </div>
    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>
<script>
    function pad(n) {
        return String(n).padStart(2, '0');
    }

    function formatFull(date) {
        return `${pad(date.getDate())}/${pad(date.getMonth()+1)}/${date.getFullYear()} ` +
            `${pad(date.getHours())}:${pad(date.getMinutes())}:${pad(date.getSeconds())}`;
    }
    //var fp = flatpickr.localize(flatpickr.l10ns.vn);
    var fp = $("#timebd").flatpickr({
        enableTime: true,
        enableSeconds: true, // This enables the seconds input
        dateFormat: "d/m/Y H:i:s",
        time_24hr: true,
        allowInput: true,
        minuteIncrement: 1,
        secondIncrement: 1,
        formatDate: function(date) {
            return formatFull(date);
        },

        onChange: function(selectedDates, dateStr, instance) {
            if (selectedDates.length) {
                instance.input.value = formatFull(selectedDates[0]);
            }
        }
    });

    fp.setDate(new Date("<?= $oldTGBD ?>"));

    var fp2 = $("#timekt").flatpickr({
        enableTime: true,
        enableSeconds: true, // This enables the seconds input
        dateFormat: "d/m/Y H:i:s",
        time_24hr: true,
        allowInput: true,
        minuteIncrement: 1,
        secondIncrement: 1,
        formatDate: function(date) {
            return formatFull(date);
        },

        onChange: function(selectedDates, dateStr, instance) {
            if (selectedDates.length) {
                instance.input.value = formatFull(selectedDates[0]);
            }
        }
    });

    fp2.setDate(new Date("<?= $oldTGKT ?>"));
</script>