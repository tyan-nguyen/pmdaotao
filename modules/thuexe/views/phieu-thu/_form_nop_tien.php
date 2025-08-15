<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use app\custom\CustomFunc;
use kartik\select2\Select2;
use app\widgets\CardWidget;
use app\modules\nhanvien\models\NhanVien;
use app\modules\hocvien\models\NopHocPhi;
use app\modules\user\models\User;
/* @var $this yii\web\View */
/* @var $model app\models\HvHocVien */
/* @var $form yii\widgets\ActiveForm */
$this->registerCssFile('@web/css/dkHocVienHP.css', [
    'depends' => [\yii\bootstrap5\BootstrapAsset::className()],
]);
?>
<?php
$ngay_nop = $model->thoi_gian_tao?CustomFunc::convertYMDHISToDMY($model->thoi_gian_tao):date('d/m/Y');
?>
<div class="hp-hoc-vien-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php // $form->errorSummary($model) ?>
    <?php CardWidget::begin(['title'=>'Thông tin thu tiền']) ?>
   <div class='row'>
   
   <div class="col-md-2">
            <label>Họ tên giáo viên</label> <br/>
            <?= Html::textInput('ho_ten', 
                ($modelLichThue->giaoVien ? $modelLichThue->giaoVien->ho_ten : ''), 
                ['id'=>'gvHoTen', 'class'=>'form-control', 'disabled'=>true]) ?>
        </div>
        <div class="col-md-2">
            <label>Số điện thoại</label><br/>
            <?= Html::textInput('sdt', 
                ($modelLichThue->giaoVien ? $modelLichThue->giaoVien->so_dien_thoai : ''), 
                ['id'=>'gvSDT', 'class'=>'form-control', 'disabled'=>true]) ?>
        </div>
        <div class="col-md-2">
            <label>Số CCCD</label><br/>
            <?= Html::textInput('so_cccd', 
                ($modelLichThue->giaoVien ? $modelLichThue->giaoVien->so_cccd : ''), 
                ['id'=>'gvCCCD', 'class'=>'form-control', 'disabled'=>true]) ?>
        </div>
        <div class="col-md-4">
            <label>Địa chỉ</label><br/>
            <?= Html::textInput('dia_chi', 
                ($modelLichThue->giaoVien ? $modelLichThue->giaoVien->dia_chi : ''), 
                ['id'=>'gvDiaChi', 'class'=>'form-control', 'disabled'=>true]) ?>
        </div>
        
    </div>
    <div class="row">    
        
        <div class="col-md-2">
            <label>Họ tên học viên</label>
            <?= Html::textInput('ho_ten', 
                ($modelLichThue->khachHang ? $modelLichThue->khachHang->ho_ten : ''), 
                ['id'=>'khHoTen', 'class'=>'form-control', 'disabled'=>true]) ?>
        </div>
        <div class="col-md-2">
            <label>Số điện thoại</label><br/>
            <?= Html::textInput('sdt', 
                ($modelLichThue->khachHang ? $modelLichThue->khachHang->so_dien_thoai : ''), 
                ['id'=>'khSDT', 'class'=>'form-control', 'disabled'=>true]) ?>
        </div>
        <div class="col-md-2">
            <label>Số CCCD</label><br/>
            <?= Html::textInput('so_cccd', 
                ($modelLichThue->khachHang ? $modelLichThue->khachHang->so_cccd : ''), 
                ['id'=>'khCCCD', 'class'=>'form-control', 'disabled'=>true]) ?>
        </div>
        <div class="col-md-4">
            <label>Địa chỉ</label><br/>
            <?= Html::textInput('khDiaChi', 
                ($modelLichThue->khachHang ? $modelLichThue->khachHang->dia_chi : ''), 
                ['id'=>'khDiaChi', 'class'=>'form-control', 'disabled'=>true]) ?>
        </div>
        
   </div>
   <div class="row">   
        
         <div class="col-md-2">
            <label>Số tiền</label><br/>
            <?= Html::textInput('so_tien', 
                number_format($modelLichThue->tongTien), 
                ['id'=>'gvTongTien', 'class'=>'form-control', 'disabled'=>true]) ?>
        </div>
        
      <div class="col-md-4">
      <label>Người thu</label>
        <?= $form->field($model, 'nguoi_tao')->widget(Select2::classname(), [
            'data' => $model->nguoi_tao ? [$model->nguoi_tao=>User::findOne($model->nguoi_tao)->username] : [Yii::$app->user->id => User::getCurrentUser()->username],
                    'language' => 'vi',
                    //'options' => ['placeholder' => 'Chọn người thu...'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'),
                    ],
        ])->label(false);?>
        </div>
        
   </div>
<?php CardWidget::end() ?>
   <hr style="width:400px; border-width:2px; border-color:black; margin-left:auto; margin-right:auto;">
   <?php CardWidget::begin(['title'=>'Thông tin nộp']) ?>
   <div class ='row'>
       <div class="col-lg-2 col-md-6">
       		<label>Ngày nộp</label>
           <?= 
               DatePicker::widget([
                   'name' => 'ngay_nop',
                   'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                   'value' => $model->thoi_gian_tao?CustomFunc::convertYMDHISToDMY($model->thoi_gian_tao):date('d/m/Y'),
                   'pluginOptions' => [
                       'autoclose' => true,
                       'format' => 'dd/mm/yyyy',
                   ]
               ]);
           ?>
      </div>
      
        <div class="col-lg-2 col-md-6">
            <?= $form->field($model, 'so_tien')->textInput(['value'=>$type=='all'?$modelLichThue->tongTien:'', 'placeholder' => 'VNĐ ...', 'id'=>'txtSoTienNop']) ?>
        </div>
        
        <div class="col-lg-2 col-md-6">
            <?= $form->field($model, 'chiet_khau')->textInput(['placeholder' => 'VNĐ ...', 'id'=>'txtChietKhau']) ?>
        </div>
        
        <div class="col-lg-2 col-md-6">
            <?= $form->field($model, 'hinh_thuc_thanh_toan')->dropDownList(NopHocPhi::getDmHinhThucThanhToan(), ['prompt'=>'-Chọn-','class'=>'form-control','id'=>'selectHinhThucThanhToan']) ?>
        </div>
        <div class="col-lg-4 col-md-6">
            <?= $form->field($model, 'ghi_chu')->textInput([]) ?>
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

<style> 
   .select2-dropdown {
    z-index: 9999 !important; 
     }
</style>

   





