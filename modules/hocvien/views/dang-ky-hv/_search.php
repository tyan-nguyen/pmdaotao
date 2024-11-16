
<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

use app\modules\hocvien\models\HangDaoTao;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\modules\vanban\models\VanBanDen */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="hoc-vien-search">

    <?php $form = ActiveForm::begin([
        	'id'=>'myFilterForm',
            'method' => 'get',
            'options' => [
                'class' => 'myFilterForm'
            ]
      	]); ?>
    <div class="row">
           <div class="col-md-3">
                  <?= $form->field($model, 'ho_ten')->textInput(['maxlength' => true]) ?>
           </div>
            <div class="col-md-3">
                  <?= $form->field($model, 'gioi_tinh')->dropDownList([
                          1 => 'Nam',
                          0 => 'Nữ',
                          ], ['prompt' => 'Chọn giới tính', 'class' => 'form-control dropdown-with-arrow']) ?>
            </div>
            <div class="col-md-3">
                  <?= $form->field($model, 'ngay_sinh')->widget(DatePicker::classname(), [
                         'options' => ['placeholder' => 'Chọn ngày sinh  ...'],
                         'pluginOptions' => [
                         'autoclose' => true,
                         'format' => 'dd/mm/yyyy',
                  ]
                  ]); ?>
            </div>
            <div class="col-md-3">
                  <?= $form->field($model, 'so_cccd')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-3">
                  <?= $form->field($model, 'dia_chi')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-3">
                  <?= $form->field($model, 'so_dien_thoai')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-3">
                  <?= $form->field($model, 'id_hang')->dropDownList(HangDaoTao::getList(), ['prompt'=>'Chọn hạng']) ?>
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
    .hoc-vien-search label {
    font-weight: bold;
}
</style>