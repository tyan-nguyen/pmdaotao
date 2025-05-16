<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\modules\hocvien\models\HangDaoTao;
use kartik\date\DatePicker;
use app\custom\CustomFunc;
use app\widgets\CardWidget;
use kartik\select2\Select2;
use app\modules\hocvien\models\DangKyHv;
use app\modules\user\models\User;
/* @var $this yii\web\View */
/* @var $model app\models\HvHocVien */
/* @var $form yii\widgets\ActiveForm */
$this->registerCssFile('@web/css/dkHocVien.css', [
    'depends' => [\yii\bootstrap5\BootstrapAsset::className()],
]);
?>
<?php
$model->thoi_gian_huy_ho_so = CustomFunc::convertYMDHISToDMYHIS($model->thoi_gian_huy_ho_so);
?>
<div class="hv-hoc-vien-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->errorSummary($model) ?>
    
    <?php CardWidget::begin(['title'=>'Thông tin hủy hồ sơ học viên']) ?>
    <div class ='row'>
     <div class="col-lg-3 col-md-6">
    	<?= $form->field($model, 'huy_ho_so')->checkbox() ?>
    </div>
    <div class="col-lg-3 col-md-6">
    <?= $form->field($model, 'thoi_gian_huy_ho_so')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-lg-6 col-md-6">
    	<?= $form->field($model, 'ly_do_huy_ho_so')->textarea(['rows' => 3, 'style'=>'width:100%']) ?>
    </div>
   
        
    </div>
    <?php CardWidget::end() ?>

	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
