<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use app\custom\CustomFunc;
use app\widgets\CardWidget;
use app\modules\hocvien\models\HangDaoTao;
use app\modules\khoahoc\models\KhoaHoc;
/* @var $this yii\web\View */
/* @var $model app\modules\khoahoc\models\KhoaHoc */
/* @var $form yii\widgets\ActiveForm */
$this->registerCssFile('@web/css/khoaHoc.css', [
    'depends' => [\yii\bootstrap5\BootstrapAsset::className()],
]);
?>
<?php
$model->ngay_bat_dau = CustomFunc::convertYMDToDMY($model->ngay_bat_dau);
$model->ngay_ket_thuc = CustomFunc::convertYMDToDMY($model->ngay_ket_thuc);
?>
<div class="khoa-hoc-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php CardWidget::begin(['title'=>'Thông tin khóa học']) ?>
    <div class='row'>
         <!-- <div class ="col-lg-3 col-md-6">
         <?= $form->field($model, 'id_hang')->dropDownList(
            HangDaoTao::getList(), 
                [
                 'prompt' => 'Chọn hạng',
                 'class' => 'form-control dropdown-with-arrow',
                ]
        ) ?>
         </div> -->
       
         <div class="col-lg-3 col-md-6">
              <?= $form->field($model, 'ten_khoa_hoc')->textInput(['maxlength' => true]) ?>
        </div>
  
        <div class="col-lg-3 col-md-6">
             <?= $form->field($model, 'ngay_bat_dau')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Chọn ngày bắt đầu  ...'],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd/mm/yyyy',
            ]
               ]); ?>
       </div>
       <div class="col-lg-3 col-md-6">
              <?= $form->field($model, 'ngay_ket_thuc')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Chọn ngày kết thúc  ...'],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd/mm/yyyy',
            ]
               ]); ?>
      </div>
      
      <div class="col-lg-3 col-md-6">
          <?= $form->field($model, 'so_hoc_vien_khoa_hoc')->textInput(['type' => 'number', 'maxlength' => true]) ?>
      </div>
      
       <div class="col-lg-3 col-md-6">
              <?= $form->field($model, 'trang_thai')->dropDownList($model->getListTrangThai(), [
                  'prompt'=>'-Chọn-'
              ]) ?>
        </div>

        <div class='col-md-9'>
        <?= $form->field($model, 'ghi_chu')->textarea(['rows' => 6, 'placeholder' => 'Nhập ghi chú']) ?>
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
