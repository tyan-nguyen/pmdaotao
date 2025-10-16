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
//nếu ngày nhận là null thì gợi ý mặc định là ngày hiện tại, 
//tránh nhập vào ngày cũ gây sai số kho, chỉ admin mới cho sửa
$model->ngay_nhan_ao = $model->ngay_nhan_ao
    ? CustomFunc::convertYMDToDMY($model->ngay_nhan_ao)
    : date('d/m/Y');
$isAdmin = User::getCurrentUser()->superadmin?true:false;
?>

<div class="alert alert-outline-success" role="alert">
	<button aria-label="Close" class="btn-close float-end" data-bs-dismiss="alert" type="button">
		<span aria-hidden="true">×</span></button>
	<strong><span class="alert-inner--icon d-inline-block me-1"><i class="fe fe-bell"></i></span> Giao đồng phục cho học viên</strong> 
	<ul>
		<li><i class="fa fa-angle-double-right mb-2 me-2"></i> Chọn đã nhận áo</li>
		<li><i class="fa fa-angle-double-right mb-2 me-2"></i> Chọn ngày nhận</li>
	</ul>
</div>

<?= !$isAdmin?'':$this->render('nhan-ao_view', ['model'=>DangKyHv::findOne($model->id)])  ?>

<div class="hv-hoc-vien-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->errorSummary($model) ?>
    
    <?php CardWidget::begin(['title'=>'Thông tin nhận áo']) ?>
    <div class ='row'>
    	<div class="col-lg-2 col-md-6">
        	<?= $form->field($model, 'da_nhan_ao')->checkbox() ?>
        </div>
        
        <div class="col-lg-2 col-md-6">
            <?= $form->field($model, 'size')->dropDownList(
                [
                    'S'=>'Size S',
                    'M'=>'Size M',
                    'L'=>'Size L',
                    'XL'=>'Size XL',
                    '2XL'=>'Size 2XL',
                    '3XL'=>'Size 3XL',
                    '4XL'=>'Size 4XL'
                ],
                [
                    'prompt' => 'Chọn size áo',
                    'class' => 'form-control dropdown-with-arrow',
                   // 'disabled' => (bool) ($model->da_nhan_ao && !$isAdmin),
                ]
            ) ?>
        </div>
        
        <div class="col-lg-3 col-md-6">
            <?= $form->field($model, 'ngay_nhan_ao')->widget(DatePicker::classname(), [
                'options' => [
                    'placeholder' => 'Chọn ngày  ...', 
                    'autocomplete'=>'off',
                    //'disabled' => !$isAdmin,
                ],
                //'removeButton' => $isAdmin?['icon'=>'remove', 'title'=>'Xóa ngày']:false,
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd/mm/yyyy',
                    'todayHighlight'=>true,
                    'todayBtn'=>true,
                ]
               ]); ?>
           <?php 
                //nhận giá trị khi disable cho nhân viên nhận hồ sơ
                /* if(!$isAdmin){
                    echo Html::hiddenInput('DangKyHv[ngay_nhan_ao]', $model->ngay_nhan_ao);
                } */
           ?>           
          
        
        </div> 
        
        <div class="col-lg-3 col-md-6">
        	 <?= !$isAdmin?'':$form->field($model, 'nguoi_giao_ao')->widget(Select2::classname(), [
               'data' => User::getListNvNhanHoSo(),
                    'language' => 'vi',
                    'options' => ['placeholder' => 'Chọn NV thực hiện...'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'),
                    ],
            ]);?>
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
