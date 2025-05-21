<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\modules\hocvien\models\NopHocPhi;
use app\modules\user\models\User;
use kartik\date\DatePicker;
use app\modules\hocvien\models\DangKyHv;
use app\modules\hocvien\models\HangDaoTao;

/* @var $this yii\web\View */
/* @var $model app\modules\hocvien\models\NopHocPhi */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="nop-hoc-phi-search">

    <?php $form = ActiveForm::begin([
        	'id'=>'myFilterForm',
            'method' => 'get',
            'options' => [
                'class' => 'myFilterForm'
            ]
      	]); ?>
	 <div class="row">
	 	<div class="col-md-2">
	 		 <?= $form->field($model, 'ma_so_hoc_vien')->textInput()->label('Mã học viên (CCCD)') ?>
	 	</div>
	 	<div class="col-md-2">
              <?= $form->field($model, 'noi_dang_ky')->dropDownList(DangKyHv::getDmNoiDangKy(), ['prompt'=>'Tất cả'])->label('Nơi ĐK') ?>
        </div>
        <div class="col-md-2">
              <?= $form->field($model, 'id_hang')->dropDownList(HangDaoTao::getList(), ['prompt'=>'Tất cả'])->label('Hạng đào tạo') ?>
        </div>
        <div class="col-md-2">
	 		  <?= $form->field($model, 'startdate')->widget(DatePicker::classname(), [
                         'options' => ['placeholder' => 'Chọn ngày  ...'],
                         'pluginOptions' => [
                             'autoclose' => true,
                             'format' => 'dd/mm/yyyy',
                             'zIndexOffset'=>'9999'
                        ]
              ])->label('Từ ngày, giờ, phút') ?>
	 	</div>
	 	<div class="col-md-1">
	 		  <?= $form->field($model, 'starttime')->textInput()->label('&nbsp;') ?>
	 	</div>
	 	<div class="col-md-2">
	 		   <?= $form->field($model, 'enddate')->widget(DatePicker::classname(), [
                         'options' => ['placeholder' => 'Chọn ngày  ...'],
                         'pluginOptions' => [
                             'autoclose' => true,
                             'format' => 'dd/mm/yyyy',
                             'zIndexOffset'=>'9999'
                            ]
              ])->label('Đến ngày, giờ, phút') ?>
	 	</div>
	 	<div class="col-md-1">
	 		  <?= $form->field($model, 'endtime')->textInput()->label('&nbsp;') ?>
	 	</div>
     </div>
     <div class="row">
	 	<div class="col-md-2">
	 		 <?= $form->field($model, 'ma_so_phieu')->textInput() ?>
	 	</div>
	 	<div class="col-md-2">
	 		<?= $form->field($model, 'loai_nop')->dropDownList(
	 		    NopHocPhi::getDmLoaiNop(),
	 		    ['prompt'=>'-Chọn-']
	 		) ?>
	 	</div>
	 	<div class="col-md-2">
	 		<?= $form->field($model, 'hinh_thuc_thanh_toan')->dropDownList(
	 		    NopHocPhi::getDmHinhThucThanhToan(),
	 		    ['prompt'=>'-Chọn-']
	 		) ?>
	 	</div>
	 	<!-- <div class="col-md-2">
	 		 <?= $form->field($model, 'nguoi_thu')->textInput() ?>
	 	</div>-->
	 	<div class="col-md-2">
	 		 <?= $form->field($model, 'nguoi_tao')->dropDownList(User::getList(), 
	 		     ['prompt'=>'Tất cả'])->label('NV tiếp nhận') ?>
	 	</div>
	 	<div class="col-md-2">
	 		  <?= $form->field($model, 'thoi_gian_tao')->widget(DatePicker::classname(), [
                         'options' => ['placeholder' => 'Chọn ngày  ...'],
                         'pluginOptions' => [
                         'autoclose' => true,
                         'format' => 'dd/mm/yyyy',
                  ]
              ]); ?>
	 	</div>
 	</div>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	 <div class="col-md-12 text-center">
        	<div class="form-group mb-0">
	        <?= Html::submitButton('Tìm kiếm',['class' => 'btn btn-primary']) ?>
	        <?= Html::resetButton('Xóa tìm kiếm', ['class' => 'btn btn-outline-secondary']) ?>
	    	</div>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
