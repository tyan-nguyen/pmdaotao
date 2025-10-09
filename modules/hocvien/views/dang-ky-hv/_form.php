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
$model->ngay_sinh = CustomFunc::convertYMDToDMY($model->ngay_sinh);
$model->ngay_het_han_cccd = CustomFunc::convertYMDToDMY($model->ngay_het_han_cccd);
$model->ngay_nhan_ao = CustomFunc::convertYMDToDMY($model->ngay_nhan_ao);
$model->ngay_nhan_tai_lieu = CustomFunc::convertYMDToDMY($model->ngay_nhan_tai_lieu);

if($model->isNewRecord){
    $user = User::getCurrentUser();
    if($user->noi_dang_ky){
        $model->noi_dang_ky = $user->noi_dang_ky;
    }
}
?>
<div class="hv-hoc-vien-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->errorSummary($model) ?>
    
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
                    'options' => ['placeholder' => 'Chọn ngày sinh  ...', 'autocomplete'=>'off'],
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
            'options' => ['placeholder' => 'Chọn ngày  ...', 'autocomplete'=>'off'],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd/mm/yyyy',
            ]
               ]); ?>
            </div>
            <div class="col-lg-4 col-md-6">
                 <?= $form->field($model, 'dia_chi')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-lg-2 col-md-6">
                 <?= $form->field($model, 'so_dien_thoai')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-lg-3 col-md-6">
                 <?= $form->field($model, 'noi_dang_ky')->dropDownList(
                     DangKyHv::getDmNoiDangKy(),
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
    <div class="col-lg-3 col-md-6">
    	<label><?= $model->getAttributeLabel('id_khoa_hoc') ?></label>
         <?= $form->field($model, 'id_khoa_hoc')->widget(Select2::classname(), [
            'data' => !empty($model->id_khoa_hoc) ? [
             $model->id_khoa_hoc => \app\modules\khoahoc\models\KhoaHoc::findOne($model->id_khoa_hoc)->ten_khoa_hoc
            ] : \app\modules\khoahoc\models\KhoaHoc::getList(1), //an khoa hoc da du hoc vien
           'language' => 'vi',
           'options' => [
           'placeholder' => 'Chọn Khóa học...',  
           'class' => 'form-control dropdown-with-arrow',
           'id' => 'khoa-hoc-dropdown'
         ],
          'pluginOptions' => [
              'allowClear' => true,
              'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'),
         ],
          ])->label(false); ?>
    </div>
    <div class="col-lg-6 col-md-6">
    	<?= $form->field($model, 'ghi_chu')->textarea(['rows' => 3, 'style'=>'width:100%']) ?>
    </div>
        
    </div>
    <?php CardWidget::end() ?>
    
    <?php CardWidget::begin(['title'=>'Thông tin nhận đồng phục/tài liệu']) ?>
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
    ]
    ) ?>
    </div>
    <div class="col-lg-3 col-md-6">
        <?= $form->field($model, 'ngay_nhan_ao')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => 'Chọn ngày  ...', 'autocomplete'=>'off'],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'dd/mm/yyyy',
            'todayHighlight'=>true,
            'todayBtn'=>true
        ]
       ]); ?>
    </div>
    
    <div class="col-lg-2 col-md-6">
    	<?= $form->field($model, 'da_nhan_tai_lieu')->checkbox() ?>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <?= $form->field($model, 'ngay_nhan_tai_lieu')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => 'Chọn ngày  ...', 'autocomplete'=>'off'],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'dd/mm/yyyy',
            'todayHighlight'=>true,
            'todayBtn'=>true
        ]
       ]); ?>
    </div>   
        
    </div>
    <?php CardWidget::end() ?>

	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', 
	            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
