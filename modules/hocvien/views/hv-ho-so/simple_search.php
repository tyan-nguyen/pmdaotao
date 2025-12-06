
<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

use app\modules\hocvien\models\HangDaoTao;
use kartik\date\DatePicker;
use app\modules\user\models\User;
use app\modules\khoahoc\models\KhoaHoc;
use kartik\select2\Select2;
use app\modules\hocvien\models\DangKyHv;
/* @var $this yii\web\View */
/* @var $model app\modules\vanban\models\VanBanDen */
/* @var $form yii\widgets\ActiveForm */
?>

<style>
.myFilterForm input{
    border:1px solid #ddd;
}
</style>

<div class="hoc-vien-search">

    <?php $form = ActiveForm::begin([
        	'id'=>'myFilterForm',
            'method' => 'get',
            'options' => [
                'class' => 'myFilterForm'
            ]
      	]); ?>
    <div class="row">
           <div class="col-md-4">
                  <?= $form->field($model, 'ho_ten')->textInput(['maxlength' => true]) ?>
           </div>
            <div class="col-md-4">
                  <?= $form->field($model, 'gioi_tinh')->dropDownList([
                          1 => 'Nam',
                          0 => 'Nữ',
                          ], ['prompt' => 'Chọn giới tính', 'class' => 'form-control dropdown-with-arrow']) ?>
            </div>
            <div class="col-md-4">
                  <?= $form->field($model, 'ngay_sinh')->widget(DatePicker::classname(), [
                         'options' => ['placeholder' => 'Chọn ngày sinh  ...'],
                         'pluginOptions' => [
                         'autoclose' => true,
                         'format' => 'dd/mm/yyyy',
                  ]
                  ]); ?>
            </div>
           
           <!-- 
            <div class="col-md-3">
                  <?php // $form->field($model, 'noi_dang_ky')->dropDownList(DangKyHv::getDmNoiDangKy(), ['prompt'=>'Tất cả'])->label('Nơi ĐK') ?>
                   <label><?= $model->getAttributeLabel('noi_dang_ky') ?></label>
                <?= $form->field($model, 'noi_dang_ky')->widget(Select2::classname(), [
                    'data' => DangKyHv::getDmNoiDangKy(),
                    'language' => 'vi',
                    'options' => [
                        'placeholder' => 'Chọn hạng...',  
                        'class' => 'form-control dropdown-with-arrow',
                        'id' => 'noi-dang-ky-search-dropdown'
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'width'=>'100%'
                    ],
                ])->label(false); ?>
            </div>
             -->
           <!--  <div class="col-md-3">
                  <?= $form->field($model, 'id_hang')->dropDownList(HangDaoTao::getList(), ['prompt'=>'Tất cả']) ?>
            </div> -->
            <!-- <div class="col-md-2">
                  <?php // $form->field($model, 'id_khoa_hoc')->dropDownList(KhoaHoc::getList(), ['prompt'=>'Tất cả']) ?>
            </div> -->
            
           <!--  <div class="col-md-3">
                <?php // $form->field($model, 'id_khoa_hoc')->dropDownList(KhoaHoc::getList(), ['prompt'=>'Tất cả']) ?>
                <label><?= $model->getAttributeLabel('id_khoa_hoc') ?></label>
                <?= $form->field($model, 'id_khoa_hoc')->widget(Select2::classname(), [
                    'data' => KhoaHoc::getList(),
                    'language' => 'vi',
                    'options' => [
                        'placeholder' => 'Chọn khóa...',  
                        'class' => 'form-control dropdown-with-arrow',
                        'id' => 'khoa-hoc-search-dropdown'
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'width'=>'100%'
                    ],
                ])->label(false); ?>
            </div> -->
            
            <!-- <div class="col-md-3">
                  <?= $form->field($model, 'nguoi_tao')->dropDownList(User::getList(), ['prompt'=>'Tất cả'])->label('NV tiếp nhận') ?>
            </div> -->
            <!-- <div class="col-md-1">
            	<label>&nbsp;</label>
                <?= $form->field($model, 'huy_ho_so')->checkbox() ?>
            </div> -->
    </div>    

    <?php if (!Yii::$app->request->isAjax){ ?>
    <div class="col-md-12 text-center">
        <div class="form-group mb-0">
	        <?= Html::submitButton('<i class="fe fe-search"></i> Tìm kiếm',['class' => 'btn btn-primary']) ?>
	        <?= Html::resetButton('<i class="fe fe-x"></i> Xóa tìm kiếm', ['class' => 'btn btn-info']) ?>
	    </div>
    </div>
    <?php } ?>


    <?php ActiveForm::end(); ?>
    
</div>
<style>
    .hoc-vien-search label {
    font-weight: bold;
}
</style>