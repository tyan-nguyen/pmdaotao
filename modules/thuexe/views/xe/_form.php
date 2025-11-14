<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\widgets\CardWidget;
use kartik\select2\Select2;
use app\modules\thuexe\models\LoaiXe;
use yii\bootstrap5\Modal;
use app\modules\thuexe\models\Xe;
use app\custom\CustomFunc;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\modules\thuexe\models\Xe */
/* @var $form yii\widgets\ActiveForm */
if(!$model->isNewRecord){
    $model->ngay_dang_kiem = CustomFunc::convertYMDToDMY($model->ngay_dang_kiem);
}
?>

<div class="xe-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php CardWidget::begin(['title'=>'Thông tin Xe']) ?>

       <div class="row">
       <div class="col-lg-2 col-md-6">
       		<?= $form->field($model, 'id_loai_xe')->widget(Select2::classname(), [
                 'data' => LoaiXe::getList(),
                    'language' => 'vi',
                    'options' => ['placeholder' => 'Chọn loại xe...'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'),
                    ],
             ]);?>
        </div>
        
        <div class="col-lg-3 col-md-6">
       		<?= $form->field($model, 'phan_loai')->widget(Select2::classname(), [
       		       'data' => Xe::getDmPhanLoaiXe(),
                    'language' => 'vi',
                    'options' => ['placeholder' => 'Phân loại xe...'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'),
                    ],
             ]);?>
        </div>
          

         <div class="col-lg-3 col-md-6">
             <?= $form->field($model, 'hieu_xe')->textInput(['maxlength' => true]) ?>
         </div>
         <div class="col-lg-2 col-md-6">
             <?= $form->field($model, 'bien_so_xe')->textInput(['maxlength' => true]) ?>
         </div>
         <div class="col-lg-1 col-md-6">
             <?= $form->field($model, 'ma_so')->textInput(['maxlength' => true]) ?>
         </div>
          <div class="col-lg-1 col-md-6">
             <?= $form->field($model, 'stt')->textInput(['maxlength' => true]) ?>
         </div>
         <div class="col-lg-3 col-md-6">
            <?= $form->field($model, 'tinh_trang_xe')->dropDownList(
              Xe::getDmTinhTrangXe(),
             ['prompt' => 'Chọn tình trạng xe']  // 
            ) ?>
        </div>
         <div class="col-lg-3 col-md-6">
            <?= $form->field($model, 'trang_thai')->dropDownList(
              [
                 'Khả dụng' => 'Khả dụng', 
                 'Không khả dụng' => 'Không khả dụng'  
              ],
             ['prompt' => 'Chọn trạng thái']  // 
            ) ?>
        </div>
        
        <div class="col-lg-3 col-md-6">
             <?= $form->field($model, 'ngay_dang_kiem')->widget(DatePicker::classname(), [
                'options' => [
                    'placeholder' => 'Ngày đăng kiểm...',
                    'autocomplete' => 'off'
                ],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd/mm/yyyy',
                    'zIndexOffset'=>'9999',
                    'todayHighlight'=>true,
                    'todayBtn'=>true
                ]
             ]); ?>
        </div>
        
        <div class="col-lg-3 col-md-6">
        	<label>&nbsp;</label>
             <?= $form->field($model, 'la_xe_cu')->checkbox() ?>
         </div>
        
        <div class="col-lg-3 col-md-6">
             <?= $form->field($model, 'so_khung')->textInput(['maxlength' => true]) ?>
         </div>
         
         <div class="col-lg-3 col-md-6">
             <?= $form->field($model, 'so_may')->textInput(['maxlength' => true]) ?>
         </div>
         
         <div class="col-lg-3 col-md-6">
             <?= $form->field($model, 'mau_sac')->textInput(['maxlength' => true]) ?>
         </div>
        
        <div class="col-lg-3 col-md-6">
             <?= $form->field($model, 'so_hoa_don')->textInput(['maxlength' => true]) ?>
         </div>
		<div class="col-lg-3 col-md-6">
             <?= $form->field($model, 'so_hop_dong')->textInput(['maxlength' => true]) ?>
         </div>
         <div class="col-lg-9 col-md-6">
             <?= $form->field($model, 'nha_cung_cap')->textInput(['maxlength' => true]) ?>
         </div>
         <div class="col-lg-12 col-md-12">
             <?= $form->field($model, 'dac_diem')->textInput(['maxlength' => true]) ?>
         </div>
         <div class="col-lg-12 col-md-12">
             <?= $form->field($model, 'ghi_chu')->textarea(['rows' => 4]) ?>
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

<?php Modal::begin([
   'options' => [
        'id'=>'ajaxCrudModal2',
        'tabindex' => false // important for Select2 to work properly
   ],
  // 'dialogOptions'=>['class'=>'modal-lg'],
   'closeButton'=>['label'=>'<span aria-hidden=\'true\'>×</span>'],
   'id'=>'ajaxCrudModal2',
    'footer'=>'',// always need it for jquery plugin
    'size'=>Modal::SIZE_LARGE
])?>
<?php Modal::end(); ?>
<style>
.xe-form label {
    font-weight: bold;
}
</style>

