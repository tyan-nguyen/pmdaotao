<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\widgets\CardWidget;
use kartik\select2\Select2;
use app\modules\banhang\models\LoaiHangHoa;
use app\modules\banhang\models\DVT;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\modules\banhang\models\HangHoa */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="hang-hoa-form">

    <?php $form = ActiveForm::begin(); ?>
    
	<?php CardWidget::begin(['title'=>'Thông tin hàng hóa']) ?>
	<div class="row">
        <div class="col-md-3">
        	<label>Loại hàng hóa</label>
            <?= $form->field($model, 'id_loai_hang_hoa')->widget(Select2::classname(), [
                'data' => LoaiHangHoa::getDmLoaiHangHoa(),
                'language' => 'vi',
                'options' => [
                    'placeholder' => 'Chọn loại hàng hóa...',  
                    'class' => 'form-control dropdown-with-arrow',
                    'id' => 'loai-hh-dropdown'
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'),
                    'width'=>'100%'
                ],
            ])->label(false); ?>
          <?php /* $form->field($model, 'id_loai_hang_hoa')->dropDownList(LoaiHangHoa::getDmLoaiHangHoa(), [
              'prompt' => '-Chọn loại hàng hóa-'
          ])*/ ?>
          
        </div>        
        <div class="col-md-6">
            <?= $form->field($model, 'ten_hang_hoa')->textInput(['maxlength' => true]) ?>
        </div>
        <!-- <div class="col-md-3">
        	<?php 
        	   $dvtLabel = $model->getAttributeLabel('dvt') . ' <a href="/hanghoa/hang-hoa/create-dvt" role="modal-remote-2" style="padding-left:10px;" title="Thêm đơn vị tính"><i class="fa-solid fa-square-plus"></i></a> <a href="#" onclick="runFunc(0)" style="padding-left:10px;" title="Thêm đơn vị tính"><i class="fa-solid fa-retweet"></i></a>';
        	?>
            <?= $form->field($model, 'dvt')->dropDownList(DVT::getList(), ['prompt'=>'-Chọn-', 'id'=>'ddlDvt'])->label($dvtLabel) ?>
        </div> -->
        
        <div class="col-md-3">
        	<?php 
        	   $dvtLabel = $model->getAttributeLabel('dvt') . ' <a href="/hanghoa/hang-hoa/create-dvt" role="modal-remote-2" style="padding-left:10px;" title="Thêm đơn vị tính"><i class="fa-solid fa-square-plus"></i></a> <a href="#" onclick="runFunc(0)" style="padding-left:10px;" title="Thêm đơn vị tính"><i class="fa-solid fa-retweet"></i></a>';
        	?>
        	<label><?= $dvtLabel ?></label>
            <?= $form->field($model, 'dvt')->widget(Select2::classname(), [
                'data' => DVT::getList(),
                'language' => 'vi',
                'options' => [
                    'placeholder' => 'Chọn DVT...',  
                    'class' => 'form-control dropdown-with-arrow',
                    'id' => 'dvt-dropdown'
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'),
                    'width'=>'100%'
                ],
            ])->label(false); ?>
        </div>
        
        <div class="col-md-3">
            <?= $form->field($model, 'ma_hang_hoa')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'so_luong')->textInput() ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'don_gia')->textInput() ?>
        </div>
         <div class="col-md-3">
         	<label>&nbsp;</label>
            <?= $form->field($model, 'co_ton_kho')->checkbox() ?>
        </div>

        </div>
	
	<?php CardWidget::end() ?>
	
	<?php CardWidget::begin(['title'=>'Thông tin khác']) ?>
	<div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'ngay_san_xuat')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Ngày sản xuất...'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd/mm/yyyy',
                    'todayHighlight'=>true,
                    'todayBtn'=>true
                ]
            ]); ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'xuat_xu')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'ghi_chu')->textarea(['rows' => 3]) ?>
        </div>
	</div>
	<?php CardWidget::end() ?>
	
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>
    <?php ActiveForm::end(); ?>
    
</div>

<script type="text/javascript">
function runFunc1(sendVal){
	var url = '/hanghoa/hang-hoa/refresh-dvt?selected=' + sendVal;
	$.ajax({
        url: url,
        method: 'GET',
        success: function (response) {
            $('#ddlDvt').html(response.options);
        },
        contentType: false,
        cache: false,
        processData: false
   });
}

function runFunc(sendVal){
	var url = '/hanghoa/hang-hoa/refresh-dvt-select2?selected=' + sendVal;
	$.ajax({
        url: url,
        method: 'GET',
        success: function (response) {
            var $select = $('#dvt-dropdown');
            $select.empty(); // Xóa hết option cũ
            var selectedValue = null;
    
            $.each(response, function(i, item) {
                var isSelected = item.selected === true;
                var option = new Option(item.text, item.id, false, isSelected);
    
                $select.append(option);
    
                if (isSelected) {
                    selectedValue = item.id;
                }
            });
    
            // Cập nhật Select2 giao diện
            if (selectedValue !== null) {
                $select.val(selectedValue).trigger('change');
            } else {
                $select.trigger('change');
            }
        },
        contentType: false,
        cache: false,
        processData: false
   });
}
$.fn.modal.Constructor.prototype.enforceFocus = function() {};
</script>
