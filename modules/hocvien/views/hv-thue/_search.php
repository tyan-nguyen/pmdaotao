
<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

use app\modules\hocvien\models\HangDaoTao;
use kartik\date\DatePicker;
use app\modules\user\models\User;
use app\modules\khoahoc\models\KhoaHoc;
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
           <div class="col-md-2">
                  <?= $form->field($model, 'ho_ten')->textInput(['maxlength' => true]) ?>
           </div>
            <div class="col-md-1">
                  <?= $form->field($model, 'gioi_tinh')->dropDownList([
                          1 => 'Nam',
                          0 => 'Nữ',
                          ], ['prompt' => 'Chọn giới tính', 'class' => 'form-control dropdown-with-arrow']) ?>
            </div>
            <div class="col-md-2">
                  <?= $form->field($model, 'ngay_sinh')->widget(DatePicker::classname(), [
                         'options' => ['placeholder' => 'Chọn ngày sinh  ...'],
                         'pluginOptions' => [
                         'autoclose' => true,
                         'format' => 'dd/mm/yyyy',
                  ]
                  ]); ?>
            </div>
            <div class="col-md-2">
                  <?= $form->field($model, 'so_cccd')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-2">
                  <?= $form->field($model, 'dia_chi')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-2">
                  <?= $form->field($model, 'so_dien_thoai')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-2">
                  <?= $form->field($model, 'id_khoa_hoc')->dropDownList(KhoaHoc::getList(), ['prompt'=>'Tất cả']) ?>
            </div>
            <div class="col-md-2">
                  <?= $form->field($model, 'id_hang')->dropDownList(HangDaoTao::getList(), ['prompt'=>'Chọn hạng']) ?>
            </div>
            <div class="col-md-4">
                  <?= $form->field($model, 'ghi_chu')->textInput(['maxlength' => true]) ?>
            </div>
            <!-- <div class="col-md-3">
                  <?= $form->field($model, 'nguoi_tao')->dropDownList(User::getList(), ['prompt'=>'Chọn nhân viên'])->label('NV tiếp nhận') ?>
            </div> -->
            <div class="col-md-4">
            	<label>&nbsp;</label>
            	<div class="form-group mb-0">
        	        <?= Html::submitButton('<i class="fe fe-search"></i> Tìm kiếm',['class' => 'btn btn-primary']) ?>
        	        <?= Html::resetButton('<i class="fe fe-x"></i> Xóa tìm kiếm', ['class' => 'btn btn-info']) ?>
        	    </div>
            </div>
    </div>    


    <?php ActiveForm::end(); ?>
    
</div>
<style>
    .hoc-vien-search label {
    font-weight: bold;
}
</style>