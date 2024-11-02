<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\widgets\CardWidget;
use app\modules\nhanvien\models\NhanVien;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use app\custom\CustomFunc;
/* @var $this yii\web\View */
/* @var $model app\modules\thuexe\models\LoaiHinhThue */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
     $model->ngay_nop = CustomFunc::convertYMDToDMY($model->ngay_nop);
?>

<div class="nop-phi-thue-xe-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php CardWidget::begin(['title'=>'Thông tin người thuê']) ?>
 
      
<div class="row">
    <?php if (!empty($idHocVien)) : ?>
        <!-- Trường hợp người thuê là học viên -->
        <?= $form->field($model, 'id_hoc_vien')->hiddenInput(['value' => $idHocVien])->label(false) ?><!--Trường ẩn dùng để lưu giá trị khi form gửi -->
        <div class="col-md-4">
            <strong>Học viên:</strong> <?= $hotenHV ?>
        </div>
        <div class="col-md-4">
            <strong>Số CCCD:</strong> <?= $cccdHV ?>
        </div>
        <div class="col-md-4">
            <strong>Địa chỉ:</strong> <?= $diachiHV ?>
        </div> <br>
        <div class="col-md-4">
            <strong>Số điện thoại:</strong> <?= $sdtHV ?>
        </div>
        <div class="col-md-4">
            <strong>Khóa học:</strong> <i style="color:blue"><?= $tenKhoaHoc ?></i>
        </div>

    <?php else : ?>
        <!-- Trường hợp người thuê không phải là học viên -->
        <div class="col-md-4">
            <strong>Họ tên người thuê:</strong> <?= $hotenNT ?>
            <?= $form->field($model, 'ho_ten_nguoi_thue')->hiddenInput(['value' => $hotenNT])->label(false) ?>
        </div>
        <div class="col-md-4">
            <strong>Số CCCD:</strong> <?= $cccdNT ?>
            <?= $form->field($model, 'so_cccd_nguoi_thue')->hiddenInput(['value' => $cccdNT])->label(false) ?>
        </div>
        <div class="col-md-4">
            <strong>Địa chỉ:</strong> <?= $diachiNT ?>
            <?= $form->field($model, 'dia_chi_nguoi_thue')->hiddenInput(['value' => $diachiNT])->label(false) ?>
        </div><br><br>
        <div class="col-md-4">
            <strong>Số điện thoại:</strong> <?= $sdtNT ?>
            <?= $form->field($model, 'so_dien_thoai_nguoi_thue')->hiddenInput(['value' => $sdtNT])->label(false) ?>
        </div>
    <?php endif; ?>
</div>


    <?php CardWidget::end() ?>
    <?php CardWidget::begin(['title'=>'Thông tin nộp phí thuê']) ?>
       <div class="row">
           <div class="col-md-4">
                 <label class="control-label">Phí thuê</label>
                 <?= Html::textInput('so_tien_nop_display', number_format($chiphithueDK, 0, ',', '.') . ' VND', [
                    'class' => 'form-control', 
                    'style'=>'color:red',
                    'readonly' => true
                 ]) ?>
                 <?= $form->field($model, 'so_tien_nop')->hiddenInput(['value' => $chiphithueDK,'readonly' => true])->label(false) ?>
           </div>
           <div class="col-md-4">
           <?= $form->field($model, 'ngay_nop')->widget(DatePicker::classname(), [
                  'options' => ['placeholder' => 'Chọn ngày thuê xe  ...'],
                  'pluginOptions' => [
                  'autoclose' => true,
                  'format' => 'dd/mm/yyyy',
                   ]
                ]); ?>
           </div>
           <div class="col-md-4">
           <?= $form->field($model, 'nguoi_thu')->widget(Select2::classname(), [
                  'data' => ArrayHelper::map(NhanVien::find()->all(), 'id', 'ho_ten'), 
                  'language' => 'vi', 
                  'options' => ['placeholder' => 'Chọn nhân viên...'], 
                  'pluginOptions' => [
                      'allowClear' => true, 
                     
                     ],
            ]); ?>
          
           </div>
           <div class="col-md-4">
           <?= $form->field($model, 'file')->fileInput(['class' => 'form-control'])->label('Chọn biên lai') ?>
               <div class="form-group">
                   <label>&nbsp;</label> <!-- Tạo một nhãn rỗng để tạo không gian -->
               </div>
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
.nop-phi-thue-xe-form label {
    font-weight: bold;
}
</style>
