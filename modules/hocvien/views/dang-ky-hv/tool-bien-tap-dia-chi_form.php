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
use app\modules\danhmuc\models\DmXa;
use app\modules\danhmuc\models\DmTinh;
/* @var $this yii\web\View */
/* @var $model app\models\HvHocVien */
/* @var $form yii\widgets\ActiveForm */
$this->registerCssFile('@web/css/dkHocVien.css', [
    'depends' => [\yii\bootstrap5\BootstrapAsset::className()],
]);
?>
<?php
$user = User::getCurrentUser();
$canEdit = ($model->noi_dang_ky == $user->noi_dang_ky || $user->superadmin)?true:false;
?>

<div class="alert alert-outline-success" role="alert">
	<button aria-label="Close" class="btn-close float-end" data-bs-dismiss="alert" type="button">
		<span aria-hidden="true">×</span></button>
	<strong><span class="alert-inner--icon d-inline-block me-1"><i class="fe fe-bell"></i></span> Cập nhật địa chỉ theo danh mục đơn vị hành chính</strong> 
	<ul>
		<li><i class="fa fa-angle-double-right mb-2 me-2"></i> Nhập địa chỉ chi tiết: ấp/khóm/khu phố/số nhà/tên đường...</li>
		<li><i class="fa fa-angle-double-right mb-2 me-2"></i> Chọn xã/phường</li>
		<li><strong>Lưu ý: chọn xã phường sẽ tự động load tỉnh</strong></li>
	</ul>
</div>

<?= $this->render('tool-bien-tap-dia-chi_view', ['model'=>DangKyHv::findOne($model->id)])  ?>

<div class="hv-hoc-vien-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->errorSummary($model) ?>
    
    <?php CardWidget::begin(['title'=>'Thông tin cập nhật']) ?>
    <div class="row">
    	<div class="col-lg-4 col-md-6">
        	<?= $form->field($model, 'dia_chi_chi_tiet')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-4 col-md-6">       
           <label>Xã/phường</label>
           <?= $form->field($model, 'id_xa')->widget(Select2::classname(), [
               'data' => DmXa::getList(),
                    'language' => 'vi',
                    'options' => ['placeholder' => 'Chọn xã/phường...'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'),
                        'width' => '100%'
                    ],
            ])->label(false);?>        
        </div>
        <div class="col-lg-4 col-md-6">  
        	<label>Tỉnh/thành</label>     
           <?= $form->field($model, 'id_tinh')->widget(Select2::classname(), [
               'data' => DmTinh::getList(),
                    'language' => 'vi',
                    'options' => ['placeholder' => 'Chọn tỉnh/thành...'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'),
                        'width' => '100%'
                    ],
            ])->label(false);?>        
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