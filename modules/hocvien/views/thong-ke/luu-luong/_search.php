<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

use kartik\date\DatePicker;
use app\modules\user\models\User;
use app\modules\khoahoc\models\KhoaHoc;
use app\custom\CustomFunc;
use app\modules\hocvien\models\DangKyHv;
use app\modules\hocvien\models\HangDaoTao;
use kartik\select2\Select2;
use app\modules\danhmuc\models\DmXa;
use app\modules\danhmuc\models\DmTinh;
use yii\web\JsExpression;
/* @var $this yii\web\View */
/* @var $model app\modules\vanban\models\VanBanDen */
/* @var $form yii\widgets\ActiveForm */

$model->thoi_gian_hoan_thanh_ho_so = CustomFunc::convertYMDToDMY($model->thoi_gian_hoan_thanh_ho_so);
$initValue = '';
if ($model->id_xa) {
    $initValue = $model->xa ? $model->xa->tenXaWithTinh : '';
}
?>

<style>
/*áp dụng cho select2 multiple*/
.form-control-fix-select-multiple {
    min-height: calc(1.5em + 0.75rem) !important;
    height: auto !important;
}
.hang-select2-container .select2-selection--multiple {
    height: auto !important;
}
.form-control-fix-select-multiple + .select2 .select2-selection--multiple {
    min-height: 38px !important;
    height: auto !important;
    display: flex !important;
    flex-wrap: wrap !important;
}

.form-control-fix-select-multiple + .select2 .select2-selection__rendered {
    display: flex !important;
    flex-wrap: wrap !important;
    gap: 4px;
}

