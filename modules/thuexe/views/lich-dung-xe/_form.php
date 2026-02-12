<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\widgets\CardWidget;
use kartik\select2\Select2;
use app\modules\thuexe\models\LichDungXe;
use kartik\date\DatePicker;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model app\modules\thuexe\models\LichDungXe */
/* @var $form yii\widgets\ActiveForm */
$disallowEdit = false;
$nguoiPhuTrachValue = '';
if ($model->id_nguoi_phu_trach) {
    $nguoiPhuTrachValue = $model->nguoiPhuTrach ? 
    ($model->nguoiPhuTrach->ho_ten . ' ('. $model->nguoiPhuTrach->dien_thoai . ')') : '';
}
?>

<div class="lich-dung-xe-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->errorSummary($model); ?>
    
    <?php CardWidget::begin(['title'=>'THÔNG TIN XE']) ?>
       <div class="row">  
       		<div class="col-md-4">
            	<?= $form->field($model, 'id_xe')->widget(Select2::class, [
           		       'data' => LichDungXe::getDsXe(),
                        'language' => 'vi',
            	        'options' => ['placeholder' => 'Chọn xe...', 'disabled'=>$disallowEdit],
                        'pluginOptions' => [
                            'width'=>'100%',
                            'allowClear' => true,
                            'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'),
                        ],
            	    'pluginEvents' => [
            	        /*"change" => "function(e) {
                            $('#txtDonGia').val('');
                        }",*/
            	    ]
                 ]);?>
            </div> 
            <div class="col-md-4">
            	<?= $form->field($model, 'id_nguoi_phu_trach')->widget(Select2::class, [
            	'initValueText' => $nguoiPhuTrachValue, // This shows selected text on form load
                'language' => 'vi',
                'options' => [
                    'placeholder' => 'Chọn người phụ trách...',  
                    'class' => 'form-control dropdown-with-arrow',
                    'id' => 'idNguoiPhuTrach'
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'),
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
            ]);?>
            </div>
            <div class="col-md-2">
            	<?= $form->field($model, 'trang_thai')->dropDownList(LichDungXe::getDmTrangThai(), [
            	    'disabled'=>$disallowEdit
            	]) ?>
        	</div>
       </div>
        <?php CardWidget::end() ?>
        
       <?php CardWidget::begin(['title'=>'THỜI GIAN']) ?>
       <div class="row">     
            <div class="col-md-4">
            	<?= $form->field($model, 'ngay_bat_dau')->widget(DatePicker::class, [
            	    'options' => ['id' => 'start-date', 'placeholder' => 'Chọn ngày  ...', 'disabled'=>$disallowEdit],
            	    'removeButton'=>$disallowEdit?false:[],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'dd/mm/yyyy',
                        'todayHighlight'=>true,
                        'todayBtn'=>true,
                    ],
            	    'pluginEvents' => [
            	        "changeDate" => "function(e) {
                            // Lấy ngày được chọn ở start-date
                            var startDate = e.format('dd/mm/yyyy');    
                            console.log('Ngày được chọn:', startDate);                	        
                            // Cập nhật cho DatePicker end-date
                            //$('#end-date').datepicker('setStartDate', startDate);   
                            
                          //  $('#end-date').val(startDate).trigger('change');   
                  	        
                            // Nếu B < A => cập nhật B = A
                            var endVal = $('#end-date').val();
                            console.log('Ngày KT:', endVal);   
                            /*if(endVal==null || endVal < startDate){
                                //$('#end-date').datepicker('update', startDate);
                                //$('#end-date').val(startDate).trigger('change');
                                $('#end-date').val(startDate).trigger('change');
                            }*/
                            //set end date bang gia tri start date nếu chưa chọn
                            if(endVal==''){
                                $('#end-date').val(startDate).trigger('change');
                            }
                        }"
            	    ]
                ]); ?>
            </div>
            <div class="col-md-1">
            	<?= $form->field($model, 'gio_bat_dau')->dropDownList(LichDungXe::getListHoursOfDay(), [
            	    'disabled'=>$disallowEdit
            	]) ?>
            </div>
            <div class="col-md-1">
            	<?= $form->field($model, 'phut_bat_dau')->dropDownList(LichDungXe::getList15MinutesOfHour(), [
            	    'disabled'=>$disallowEdit
            	]) ?>
            </div>
        
            <div class="col-md-4">
            	<?= $form->field($model, 'ngay_ket_thuc')->widget(DatePicker::class, [
            	    'options' => ['id' => 'end-date', 'placeholder' => 'Chọn ngày  ...', 'disabled'=>$disallowEdit],
            	    'removeButton'=>$disallowEdit?false:[],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'dd/mm/yyyy',
                        'todayHighlight'=>true,
                        'todayBtn'=>true
                    ],
            	   /* 'pluginEvents' => [
            	        "changeDate" => "function(e) {
                            // Lấy ngày được chọn ở start-date
                            var endDate = e.format('dd/mm/yyyy');
                            console.log('Ngày được chọn:', endDate);
                            // Cập nhật cho DatePicker end-date
                            //$('#end-date').datepicker('setStartDate', startDate);
                            //$('#start-date').val(startDate).trigger('change');
                            // Nếu B < A => cập nhật B = A
                            var startVal = $('#start-date').val();
                            console.log('Ngày BĐ:', startVal);
                            if(startVal == ''){
                                $('#start-date').val(endDate).trigger('change');
                            }
                        }"
            	    ]*/
                ]); ?>
            </div>
             <div class="col-md-1">
            	<?= $form->field($model, 'gio_ket_thuc')->dropDownList(LichDungXe::getListHoursOfDay(), [
            	    'disabled'=>$disallowEdit
            	]) ?>
            </div>
             <div class="col-md-1">
            	<?= $form->field($model, 'phut_ket_thuc')->dropDownList(LichDungXe::getList15MinutesOfHour(), [
            	    'disabled'=>$disallowEdit
            	]) ?>
            </div>
       </div>
    <?php CardWidget::end() ?>
        
   <?php CardWidget::begin(['title'=>'NỘI DUNG']) ?>
       <div class="row">     
       		<div class="col-md-6">
       			<?= $form->field($model, 'noi_dung')->textarea(['rows'=>3]) ?>
       		</div>
       		<div class="col-md-6">
       			<?= $form->field($model, 'ghi_chu')->textarea(['rows'=>3]) ?>
       		</div>
       </div>
	<?php CardWidget::end() ?>
  
	</div>
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
