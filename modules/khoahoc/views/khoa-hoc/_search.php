
<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

use app\modules\hocvien\models\HangDaoTao;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\modules\vanban\models\VanBanDen */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="khoa-hoc-search">

    <?php $form = ActiveForm::begin([
        	'id'=>'myFilterForm',
            'method' => 'get',
            'options' => [
                'class' => 'myFilterForm'
            ]
      	]); ?>
    <div class='row'>
        <div class="col-md-3">
              <?= $form->field($model, 'ten_khoa_hoc')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
              <?= $form->field($model, 'id_hang')->dropDownList(HangDaoTao::getList(), ['prompt'=>'Chọn hạng']) ?>
        </div>
        <div class="col-md-3">   
             <?= $form->field($model, 'ngay_bat_dau')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Chọn ngày bắt đầu  ...'],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd/mm/yyyy',
            ]
               ]); ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'ngay_ket_thuc')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Chọn ngày kết thúc  ...'],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd/mm/yyyy',
            ]
               ]); ?>
        </div>
    </div>

    <?php if (!Yii::$app->request->isAjax){ ?>
    <div class="col-md-12 text-center">
        <div class="form-group mb-0">
	        <?= Html::submitButton('<i class="fe fe-search"></i> Tìm kiếm',['class' => 'btn btn-primary']) ?>
	        <?= Html::resetButton('<i class="fe fe-x"></i> Xóa tìm kiếm', ['class' => 'btn btn-info']) ?>
	    </div>
    </div>
    <?php } ?>


    <?php ActiveForm::end(); ?>
    
</div>
<style>
    .khoa-hoc-search label {
    font-weight: bold;
}
</style>