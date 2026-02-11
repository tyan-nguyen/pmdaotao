<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;
use app\modules\thuexe\models\LichDungXe;
use kartik\select2\Select2;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\modules\thuexe\models\LichDungXe */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lich-dung-xe-search">

    <?php $form = ActiveForm::begin([
        	'id'=>'myFilterForm',
            'method' => 'post',
            'options' => [
                'class' => 'myFilterForm'
            ]
      	]); ?>
	<div class="row">
		<div class="col-md-2">
			<?= $form->field($model, 'id_xe')->widget(Select2::classname(), [
                    'data' => LichDungXe::getDsXe(),
                    'language' => 'vi',
                    'options' => [
                        'placeholder' => 'Chọn xe...',  
                        'class' => 'form-control dropdown-with-arrow',
                        'id' => 'noi-dang-ky-search-dropdown'
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'width'=>'100%'
                    ],
                ]); ?>
		</div>
		
		<div class="col-md-2">
			<label>Người phụ trách</label>
			<?= $form->field($model, 'id_nguoi_phu_trach')->widget(Select2::classname(), [
                'language' => 'vi',
                'options' => [
                    'placeholder' => 'Chọn người phụ trách...',  
                    'class' => 'form-control dropdown-with-arrow',
                    'id' => 'idNguoiPhuTrachSearch'
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    //'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'),
                    'width'=>'100%',
                    'minimumInputLength' => 0, // ← allow fetch without typing
                    'ajax' => [
                        'url' => '/thuexe/lich-dung-xe/search-nhan-vien',
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
		<?= $form->field($model, 'ngay_bat_dau')->widget(DatePicker::classname(), [
                         'options' => [
                             'placeholder' => 'Ngày bắt đầu ...',
                             'autocomplete' => 'off'
                         ],
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
			<?= $form->field($model, 'trang_thai')->dropDownList(LichDungXe::getDmTrangThai(), ['prompt'=>'-Tất cả-']) ?>
		</div>
		
		<div class="col-md-4">
			<?= $form->field($model, 'noi_dung')->textInput() ?>
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
