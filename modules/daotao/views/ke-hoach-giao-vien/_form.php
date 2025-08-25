<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\modules\giaovien\models\GiaoVien;
use kartik\date\DatePicker;
use app\modules\daotao\models\KeHoach;
use app\custom\CustomFunc;
use app\modules\user\models\User;

/* @var $this yii\web\View */
/* @var $model app\modules\daotao\models\KeHoach */
/* @var $form yii\widgets\ActiveForm */

if(!$model->isNewRecord){
    if($model->ngay_thuc_hien!=null)
        $model->ngay_thuc_hien = CustomFunc::convertYMDToDMY($model->ngay_thuc_hien);
    if($model->thoi_gian_duyet!=null)
        $model->thoi_gian_duyet = CustomFunc::convertYMDHISToDMYHIS($model->thoi_gian_duyet);
}

?>

<div class="ke-hoach-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<?= $form->errorSummary($model) ?>
	
	<div class="row">
        <div class="col-md-4">
        	<?= $form->field($model, 'ngay_thuc_hien')->widget(DatePicker::classname(), [
                 'options' => ['placeholder' => 'Chọn ngày thực hiện  ...'],
                 'pluginOptions' => [
                 'autoclose' => true,
                 'format' => 'dd/mm/yyyy',
                 'zIndexOffset'=>'9999',
                 'todayHighlight'=>true,
                 'todayBtn'=>true
              ]
            ]); ?>
        </div>
       
        <div class="col-md-4">
        	<?= $form->field($model, 'trang_thai_duyet')->dropDownList(
        	    $model->trang_thai_duyet!=KeHoach::TT_DADUYET?KeHoach::getDmTrangThaiForGiaoVien():                    [KeHoach::TT_HOANTHANH=>KeHoach::getLabelTrangThaiOther(KeHoach::TT_HOANTHANH)], [
        	    //'prompt'=>'-Tất cả-'
        	]) ?>  
        </div>
        
         <div class="col-md-12">
        	<?= $form->field($model, 'ghi_chu')->textarea(['rows'=>3]) ?>
        </div>
        <!-- <div class="col-md-4">
        	<?= $form->field($model, 'id_nguoi_duyet')->dropDownList(
        	    [Yii::$app->user->id => User::getCurrentUser()->username],
        	    ['prompt'=>'-Chọn-']
        	    ) ?>
        </div>
        
        <div class="col-md-4">
        	<?= $form->field($model, 'thoi_gian_duyet')->textInput(['id'=>'time'])?>
        </div>
        
        <div class="col-md-12">
        	<?= $form->field($model, 'noi_dung_duyet')->textarea(['rows' => 6]) ?>
        </div>
         -->
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
var fp = $("#time").flatpickr({
	enableTime: true,
    dateFormat: "d/m/Y H:i:ss",
    time_24hr: true,
    allowInput: true
});
fp.setDate(new Date("<?= $model->thoi_gian_duyet ?>"));
</script>
