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
$model->ngay_khai_giang = CustomFunc::convertYMDToDMY($model->ngay_khai_giang);
$model->ngay_bat_dau = CustomFunc::convertYMDToDMY($model->ngay_bat_dau);
$model->ngay_ket_thuc = CustomFunc::convertYMDToDMY($model->ngay_ket_thuc);
?>
<div class="hv-hoc-vien-form">
	<div class="alert alert-solid-warning mg-b-0" role="alert">
		<strong>Thông báo!</strong> Sau khi bật bảo lưu vui lòng xóa Khóa học của học viên.
	</div>

	<?php CardWidget::begin(['title'=>'Thông tin học viên']) ?>
	<div class="row">
		<div class="col-md-3"><label>Họ tên học viên:</label> <?= $hocVien->ho_ten ?></div>
		<div class="col-md-3"><label>Mã học viên:</label> <?= $hocVien->so_cccd ?></div>
		<div class="col-md-3"><label>Ngày đăng ký:</label> <?= CustomFunc::convertYMDHISToDMYHI($hocVien->thoi_gian_tao) ?></div>
		<div class="col-md-3"><label>Hạng đăng ký:</label> <?= $hocVien->hang->ten_hang ?></div>
	</div>
	<div class="row">
		<div class="col-md-3"><label>Học phí:</label> <?= number_format($hocVien->tienHocPhi) ?></div>
		<div class="col-md-3"><label>Học phí đã nộp:</label> <?= number_format($hocVien->tienDaNop) ?></div>
		<div class="col-md-3"><label>Chiết khấu:</label> <?= number_format($hocVien->tienChietKhau) ?></div>
		<div class="col-md-3"><label>Học phí còn lại:</label> <?= number_format($hocVien->tienChuaThanhToan) ?></div>
	</div>
	<?php CardWidget::end() ?>

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->errorSummary($model) ?>
    
    <?php CardWidget::begin(['title'=>'Thông tin bảo lưu']) ?>
    <div class ='row'>
    	<div class="col-md-3">
        	<?= $form->field($model, 'ngay_khai_giang')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Chọn ngày ...'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd/mm/yyyy',
                    'todayHighlight'=>true,
                    'todayBtn'=>true
                ]
           ]); ?>
       	</div>
       	<div class="col-md-3">
        	<?= $form->field($model, 'ngay_bat_dau')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Chọn ngày ...'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd/mm/yyyy',
                    'todayHighlight'=>true,
                    'todayBtn'=>true
                ]
           ]); ?>
       	</div>
       	<div class="col-md-3">
        	<?= $form->field($model, 'ngay_ket_thuc')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Chọn ngày ...'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd/mm/yyyy',
                    'todayHighlight'=>true,
                    'todayBtn'=>true
                ]
           ]); ?>
       	</div>
        <div class="col-lg-12 col-md-12">
            <?= $form->field($model, 'ly_do')->textarea(['rows' => 3, 'style'=>'width:100%']) ?>
        </div>  
        <div class="col-lg-12 col-md-12">
            <?= $form->field($model, 'ghi_chu')->textarea(['rows' => 3, 'style'=>'width:100%']) ?>
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
