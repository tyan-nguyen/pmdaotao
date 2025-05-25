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

	<?php if(date('d/m/Y') == CustomFunc::convertYMDHISToDMY($model->thoi_gian_tao)): ?>
	<div class="alert alert-solid-danger mg-b-0" role="alert">
		<strong>Thông báo!</strong> Học viên mới đăng ký trong này nên sử dụng chỉnh sửa chức năng thay đổi hạng trong ngày!
	</div>
	<?php endif; ?>
	<div class="alert alert-solid-warning mg-b-0" role="alert">
		<strong>Thông báo!</strong> Vui lòng kiểm tra lại các hóa đơn thủ công sau khi cập nhật cho khớp số tiền!
	</div>

	<?php CardWidget::begin(['title'=>'Thông tin hạng hiện tại']) ?>
	<div class="row">
		<div class="col-md-4"><label>Họ tên học viên:</label> <?= $model->ho_ten ?></div>
		<div class="col-md-4"><label>Mã KH:</label> <?= $model->so_cccd ?></div>
		<div class="col-md-4"><label>Ngày đăng ký:</label> <?= CustomFunc::convertYMDHISToDMYHI($model->thoi_gian_tao) ?></div>
	</div>
	<div class="row">
		<div class="col-md-4"><label>Hạng đăng ký:</label> <?= $model->hang->ten_hang ?></div>
		<div class="col-md-8"><label>Học phí ban đầu:</label> <?= number_format($model->hocPhi->hoc_phi) ?> (Áp dụng cho <?= $model->hocPhi->hang->ten_hang ?>)</div>
	</div>
	<?php CardWidget::end() ?>

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->errorSummary($model) ?>
    
    <?php CardWidget::begin(['title'=>'Thông tin hạng thay đổi']) ?>
    <div class ='row'>
        <div class="col-lg-6 col-md-12">
        	<?= $form->field($model, 'id_hang')->dropDownList(
                HangDaoTao::getList(), 
                [
                    'prompt' => 'Chọn hạng',
                    'class' => 'form-control dropdown-with-arrow',
                ]
            ) ?>
        </div>  
        <div class="col-lg-6 col-md-12">
        	<label>Thời gian (Y-m-d H:i:s) (để trống)</label>
        	<?= \yii\helpers\Html::textInput('thoi_gian_thay_doi', '', ['class'=>'form-control']) ?>
        </div>   
        <div class="col-lg-12 col-md-12">
        	<label>Ghi chú</label>
        	<?= \yii\helpers\Html::textarea('ghi_chu', '', ['rows'=>3, 'style'=>'width:100%']) ?>
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
