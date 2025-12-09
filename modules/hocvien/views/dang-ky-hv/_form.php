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
use app\modules\danhmuc\models\DmTinh;
use yii\web\JsExpression;
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

$initValueXa = '';
if ($model->id_xa) {
    $initValueXa = $model->xa ? $model->xa->tenXaWithTinh : '';
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
    					'todayHighlight'=>true,
    					'todayBtn'=>true
                    ]
               ]); ?>
            </div>
            <div class="col-lg-3 col-md-6">
                 <?= $form->field($model, 'so_dien_thoai')->textInput(['maxlength' => true]) ?>
            </div>
            <?php if (!$model->id_xa && !$model->isNewRecord){ ?>
                 <div class="col-lg-12 col-md-12">
                     <?= $form->field($model, 'dia_chi')->textInput(['maxlength' => true]) ?>
                </div>
            <?php } else {?>
             <div class="col-lg-4 col-md-6">
                 <?= $form->field($model, 'dia_chi_chi_tiet')->textInput(['maxlength' => true])->label('Địa chỉ (số nhà, ấp, khóm...)') ?>
            </div>
            <div class="col-md-4">
           		<label>Xã/phường</label>
                <?= $form->field($model, 'id_xa')->widget(Select2::classname(), [
                    'initValueText' => $initValueXa, // This shows selected text on form load
                    'language' => 'vi',
                    'options' => [
                        'placeholder' => 'Chọn xã/phường...',
                        'class' => 'form-control dropdown-with-arrow',
                        'id' => 'xa-dropdown'
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'),
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
            <div class="col-md-4">  
            	<label>Tỉnh/thành</label>     
                 <?= $form->field($model, 'id_tinh')->widget(Select2::classname(), [
                   'data' => DmTinh::getList(),
                        'language' => 'vi',
                        'options' => [
                            'placeholder' => 'Chọn tỉnh/thành...',
                            'id' => 'tinh-dropdown'
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'),
                            'width' => '100%'
                        ],
                ])->label(false);?>         
            </div>
            <?php } //end if id_xa?>
            
            <div class="col-lg-4 col-md-6">
                 <?= $form->field($model, 'so_cccd')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-lg-4 col-md-6">
            <?= $form->field($model, 'ngay_het_han_cccd')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Chọn ngày  ...', 'autocomplete'=>'off'],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd/mm/yyyy',
				'todayHighlight'=>true,
				'todayBtn'=>true
            ]
               ]); ?>
            </div>
            
            <div class="col-lg-4 col-md-6">
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
              'width' => '100%'
         ],
          ])->label(false); ?>
    </div>
    <div class="col-lg-6 col-md-6">
    	<?= $form->field($model, 'ghi_chu')->textarea(['rows' => 1, 'style'=>'width:100%']) ?>
    </div>
    <!-- 
    <div class="col-lg-3 col-md-6">
        <?= $form->field($model, 'label')->dropDownList(
            ['VOUCHERT11'=>'VOUCHERT11'], 
            [
                'prompt' => '--Không có---',
                'class' => 'form-control dropdown-with-arrow',
            ]
        )->label('Voucher T11 3 triệu') ?>
    </div> -->
    
        
    </div>
    <?php CardWidget::end() ?>
    
    <?php CardWidget::begin(['title'=>'Thông tin nhận đồng phục/tài liệu']) ?>
    <div class ='row'>
     <div class="col-lg-2 col-md-6">
    	<?= $form->field($model, 'da_nhan_ao')->checkbox([
            'disabled' => (bool)$model->da_nhan_ao,
        ]) ?>
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
                'disabled' => (bool)$model->da_nhan_ao,
            ]
        ) ?>
    </div>
    <div class="col-lg-3 col-md-6">
        <?= $form->field($model, 'ngay_nhan_ao')->widget(DatePicker::classname(), [
        'options' => [
            'placeholder' => 'Chọn ngày  ...', 
            'autocomplete'=>'off',
            'disabled' => (bool)$model->da_nhan_ao
        ],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'dd/mm/yyyy',
            'todayHighlight'=>true,
            'todayBtn'=>true
        ]
       ]); ?>
    </div>
    
    <div class="col-lg-2 col-md-6">
    	<?= $form->field($model, 'da_nhan_tai_lieu')->checkbox([
    	    'disabled' => (bool)$model->da_nhan_tai_lieu,
        ]) ?>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <?= $form->field($model, 'ngay_nhan_tai_lieu')->widget(DatePicker::classname(), [
        'options' => [
            'placeholder' => 'Chọn ngày  ...', 
            'autocomplete'=>'off',
            'disabled' => (bool)$model->da_nhan_tai_lieu,
        ],
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

<script>
$('#xa-dropdown').on("select2:select", function(e) { 
   if(this.value != ''){
        $.ajax({
            url: '/danhmuc/dvhc/get-tinh-by-xa',
            type: 'POST',
            data: { idxa: this.value },
            success: function(response) {
                var newValue = response.value; // giá trị trả về để gán vào select2
                var option = new Option(response.text, newValue, true, true);
                $('#tinh-dropdown').append(option).trigger('change');
            }
        });
   } else {
   		$('#tinh-dropdown').val(null).trigger('change');
   }
});
$('#xa-dropdown').on('select2:clear', function(e) {
    $('#tinh-dropdown').val(null).trigger('change');
});
</script>
