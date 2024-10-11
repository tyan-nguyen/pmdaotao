<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\modules\vanban\models\LoaiVanBan;
use kartik\date\DatePicker;
use app\custom\CustomFunc;
use app\modules\nhanvien\models\NhanVien;
/* @var $this yii\web\View */
/* @var $model app\modules\vanban\models\VanBanDen */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="van-ban-den-search">

    <?php $form = ActiveForm::begin([
        	'id'=>'myFilterForm',
            'method' => 'post',
            'options' => [
                'class' => 'myFilterForm'
            ]
      	]); ?>

    <?= $form->field($model, 'id_loai_van_ban')->dropDownList(LoaiVanBan::getList(), ['prompt'=>'Chọn loại văn bản']) ?>
    
    <?= $form->field($model, 'nam')->dropDownList($model->getListSo(), [
	    'prompt'=>'Chọn sổ VB'
	]) ?>
	<div class="row">
         <div class="col-md-6">
             <?= $form->field($model, 'so_vao_so')->textInput() ?>
         </div>
         <div class="col-md-6">
             <?= $form->field($model, 'so_vb')->textInput() ?>
         </div>
    </div>
    <div class="row">
        <div class="col-md-6">
             <?= $form->field($model, 'nguoi_ky')->textInput() ?>
        </div>
        <div class="col-md-6">
             <?= $form->field($model, 'vbdi_noi_nhan')->textInput() ?>
        </div>
    </div> 
    <div class="row">
        <div class="col-md-12">
             <?= $form->field($model, 'trich_yeu')->textInput() ?>
        </div>
    </div>    
    <div class="row">
        <div class="col-md-6">
              <?= $form->field($model, 'vbdi_so_luong_ban')->textInput() ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'vbdi_ngay_chuyen')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Chọn ngày chuyển  ...'],
                'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd/mm/yyyy',
              ]
            ]); ?>
        </div>
    </div>
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton('Tìm kiếm',['class' => 'btn btn-primary']) ?>
	        <?= Html::resetButton('Xóa tìm kiếm', ['class' => 'btn btn-outline-secondary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
<style>
    .van-ban-den-search label {
    font-weight: bold;
}
</style>