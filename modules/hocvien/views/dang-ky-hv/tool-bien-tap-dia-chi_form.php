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
use yii\web\JsExpression;
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

$initValue = '';
if ($model->id_xa) {
    $initValue = $model->xa ? $model->xa->tenXaWithTinh : '';
}
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
           <?php /* $form->field($model, 'id_xa')->widget(Select2::classname(), [
               'data' => DmXa::getList(),
                    'language' => 'vi',
                    'options' => ['placeholder' => 'Chọn xã/phường...'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'),
                        'width' => '100%'
                    ],
            ])->label(false); */ ?>        
            <?= $form->field($model, 'id_xa')->widget(Select2::classname(), [
                'initValueText' => $initValue, // This shows selected text on form load
                'language' => 'vi',
                'options' => [
                    'placeholder' => 'Chọn xã/phường...',
                    'class' => 'form-control dropdown-with-arrow',
                    'id' => 'xa-dropdown'
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'),
                    'width'=>'100%',
                    'minimumInputLength' => 0, // ← allow fetch without typing
                    'ajax' => [
                        'url' => '/danhmuc/dvhc/search-xa',
                        'dataType' => 'json',
                        'delay' => 250,
                        /* 'data' => new JsExpression('function(params) {
                            return {q:params.term};
                        }'), */
                        'data' => new JsExpression('function(params) {
                            return {
                                q: params.term || "", // if empty input, send empty string
                            };
                        }'),
                        'processResults' => new JsExpression('function(data) {
                            return {results:data};
                        }'),
                        'cache' => true
                    ],
                ],
            ])->label(false); ?>
        </div>
        <div class="col-lg-4 col-md-6">  
        	<label>Tỉnh/thành</label>     
           <?= $form->field($model, 'id_tinh')->widget(Select2::classname(), [
               'data' => DmTinh::getList(),
                    'language' => 'vi',
                    'options' => [
                        'placeholder' => 'Chọn tỉnh/thành...',
                        'id' => 'tinh-dropdown'
                    ],
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

<script>
$('#xa-dropdown').on("select2:select", function(e) { 
   if(this.value != ''){
        $.ajax({
            url: '/danhmuc/dvhc/get-tinh-by-xa',
            type: 'POST',
            data: { idxa: this.value },
            success: function(response) {
                var newValue = response.value; // giá trị trả về để gán vào select2
                var option = new Option(response.text, newValue, true, true);
                $('#tinh-dropdown').append(option).trigger('change');
            }
        });
   } else {
   		$('#tinh-dropdown').val(null).trigger('change');
   }
});
$('#xa-dropdown').on('select2:clear', function(e) {
    $('#tinh-dropdown').val(null).trigger('change');
});
</script>