<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\modules\hocvien\models\HangDaoTao;
use kartik\date\DatePicker;
use app\custom\CustomFunc;
use app\widgets\CardWidget;
/* @var $this yii\web\View */
/* @var $model app\models\HvHocVien */
/* @var $form yii\widgets\ActiveForm */
$this->registerCssFile('@web/css/dkHocVien.css', [
    'depends' => [\yii\bootstrap5\BootstrapAsset::className()],
]);
?>
<?php
$model->ngay_sinh = CustomFunc::convertYMDToDMY($model->ngay_sinh);
$model->ngay_het_han_cccd = CustomFunc::convertYMDToDMY($model->ngay_het_han_cccd);
?>
<div class="hv-hoc-vien-form">

    <?php $form = ActiveForm::begin(); ?>
      <?php CardWidget::begin(['title'=>'Thông tin cá nhân học viên']) ?>
   <div class ='row'>
        <div class="col-lg-3 col-md-6">
            <?= $form->field($model, 'ho_ten')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-3 col-md-6">
            <?= $form->field($model, 'gioi_tinh')->dropDownList([
             1 => 'Nam',
             0 => 'Nữ',
             ], ['prompt' => 'Chọn giới tính', 'class' => 'form-control dropdown-with-arrow']) ?>
        </div>
 
            <div class="col-lg-3 col-md-6">
            <?= $form->field($model, 'ngay_sinh')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Chọn ngày sinh  ...'],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd/mm/yyyy',
            ]
               ]); ?>
            </div>
            <div class="col-lg-3 col-md-6">
                 <?= $form->field($model, 'so_cccd')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-lg-3 col-md-6">
            <?= $form->field($model, 'ngay_het_han_cccd')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Chọn ngày  ...'],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd/mm/yyyy',
            ]
               ]); ?>
            </div>
            <div class="col-lg-3 col-md-6">
                 <?= $form->field($model, 'dia_chi')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-lg-3 col-md-6">
                 <?= $form->field($model, 'so_dien_thoai')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-lg-3 col-md-6">
                 <?= $form->field($model, 'noi_dang_ky')->dropDownList(
                     [
                      'Cơ sở 1 (Cửa hàng Nguyễn Trình)' => 'Cơ sở 1 (Cửa hàng Nguyễn Trình)',
                      'Cơ sở 2 (Trướng lái Nguyễn Trình)' => 'Cơ sở 2 (Trướng lái Nguyễn Trình)'
                     ],
                     ['prompt' => '- Nơi đăng ký -']
                 ) ?>
            </div>
           
    </div>
    <?php CardWidget::end() ?>

    <?php CardWidget::begin(['title'=>'Thông tin hạng đào tạo']) ?>
    <div class ='row'>
    <div class="col-lg-3 col-md-6">
        <?= $form->field($model, 'id_hang')->dropDownList(
    HangDaoTao::getList(), 
    [
        'prompt' => 'Chọn hạng',
        'class' => 'form-control dropdown-with-arrow',
    ]
    ) ?>
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
