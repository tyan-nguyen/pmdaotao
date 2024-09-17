<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use app\custom\CustomFunc;
use app\modules\hocvien\models\HangDaoTao;
/* @var $this yii\web\View */
/* @var $model app\modules\khoahoc\models\KhoaHoc */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
$model->ngay_bat_dau = CustomFunc::convertYMDToDMY($model->ngay_bat_dau);
$model->ngay_ket_thuc = CustomFunc::convertYMDToDMY($model->ngay_ket_thuc);
?>
<div class="khoa-hoc-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class='row'>
         <div class ="col-md-6">
         <?= $form->field($model, 'id_hang')->dropDownList(
            HangDaoTao::getList(), 
                [
                 'prompt' => 'Chọn hạng',
                 'class' => 'form-control dropdown-with-arrow',
                ]
        ) ?>
         </div>
       
         <div class="col-md-6">
              <?= $form->field($model, 'ten_khoa_hoc')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class='row'>
        <div class="col-md-6">
             <?= $form->field($model, 'ngay_bat_dau')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Chọn ngày bắt đầu  ...'],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd/mm/yyyy',
            ]
               ]); ?>
       </div>
       <div class="col-md-6">
              <?= $form->field($model, 'ngay_ket_thuc')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Chọn ngày kết thúc  ...'],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd/mm/yyyy',
            ]
               ]); ?>
      </div>
    </div>
    <div class='row'>
        <div class='col-md-12'>
        <?= $form->field($model, 'ghi_chu')->textarea(['rows' => 6, 'placeholder' => 'Nhập ghi chú']) ?>
        </div>
    </div>
   

  

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
<style>
       .khoa-hoc-form label {
    font-weight: bold;
}
</style>