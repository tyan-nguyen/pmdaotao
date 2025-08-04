<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\modules\thuexe\models\LichThue;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model app\modules\thuexe\models\LichThue */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lich-thue-search">

    <?php $form = ActiveForm::begin([
        	'id'=>'myFilterForm',
            'method' => 'post',
            'options' => [
                'class' => 'myFilterForm'
            ]
      	]); ?>
	<div class="row">
		<div class="col-md-2">
			<?= $form->field($model, 'loai_giao_vien')->dropDownList(LichThue::getDmLoaiGiaoVien(), ['prompt'=>'-Tất cả-']) ?>
		</div>
		<div class="col-md-2">
			<label>Giáo viên (Khách ngoài)</label>
			<?= $form->field($model, 'idGiaoVienNgoai')->widget(Select2::classname(), [
                'language' => 'vi',
                'options' => [
                    'placeholder' => 'Chọn giáo viên...',  
                    'class' => 'form-control dropdown-with-arrow',
                    'id' => 'idGiaoVienNgoaiSearch'
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
                                loai: "'.LichThue::GV_KHACHNGOAI.'"
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
        	<label>Giáo viên (trung tâm)</label>
			<?= $form->field($model, 'idGiaoVien')->widget(Select2::classname(), [
                'language' => 'vi',
                'options' => [
                    'placeholder' => 'Chọn giáo viên...',  
                    'class' => 'form-control dropdown-with-arrow',
                    'id' => 'idGiaoVienSearch'
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    //'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'),
                    'width'=>'100%',
                    'minimumInputLength' => 0, // ← allow fetch without typing
                    'ajax' => [
                        'url' => '/banhang/khach-hang/search-giao-vien',
                        'dataType' => 'json',
                        'delay' => 250,
                        /* 'data' => new JsExpression('function(params) {
                            return {q:params.term};
                        }'), */
                        'data' => new JsExpression('function(params) {
                            return {
                                q: params.term || "", // if empty input, send empty string
                                loai: "'.LichThue::GV_GIAOVIEN.'"
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
			<?= $form->field($model, 'loai_khach_hang')->dropDownList(LichThue::getDmLoaiKhachHang(), ['prompt' => '-Tất cả-']) ?>
		</div>
		 <div class="col-md-2">
			<label>Khách hàng (Khách ngoài)</label>
			<?= $form->field($model, 'idKhachNgoai')->widget(Select2::classname(), [
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
                                loai: "'.LichThue::KH_KHACHNGOAI.'"
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
                                loai: "'.LichThue::KH_HOCVIEN.'"
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
			<?= $form->field($model, 'id_xe')->dropDownList(LichThue::getDsXeCamUng(), ['prompt'=>'-Tất cả-']) ?>
		</div>
		<div class="col-md-2">
		<?= $form->field($model, 'ngay_bat_dau')->widget(DatePicker::classname(), [
                         'options' => ['placeholder' => 'Ngày thuê ...'],
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
			<?= $form->field($model, 'trang_thai')->dropDownList(LichThue::getDmTrangThai(), ['prompt'=>'-Tất cả-']) ?>
		</div>
		<?php if (!Yii::$app->request->isAjax){ ?>
    	<div class="col-md-4">
    		<label>&nbsp;</label>
    	  	<div class="form-group">
    	        <?= Html::submitButton('Tìm kiếm',['class' => 'btn btn-primary']) ?>
    	        <?= Html::resetButton('Xóa TK', ['class' => 'btn btn-outline-secondary']) ?>
    	    </div>
    	</div>
    	<?php } ?>
	</div>
	

    <?php ActiveForm::end(); ?>
    
</div>