.hang-select2-container .select2-selection__choice{
    font-size:.8rem !important;
}
.hang-select2-container .select2-selection--single .select2-selection__clear, .select2-container--krajee-bs5 .select2-selection--multiple .select2-selection__clear {
    padding-left: 0px !important;
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
           
            <div class="col-md-1">
                  <?= $form->field($model, 'gioi_tinh')->dropDownList([
                          1 => 'Nam',
                          0 => 'Nữ',
                          ], ['prompt' => 'Tất cả', 'class' => 'form-control dropdown-with-arrow']) ?>
            </div>
            
            <?php /* ?>
            <div class="col-md-2">
                  <?= $form->field($model, 'dia_chi')->textInput(['maxlength' => true]) ?>
            </div>
            <?php */ ?>
            <div class="col-md-3">
            	<label>Ngày sinh từ</label>
                  <?= $form->field($model, 'ngay_sinh_tu')->widget(DatePicker::classname(), [
                         'options' => [
                             'placeholder' => 'Chọn ngày sinh  ...',
                             'autocomplete' => 'off'
                         ],
                         'pluginOptions' => [
                         'autoclose' => true,
                         'format' => 'dd/mm/yyyy',
                         'zIndexOffset'=>'9999',
                         'todayHighlight'=>true,
                         'todayBtn'=>true
                    ]
                  ])->label(false); ?>
            </div>
            
            <div class="col-md-3">
            	<label>Ngày sinh đến</label>
                  <?= $form->field($model, 'ngay_sinh_den')->widget(DatePicker::classname(), [
                         'options' => [
                             'placeholder' => 'Chọn ngày sinh  ...',
                             'autocomplete' => 'off'
                         ],
                         'pluginOptions' => [
                         'autoclose' => true,
                         'format' => 'dd/mm/yyyy',
                         'zIndexOffset'=>'9999',
                         'todayHighlight'=>true,
                         'todayBtn'=>true
                    ]
                  ])->label(false); ?>
            </div>
            
            <div class="col-md-1">
            	<label>Tuổi từ</label>
                  <?= $form->field($model, 'tuoi_tu')->textInput(['maxlength' => true])->label(false) ?>
            </div>
            
             <div class="col-md-1">
             	<label>Tuổi đến</label>
                  <?= $form->field($model, 'tuoi_den')->textInput(['maxlength' => true])->label(false) ?>
            </div>
            
                     
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
            
            <?php /* ?>    
            <div class="col-md-2">
                  <?php // $form->field($model, 'id_hang')->dropDownList(HangDaoTao::getList(), ['prompt'=>'Tất cả']) ?>
                <label><?= $model->getAttributeLabel('id_hang') ?></label>
                <?= $form->field($model, 'id_hang')->widget(Select2::classname(), [
                    'data' => HangDaoTao::getList(),
                    'language' => 'vi',
                    'options' => [
                        'placeholder' => 'Chọn hạng...',  
                        'class' => 'form-control dropdown-with-arrow',
                        'id' => 'hang-search-dropdown',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'width'=>'100%'
                    ],
                ])->label(false); ?>
            </div>
            <?php */ ?>
            
             <div class="col-md-2">
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
            </div>
            <div class="col-md-2">
               <label>Xã/phường</label>
               <?php /* $form->field($model, 'id_xa')->widget(Select2::classname(), [
                   'data' => DmXa::getList(),
                        'language' => 'vi',
                        'options' => ['placeholder' => 'Chọn xã/phường...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            //'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'),
                            'width' => '100%'
                        ],
                ])->label(false); */ ?>
                <?= $form->field($model, 'id_xa')->widget(Select2::classname(), [
                    'initValueText' => $initValue, // This shows selected text on form load
                    'language' => 'vi',
                    'options' => [
                        'placeholder' => 'Chọn xã/phường...',
                        'class' => 'form-control dropdown-with-arrow',
                        'id' => 'xa-search-dropdown'
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        //'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'),
                        'width'=>'100%',
                        'minimumInputLength' => 0, // ← allow fetch without typing
                        'ajax' => [
                            'url' => '/danhmuc/dvhc/search-xa',
                            'dataType' => 'json',
                            'delay' => 250,
                            /* 'data' => new JsExpression('function(params) {
                                return {q:params.term};
                            }'), */
                            'data' => new JsExpression('function(params) {
                                return {
                                    q: params.term || "", // if empty input, send empty string
                                };
                            }'),
                            'processResults' => new JsExpression('function(data) {
                                return {results:data};
                            }'),
                            'cache' => true
                        ],
                    ],
                ])->label(false); ?>
            </div>
            <div class="col-md-2">  
            	<label>Tỉnh/thành</label>     
               <?php /* $form->field($model, 'id_tinh')->widget(Select2::classname(), [
                   'data' => DmTinh::getList(),
                        'language' => 'vi',
                        'options' => ['placeholder' => 'Chọn tỉnh/thành...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            //'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'),
                            'width' => '100%'
                        ],
                ])->label(false); */?>
                 <?= $form->field($model, 'id_tinh')->widget(Select2::classname(), [
                   'data' => DmTinh::getList(),
                        'language' => 'vi',
                        'options' => [
                            'placeholder' => 'Chọn tỉnh/thành...',
                            'id' => 'tinh-search-dropdown'
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                            //'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'),
                            'width' => '100%'
                        ],
                ])->label(false);?>         
            </div>
            
            <div class="col-md-6">
                  <?php // $form->field($model, 'id_hang')->dropDownList(HangDaoTao::getList(), ['prompt'=>'Tất cả']) ?>
                <label>Hạng đào tạo(s)</label>
                <?= $form->field($model, 'id_hangs')->widget(Select2::classname(), [
                    'data' => HangDaoTao::getList(),
                    'language' => 'vi',
                    'options' => [
                        'placeholder' => 'Chọn hạng...',  
                        'class' => 'form-control-fix-select-multiple',
                        'id' => 'hangs-search-dropdown',
                        'multiple' => true
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'width'=>'100%',
                        'containerCssClass' => 'hang-select2-container',
                        'closeOnSelect' => false,
                    ],
                ])->label(false); ?>
            </div>
           
           
    </div>    

    <?php if (!Yii::$app->request->isAjax){ ?>
    <div class="col-md-12 text-center">
        <div class="form-group mb-0">
	        <?= Html::submitButton('<i class="fe fe-search"></i> Thống kê',['class' => 'btn btn-primary']) ?>
	        <?= Html::resetButton('<i class="fe fe-x"></i> Reset dữ liệu', ['class' => 'btn btn-info']) ?>
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

<script>
$('#hangs-search-dropdown').removeClass('form-control');
$('#hangs-search-dropdown').removeClass('select2-hidden-accessible');


$('#xa-search-dropdown').on("select2:select", function(e) { 
   if(this.value != ''){
        $.ajax({
            url: '/danhmuc/dvhc/get-tinh-by-xa',
            type: 'POST',
            data: { idxa: this.value },
            success: function(response) {
                var newValue = response.value; // giá trị trả về để gán vào select2
                var option = new Option(response.text, newValue, true, true);
                $('#tinh-search-dropdown').append(option).trigger('change');
            }
        });
   } else {
   		$('#tinh-search-dropdown').val(null).trigger('change');
   }
});
$('#xa-search-dropdown').on('select2:clear', function(e) {
    $('#tinh-search-dropdown').val(null).trigger('change');
});
</script>