<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\modules\vanban\models\LoaiVanBan;
use kartik\date\DatePicker;
use app\custom\CustomFunc;
use app\modules\nhanvien\models\NhanVien;
use app\widgets\CardWidget;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\modules\vanban\models\VanBanDen */
/* @var $form yii\widgets\ActiveForm */
//$this->registerCssFile('@web/node_modules/dropzone/dist/dropzone.css');
//$this->registerJsFile('@web/node_modules/dropzone/dist/dropzone-min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>

<?php 
$model->ngay_ky = CustomFunc::convertYMDToDMY($model->ngay_ky);
$model->vbden_ngay_chuyen = CustomFunc::convertYMDToDMY($model->vbden_ngay_chuyen);
$model->vbden_ngay_den = CustomFunc::convertYMDToDMY($model->vbden_ngay_den);
$currentYear = date('Y');
?>

<div class="van-ban-den-form">
     <?php $form = ActiveForm::begin([
         'options' => ['enctype' => 'multipart/form-data']
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
                <?php /* $form->field($model, 'so_vb')->textInput(['maxlength' => true,'oninput' => "if (!this.value.includes('/')) { this.value = '/' + '$currentYear'; }",]) */ ?>
                <?= $form->field($model, 'so_vb')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-3 col-md-6">
            <?= $form->field($model, 'ngay_ky')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Chọn ngày ký ...'],
                    'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd/mm/yyyy',
                ],
                'removeButton'=>false
            ]); ?>
        </div>
         <div class="col-lg-3 col-md-6">
            <?= $form->field($model, 'nguoi_ky')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'trich_yeu')->textarea(['rows' => 3, 'style'=>'width:100%']) ?>
        </div>
        
    </div>
    <?php CardWidget::end() ?>
    
    <?php CardWidget::begin(['title'=>'Thông tin Lưu sổ văn bản']) ?>
    <div class="row">        
    	<div class="col-lg-3 col-md-6">   
    		<div style="width:49%;float:left;padding-right:1%;">        
        		<?= $form->field($model, 'nam')->textInput(['value'=>($model->nam?$model->nam:date('Y'))])->label('Sổ VB') ?>
        	</div> 
        	<div style="width:50%;float:left;">   
            	<?= $form->field($model, 'so_vao_so')->textInput() ?>
            </div>
        </div>  
        
         <div class="col-lg-3 col-md-6">
            <?= $form->field($model, 'vbden_ngay_den')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'dd/mm/yyyy'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd/mm/yyyy',
                ],
                'removeButton'=>false
             ]); ?>
        </div>      

    	<div class="col-lg-3 col-md-6">
            
             <?= $form->field($model, 'vbden_nguoi_nhan')->widget(Select2::classname(), [
                 'data' => NhanVien::getList(),
                    'language' => 'vi',
                    'options' => ['placeholder' => 'Chọn người nhận...'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'),
                    ],
             ]);?>
        </div>
        <div class="col-lg-3 col-md-6">
             <?= $form->field($model, 'vbden_ngay_chuyen')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'dd/mm/yyyy'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd/mm/yyyy',
                 ],
                 'removeButton'=>false
             ]); ?>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'ghi_chu')->textarea(['rows' => 3, 'style'=>'width:100%']) ?>
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
    .van-ban-den-form label {
    font-weight: bold;
}
.dropdown-with-arrow {
    position: relative;
    padding-right: 30px; /* Đảm bảo có khoảng trống cho mũi tên */
}

.dropdown-with-arrow:after {
    content: "\f078"; /* Font Awesome chevron-down */
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    pointer-events: none;
}
.dropdown-with-arrow {
    position: relative;
    padding-right: 30px;
    appearance: none; /* Loại bỏ mũi tên mặc định */
    background: url('data:image/svg+xml;charset=UTF-8,%3Csvg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24"%3E%3Cpath d="M7 10l5 5 5-5z"%3E%3C/path%3E%3C/svg%3E') no-repeat right 10px center;
    background-size: 12px;
}
.van-ban-den-form .form-control {
    /* border-color: #0000FF; */  /* Thay đổi màu viền */
    border-width: 1px; /* Độ dày viền */
}

</style>


