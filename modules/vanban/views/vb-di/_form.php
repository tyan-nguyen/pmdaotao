<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\modules\vanban\models\LoaiVanBan;
use kartik\date\DatePicker;
use app\custom\CustomFunc;
use app\widgets\CardWidget;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model app\modules\vanban\models\VanBanDi */
/* @var $form yii\widgets\ActiveForm */

?>

<?php 
$model->ngay_ky = CustomFunc::convertYMDToDMY($model->ngay_ky);
$model->vbdi_ngay_chuyen = CustomFunc::convertYMDToDMY($model->vbdi_ngay_chuyen);

$currentYear = date('Y');
?>

<div class="van-ban-di-form">

<?php $form = ActiveForm::begin([
    'options' => [
        'class' => 'needs-validation ', // Thêm class vào thuộc tính options
        'novalidate' => true, // Bỏ qua xác thực của trình duyệt (nếu cần)
    ],
]); ?>
 <?php CardWidget::begin(['title'=>'Thông tin Văn bản']) ?>
      <div class="row">
      <div class="col-lg-3 col-md-6">         
            <?= $form->field($model, 'id_loai_van_ban')->widget(Select2::classname(), [
                'data' => LoaiVanBan::getList(),
                'language' => 'vi',
                'options' => ['placeholder' => 'Chọn loại VB...'],
                'pluginOptions' => [
                    'allowClear' => true,
                    'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'),
                ],
            ]);?>
         </div>
        <div class="col-lg-3 col-md-6">
            <?= $form->field($model, 'so_vb')->textInput(['maxlength' => true,'oninput' => "if (!this.value.includes('/')) { this.value = '/' + '$currentYear'; }",]) ?>
        </div>
     
      
        <div class="col-lg-3 col-md-6">
            <?= $form->field($model, 'ngay_ky')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Chọn ngày ký ...'],
                'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd/mm/yyyy',
                ]
            ]); ?>
        </div>
        <div class="col-lg-3 col-md-6">
                 <?= $form->field($model, 'nguoi_ky')->textInput(['maxlength' => true, 'class' => 'form-control']) ?>
        </div>
        <div class="col-md-12"> 
            <?= $form->field($model, 'trich_yeu')->textarea(['rows' => 5]) ?>
        </div>
      </div>
      <?php CardWidget::end() ?>

      <?php CardWidget::begin(['title'=>'Thông tin Lưu sổ văn bản']) ?>
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <?= $form->field($model, 'vbdi_noi_nhan')->textInput() ?>
            </div>
       
     
            <div class="col-lg-3 col-md-6">
                <?= $form->field($model, 'vbdi_so_luong_ban')->textInput() ?>
            </div>
            <div class="col-lg-3 col-md-6">
                <?= $form->field($model, 'vbdi_ngay_chuyen')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'Chọn ngày chuyển  ...'],
                    'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd/mm/yyyy',
                     ]
                 ]); ?>
            </div>
      
    
            <div class="col-md-12">
                <?= $form->field($model, 'ghi_chu')->textarea(['rows' => 5]) ?>
            </div>
                </div>
        <?php CardWidget::end() ?>
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
<style>
    .van-ban-di-form label {
    font-weight: bold;
}

</style>
