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

<div class="alert alert-outline-success" role="alert">
	<button aria-label="Close" class="btn-close float-end" data-bs-dismiss="alert" type="button">
		<span aria-hidden="true">×</span></button>
	<strong><span class="alert-inner--icon d-inline-block me-1"><i class="fe fe-bell"></i></span> Hủy hồ sơ</strong> <br/>Nhập thông tin hủy hồ sơ, thời gian để trống sẽ lấy ngày giờ hiện tại, đối với lý do hủy hồ sơ lệ phí như sau: 
	<ul>
		<li><i class="fa fa-angle-double-right mb-2 me-2"></i> <strong>Bất khả kháng:</strong> trường hợp bệnh & bất khả kháng - Miễn lệ phí.</li>
		<li><i class="fa fa-angle-double-right mb-2 me-2"></i> <strong>Khách quan:</strong> chuyển công tác hoặc lý do hợp lý không nằm trong kế hoạch - Lệ phí: 1.000.000 đồng.</li>
		<li><i class="fa fa-angle-double-right mb-2 me-2"></i> <strong>Chủ quan:</strong> lý do cá nhân, chủ quan hoặc đã gửi báo cáo lên công an - Lệ phí: 2.000.000 đồng.</li>
	</ul>
</div>

<div class="hv-hoc-vien-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->errorSummary($model) ?>
    
    <?php CardWidget::begin(['title'=>'Thông tin hủy hồ sơ học viên']) ?>
    <div class ='row'>
     <div class="col-lg-3 col-md-3">
    	<?= $form->field($model, 'huy_ho_so')->checkbox() ?>
    </div>
    <div class="col-lg-3 col-md-3">
    <?= $form->field($model, 'thoi_gian_huy_ho_so')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-lg-3 col-md-3">
    	<?= $form->field($model, 'loai_ly_do')->dropDownList(DangKyHv::getDmLyDoHuy()) ?>
    </div>
    <?php if($model->huy_ho_so){ ?>
    <div class="col-lg-3 col-md-3">
    	<?= $form->field($model, 'le_phi')->textInput(['maxlength' => true]) ?>
    </div>
    <?php }?>
    
    <div class="col-lg-12 col-md-12">
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
