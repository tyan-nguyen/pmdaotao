<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\modules\thuexe\models\LichThi;
use app\custom\CustomFunc;

/* @var $this yii\web\View */
/* @var $model app\modules\thuexe\models\LichThi */
/* @var $form yii\widgets\ActiveForm */
$oldBd = $model->thoi_gian_bd;
$oldKt = $model->thoi_gian_kt;
if(!$model->isNewRecord){
    if($model->thoi_gian_bd!=null)
        $model->thoi_gian_bd = CustomFunc::convertDMYHISToYMDHIS($model->thoi_gian_bd);
    if($model->thoi_gian_kt!=null)
        $model->thoi_gian_kt = CustomFunc::convertDMYHISToYMDHIS($model->thoi_gian_kt);
}
?>

<div class="lich-thi-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<div class="row">
        <div class="col-md-4">
        	<?= $form->field($model, 'phan_loai')->dropDownList(LichThi::getDmLoai()) ?>
        </div>
        <div class="col-md-8">
        	<?= $form->field($model, 'ten_ky_thi')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
        	<?= $form->field($model, 'thoi_gian_bd')->textInput(['id'=>'timeBd']) ?>
        </div>
        <div class="col-md-6">
        	<?= $form->field($model, 'thoi_gian_kt')->textInput(['id'=>'timeKt']) ?>
        </div>
        <div class="col-md-12">
        	<?= $form->field($model, 'ghi_chu')->textarea(['rows' => 3]) ?>
        </div>
  
	</div>
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>

<script>
//var fp = flatpickr.localize(flatpickr.l10ns.vn);
var fp = $("#timeBd").flatpickr({
	enableTime: true,
	enableSeconds: true, // This enables the seconds input
    dateFormat: "d/m/Y H:i:s",
    time_24hr: true,
    allowInput: true
});
fp.setDate(new Date("<?= $oldBd ?>"));
var fp2 = $("#timeKt").flatpickr({
	enableTime: true,
	enableSeconds: true, // This enables the seconds input
    dateFormat: "d/m/Y H:i:s",
    time_24hr: true,
    allowInput: true
});
fp2.setDate(new Date("<?= $oldKt ?>"));
</script>
