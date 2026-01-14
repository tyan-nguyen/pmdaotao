<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\widgets\CardWidget;
use kartik\date\DatePicker;
use app\modules\hocvien\models\NopHocPhi;

/* @var $this yii\web\View */
/* @var $model app\modules\hocvien\models\NopHocPhi */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="nop-hoc-phi-form">

    <?php $form = ActiveForm::begin(); ?>
 
   <?php CardWidget::begin(['title'=>'Thông tin học phí']) ?>
   <div class ='row'>
       <!-- <div class="col-lg-3 col-md-6">
           <?= $form->field($model, 'ngay_nop')->widget(DatePicker::classname(), [
             'options' => ['placeholder' => 'Chọn ngày nộp ...', 'value' => date('d/m/Y')],
             'pluginOptions' => [
             'autoclose' => true,
             'format' => 'dd/mm/yyyy',
             ]
           ]); ?>
      </div> -->
      
      <div class="col-lg-3 col-md-6">
            <?= $form->field($model, 'loai_nop')->dropDownList(NopHocPhi::getDmLoaiNop(), ['prompt'=>'-Chọn-','class'=>'form-control','id'=>'selectLoaiNop']) ?>
        </div>

        <div class="col-lg-3 col-md-6">
            <?= $form->field($model, 'so_tien_nop')->textInput(['placeholder' => 'VNĐ ...', 'id'=>'txtSoTienNop']) ?>
        </div>
        
        <div class="col-lg-3 col-md-6">
            <?= $form->field($model, 'chiet_khau')->textInput(['placeholder' => 'VNĐ ...', 'id'=>'txtChietKhau']) ?>
        </div>
        
        <div class="col-lg-3 col-md-6">
            <?= $form->field($model, 'so_tien_con_lai')->textInput(['placeholder' => 'VNĐ ...', 'id'=>'txtSoTienConLai']) ?>
        </div>
        
        <div class="col-lg-3 col-md-6">
            <?= $form->field($model, 'hinh_thuc_thanh_toan')->dropDownList(NopHocPhi::getDmHinhThucThanhToan(), ['prompt'=>'-Chọn-','class'=>'form-control','id'=>'selectHinhThucThanhToan']) ?>
        </div>
        <div class="col-lg-9 col-md-6">
            <?= $form->field($model, 'ghi_chu')->textInput([]) ?>
        </div>
        <div class="col-lg-4 col-md-4">
            <?= $form->field($model, 'co_thu_ho')->checkbox([]) ?>
        </div>
        <div class="col-lg-4 col-md-4">
            <?= $form->field($model, 'so_tien_thu_ho')->textInput([]) ?>
        </div>
        <div class="col-lg-4 col-md-4">
            <?= $form->field($model, 'hinh_thuc_thu_ho')->textInput([]) ?>
        </div>
        <div class="col-lg-12 col-md-12">
            <?= $form->field($model, 'ghi_chu_thu_ho')->textInput([]) ?>
        </div>
        
   </div>
   
   <?php /* ?>
   <div class='row'>
       <div class="col-md-12" >
          
            <br/>
            <div class='row'>
                <div class="col-lg-4 col-md-12" style="text-align:center;">
                    <div id="my_camera" style="text-align:center;"></div>
                    <?= $form->field($model, 'bien_lai')->hiddenInput(['id' => 'bien_lai'])->label(false) ?>
                </div>
                <div class="col-lg-4 col-md-12" style="text-align:center;">
                    <div id="results" style="text-align:center; width: 100%; height: 240px; border: 1px solid #ccc; display: flex; align-items: center; justify-content: center;">
               </div>
          </div>

                <div class="col-lg-4 col-md-12">
                    <?= $form->field($model, 'file')->fileInput(['class' => 'form-control','id' => 'fileInput'])->label('Chọn biên lai') ?>
                        <div class="form-group">
                        <label>&nbsp;</label> <!-- Tạo một nhãn rỗng để tạo không gian -->
                    </div>
                </div>
            </div>
            <div class='row'>
                <div class="col-md-8" >
                <button id="takeSnapshotButton"  onClick="take_snapshot()" class="btn ripple btn-primary btn-sm" >
                   <i class="fa fa-camera" style="font-size: 16px;"></i> Chụp biên lai
               </button>
               <button onClick="clear_snapshot()" class="btn ripple btn-danger btn-sm">
                    <i class="fa fa-trash" style="font-size: 16px;"></i> Xóa ảnh
                </button>
                </div>
            </div>
       </div>
       
   </div> <?php */ ?>
 
 <?php CardWidget::end() ?>
 
	<!-- 
    <?= $form->field($model, 'id_hoc_vien')->textInput() ?>

    <?= $form->field($model, 'id_hoc_phi')->textInput() ?>

    <?= $form->field($model, 'loai_phieu')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'loai_nop')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'so_tien_nop')->textInput() ?>

    <?= $form->field($model, 'chiet_khau')->textInput() ?>

    <?= $form->field($model, 'so_tien_con_lai')->textInput() ?>

    <?= $form->field($model, 'ngay_nop')->textInput() ?>

    <?= $form->field($model, 'ma_so_phieu')->textInput() ?>

    <?= $form->field($model, 'so_lan_in_phieu')->textInput() ?>

    <?= $form->field($model, 'hinh_thuc_thanh_toan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nguoi_thu')->textInput() ?>

    <?= $form->field($model, 'bien_lai')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'nguoi_tao')->textInput() ?>

    <?= $form->field($model, 'thoi_gian_tao')->textInput() ?>

    <?= $form->field($model, 'da_kiem_tra')->textInput() ?>

    <?= $form->field($model, 'ghi_chu')->textarea(['rows' => 6]) ?>
    -->
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
