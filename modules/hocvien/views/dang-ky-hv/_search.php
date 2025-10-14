
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
/* @var $this yii\web\View */
/* @var $model app\modules\vanban\models\VanBanDen */
/* @var $form yii\widgets\ActiveForm */

$model->thoi_gian_hoan_thanh_ho_so = CustomFunc::convertYMDToDMY($model->thoi_gian_hoan_thanh_ho_so);
?>

<div class="hoc-vien-search">

    <?php $form = ActiveForm::begin([
        	'id'=>'myFilterForm',
            'method' => 'get',
            'options' => [
                'class' => 'myFilterForm'
            ]
      	]); ?>
    <div class="row">
           <div class="col-md-3">
                  <?= $form->field($model, 'ho_ten')->textInput(['maxlength' => true]) ?>
           </div>
            <div class="col-md-1">
                  <?= $form->field($model, 'gioi_tinh')->dropDownList([
                          1 => 'Nam',
                          0 => 'Nữ',
                          ], ['prompt' => 'Tất cả', 'class' => 'form-control dropdown-with-arrow']) ?>
            </div>
            <div class="col-md-2">
                  <?= $form->field($model, 'ngay_sinh')->widget(DatePicker::classname(), [
                         'options' => ['placeholder' => 'Chọn ngày sinh  ...'],
                         'pluginOptions' => [
                         'autoclose' => true,
                         'format' => 'dd/mm/yyyy',
                         'zIndexOffset'=>'9999',
                         'todayHighlight'=>true,
                         'todayBtn'=>true
                    ]
                  ]); ?>
            </div>
            <div class="col-md-2">
                  <?= $form->field($model, 'so_cccd')->textInput(['maxlength' => true]) ?>
            </div>
            
            <div class="col-md-2">
                  <?= $form->field($model, 'dia_chi')->textInput(['maxlength' => true]) ?>
            </div>
             
            <div class="col-md-2">
                  <?= $form->field($model, 'so_dien_thoai')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-2">
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
            <div class="col-md-2">
                  <?php // $form->field($model, 'id_hang')->dropDownList(HangDaoTao::getList(), ['prompt'=>'Tất cả']) ?>
                <label><?= $model->getAttributeLabel('id_hang') ?></label>
                <?= $form->field($model, 'id_hang')->widget(Select2::classname(), [
                    'data' => HangDaoTao::getList(),
                    'language' => 'vi',
                    'options' => [
                        'placeholder' => 'Chọn hạng...',  
                        'class' => 'form-control dropdown-with-arrow',
                        'id' => 'hang-search-dropdown'
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'width'=>'100%'
                    ],
                ])->label(false); ?>
            </div>
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
                  <?= $form->field($model, 'nguoi_tao')->dropDownList(User::getListNvNhanHoSo(), ['prompt'=>'Tất cả'])->label('NV tiếp nhận') ?>
            </div>
            <div class="col-md-1">
                  <?= $form->field($model, 'da_nhan_ao')->dropDownList([1=>'Đã nhận', 0=>'Chưa nhận', ], ['prompt'=>'Tất cả'])->label('Nhận áo') ?>
            </div>
            <div class="col-md-1">
                  <?= $form->field($model, 'size')->dropDownList([
                      'S'=>'Size S',
                      'M'=>'Size M',
                      'L'=>'Size L',
                      'XL'=>'Size XL',
                      '2XL'=>'Size 2XL',
                      '3XL'=>'Size 3XL',
                      '4XL'=>'Size 4XL'
                  ], ['prompt'=>'Tất cả'])->label('Size') ?>
            </div>
            <div class="col-md-2">
                  <?= $form->field($model, 'ngay_nhan_ao')->widget(DatePicker::classname(), [
                         'options' => ['placeholder' => 'Chọn ngày nhận ...'],
                         'pluginOptions' => [
                         'autoclose' => true,
                         'format' => 'dd/mm/yyyy',
                         'zIndexOffset'=>'9999',
                         'todayHighlight'=>true,
                         'todayBtn'=>true
                  ]
                  ]); ?>
            </div>
            <div class="col-md-2">
            	<label>Nơi nhận áo</label>
            	<?= $form->field($model, 'noiNhanAo')->widget(Select2::classname(), [
                    'data' => DangKyHv::getDmNoiDangKy(),
                    'language' => 'vi',
                    'options' => [
                        'placeholder' => 'Nơi nhận áo...',  
                        'class' => 'form-control dropdown-with-arrow',
                        'id' => 'noi-nhan-ao-search-dropdown'
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'width'=>'100%'
                    ],
                ])->label(false); ?>
            </div>
            <div class="col-md-1">
                  <?= $form->field($model, 'da_nhan_tai_lieu')->dropDownList([1=>'Đã nhận', 0=>'Chưa nhận', ], ['prompt'=>'Tất cả'])->label('Nhận tài liệu') ?>
            </div>
             <div class="col-md-2">
                  <?= $form->field($model, 'ngay_nhan_tai_lieu')->widget(DatePicker::classname(), [
                         'options' => ['placeholder' => 'Chọn ngày nhận ...'],
                         'pluginOptions' => [
                         'autoclose' => true,
                         'format' => 'dd/mm/yyyy',
                         'zIndexOffset'=>'9999',
                         'todayHighlight'=>true,
                         'todayBtn'=>true
                  ]
                  ]); ?>
            </div>
            <div class="col-md-2">
            	<label>Nơi nhận tài liệu</label>
            	<?= $form->field($model, 'noiNhanTaiLieu')->widget(Select2::classname(), [
                    'data' => DangKyHv::getDmNoiDangKy(),
                    'language' => 'vi',
                    'options' => [
                        'placeholder' => 'Nơi nhận tài liệu...',  
                        'class' => 'form-control dropdown-with-arrow',
                        'id' => 'noi-nhan-tai-lieu-search-dropdown'
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'width'=>'100%'
                    ],
                ])->label(false); ?>
            </div>
            <div class="col-md-2">
                  <?= $form->field($model, 'thoi_gian_hoan_thanh_ho_so')->widget(DatePicker::classname(), [
                         'options' => ['placeholder' => 'Chọn ngày HTHS ...'],
                         'pluginOptions' => [
                             'autoclose' => true,
                             'format' => 'dd/mm/yyyy',
                             'zIndexOffset'=>'9999',
                             'todayHighlight'=>true,
                             'todayBtn'=>true
                        ]
                  ]); ?>
            </div>
           
            <div class="col-md-2">
                  <?= $form->field($model, 'thoi_gian_tao')->widget(DatePicker::classname(), [
                         'options' => ['placeholder' => 'Chọn ngày tiếp nhận đăng ký  ...'],
                         'pluginOptions' => [
                             'autoclose' => true,
                             'format' => 'dd/mm/yyyy',
                             'zIndexOffset'=>'9999',
                             'todayHighlight'=>true,
                             'todayBtn'=>true
                        ]
                  ])->label('Ngày nhận HV mới'); ?>
            </div>
            <div class="col-md-3">
                  <?= $form->field($model, 'ghi_chu')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-2">
            	<label>&nbsp;</label>
                <?= $form->field($model, 'huy_ho_so')->checkbox() ?>
            </div>
            
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