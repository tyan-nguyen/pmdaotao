<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\web\JsExpression;
use app\modules\banhang\models\HoaDon;
use kartik\date\DatePicker;
use app\modules\user\models\User;
use app\modules\banhang\models\LoaiHangHoa;

/* @var $this yii\web\View */
/* @var $model app\modules\banhang\models\HoaDon */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="hoa-don-search">

    <?php $form = ActiveForm::begin([
        	'id'=>'myFilterForm',
            'method' => 'get',
            'options' => [
                'class' => 'myFilterForm'
            ]
    ]); ?>
	<div class="row">
		<div class="col-md-2">
			<?= $form->field($model, 'loai_hang_hoa')->dropDownList(LoaiHangHoa::getDmLoaiHangHoaBanHang(), ['prompt'=>'-Chọn-', 'id'=>'ddlLoaiHangHoa']) ?>
		</div>
		<div class="col-md-2">
			<?= $form->field($model, 'loai_khach_hang')->dropDownList(HoaDon::getDmLoaiKhachHang(), ['prompt'=>'-Tất cả-']) ?>  
		</div>
        <div class="col-md-3">
			<?php // $form->field($model, 'id_khach_hang')->textInput() ?>
			<?php /* 
    			Select2::widget([
    			    'name' => 'id_khach_hang',
    			    'id' => 'idKhachHangSearch',
    			    'options' => ['placeholder' => 'Chọn khách hàng...'],
    			    'pluginOptions' => [
    			        'allowClear' => true,
    			        'width' => '100%',
    			        'minimumInputLength' => 2,
    			        'ajax' => [
    			            'url' => Url::to(['/khachhang/khach-hang/search']), // route tới action xử lý tìm kiếm
    			            'dataType' => 'json',
    			            'delay' => 250,
    			            'data' => new JsExpression('function(params) {
                                return {q:params.term}; // gửi từ khóa tìm kiếm lên server
                            }'),
    			            'processResults' => new JsExpression('function(data) {
                                return {results:data}; // server phải trả về mảng [{id, text}]
                            }'),
    			            'cache' => true
    			        ],
    			        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
    			        'templateResult' => new JsExpression('function(user) { return user.text; }'),
    			        'templateSelection' => new JsExpression('function (user) { return user.text; }'),
    			    ]
    			]); */
			?>
			<label>Khách hàng (Khách ngoài)</label>
			<?= $form->field($model, 'idKhachNgoai')->widget(Select2::classname(), [
                //'data' => KhachHang::getList(),
                //'initValueText' => $initValue, // This shows selected text on form load
                'language' => 'vi',
                'options' => [
                    'placeholder' => 'Chọn khách hàng...',  
                    'class' => 'form-control dropdown-with-arrow',
                    'id' => 'idKhachHangKhachNgoaiSearch'
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    //'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'),
                    'width'=>'100%',
                    'minimumInputLength' => 0, // ← allow fetch without typing
                    'ajax' => [
                        'url' => '/banhang/khach-hang/search',
                        'dataType' => 'json',
                        'delay' => 250,
                        /* 'data' => new JsExpression('function(params) {
                            return {q:params.term};
                        }'), */
                        'data' => new JsExpression('function(params) {
                            return {
                                q: params.term || "", // if empty input, send empty string
                                loai: "'.HoaDon::LOAI_KHACHLE.'"
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
        <div class="col-md-3">
        	<label>Khách hàng (Học viên)</label>
			<?= $form->field($model, 'idHocVien')->widget(Select2::classname(), [
                //'data' => KhachHang::getList(),
                //'initValueText' => $initValue, // This shows selected text on form load
                'language' => 'vi',
                'options' => [
                    'placeholder' => 'Chọn khách hàng...',  
                    'class' => 'form-control dropdown-with-arrow',
                    'id' => 'idKhachHangHocVienSearch'
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    //'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'),
                    'width'=>'100%',
                    'minimumInputLength' => 0, // ← allow fetch without typing
                    'ajax' => [
                        'url' => '/banhang/khach-hang/search',
                        'dataType' => 'json',
                        'delay' => 250,
                        /* 'data' => new JsExpression('function(params) {
                            return {q:params.term};
                        }'), */
                        'data' => new JsExpression('function(params) {
                            return {
                                q: params.term || "", // if empty input, send empty string
                                loai: "'.HoaDon::LOAI_HOCVIEN.'"
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
        <!--  <div class="col-md-4">
			<?= $form->field($model, 'so_don_hang')->textInput() ?>        
        </div>-->
        <div class="col-md-1">
			<?= $form->field($model, 'so_vao_so')->textInput()->label('Số HĐ') ?>
        </div>
        <div class="col-md-1">
			<?= $form->field($model, 'nam')->dropDownList(HoaDon::getDmNamHoaDon(), ['prompt'=>'-Tất cả-']) ?>        
        </div>
        <div class="col-md-2">
			<?= $form->field($model, 'trang_thai')->dropDownList(
			    HoaDon::getDmTrangThai(),
                ['prompt'=>'-Tất cả-']
			) ?>
        </div>
        <div class="col-md-2">
			<?= $form->field($model, 'ngay_dat_hang')->widget(DatePicker::classname(), [
                         'options' => ['placeholder' => 'Ngày đặt hàng ...'],
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
        	<?= $form->field($model, 'ngay_xuat')->widget(DatePicker::classname(), [
                         'options' => ['placeholder' => 'Ngày xuất ...'],
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
			<?= $form->field($model, 'hinh_thuc_thanh_toan')->dropDownList(
                HoaDon::getDmHinhThucThanhToan(),
                ['prompt'=>'-Tất cả-']
            ) ?>
        </div>
        <div class="col-md-2">
                  <?= $form->field($model, 'nguoi_tao')->dropDownList(User::getListUsers(), 
                      ['prompt'=>'-Tất cả-'])->label('Nhân viên') ?>
            </div>
        
        </div>  
	</div>
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton('Tìm kiếm',['class' => 'btn btn-primary']) ?>
	        <?= Html::resetButton('Xóa tìm kiếm', ['class' => 'btn btn-outline-secondary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
