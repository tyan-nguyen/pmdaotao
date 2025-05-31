<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\modules\daotao\models\MonHoc;
use kartik\select2\Select2;
use app\modules\hocvien\models\HocVien;
use app\modules\thuexe\models\Xe;
use app\modules\daotao\models\TietHoc;
use app\modules\daotao\models\KeHoach;
use yii\helpers\Url;
use yii\web\JsExpression;
use app\modules\user\models\User;

/* @var $this yii\web\View */
/* @var $model app\modules\daotao\models\HangMonHoc */
/* @var $form yii\widgets\ActiveForm */
$keHoach = KeHoach::findOne($model->id_ke_hoach);
?>

<div class="hang-mon-hoc-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->errorSummary($model) ?>
	
	<div class="row">
           
        <div class="col-md-4">
        	<label>Học viên</label>
        	<?= $form->field($model, 'id_hoc_vien')->widget(Select2::classname(), [
            	    'data' => !empty($model->id_hoc_vien) ? [
            	        $model->id_hoc_vien => HocVien::findOne($model->id_hoc_vien)->ho_ten
            	    ] : HocVien::getListByGiaoVien($model->id_giao_vien), 
                    'language' => 'vi',
        	       //'id' => 'hvfrm-dropdown',
                   'options' => [
                       'placeholder' => 'Chọn học viên...',  
                       'class' => 'form-control dropdown-with-arrow',
                       'id' => 'hvfrm-dropdown'
                   ],
                   'pluginOptions' => [
                      'allowClear' => true,
                       'width'=>'100%',
                      'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal2")'),
                   ],
            ])->label(false); ?>
            <?php /* $form->field($model, 'id_hoc_vien')->dropDownList(!empty($model->id_hoc_vien) ? [
            	        $model->id_hoc_vien => HocVien::findOne($model->id_hoc_vien)->ho_ten
            	    ] : HocVien::getListByGiaoVien($model->id_giao_vien), [
            	        'prompt'=>'-Chọn-', 'id'=>'hvfrm-dropdown'
            	    ])*/ ?>
        </div>
        <div class="col-md-4">
        	<label>Module</label>
        	<?= $form->field($model, 'id_mon_hoc')->widget(Select2::classname(), [
        	       'data' => !empty($model->id_mon_hoc) ? [
        	           $model->id_mon_hoc => MonHoc::findOne($model->id_mon_hoc)->tenMon
            	    ] : MonHoc::getList(), 
                    'language' => 'vi',
        	       //'id' => 'mhfrm-dropdown',
                   'options' => [
                       'placeholder' => 'Chọn module...',  
                       'class' => 'form-control dropdown-with-arrow',
                       'id' => 'mhfrm-dropdown'
                   ],
                   'pluginOptions' => [
                      'allowClear' => true,
                      'width'=>'100%',
                      'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal2")'),
                      'ajax' => [
                            'url' => Url::to(['/daotao/tiet-hoc/get-list-mon-hoc-by-hoc-vien']),
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) {
                                return {
                                    hocvien_id: $("#hvfrm-dropdown").val()
                                };
                            }'),
                            'processResults' => new JsExpression('function(data) {
                                return data;
                            }' ),
                       ],
                   ],
            ])->label(false); ?>
        </div>
        <div class="col-md-4">
        	<label>Xe</label>
        	<?= $form->field($model, 'id_xe')->widget(Select2::classname(), [
        	       'data' => !empty($model->id_xe) ? [
        	           $model->id_xe => Xe::findOne($model->id_xe)->bien_so_xe
            	    ] : Xe::getListByGiaoVien($model->id_giao_vien), 
                    'language' => 'vi',
                   'options' => [
                       'placeholder' => 'Chọn xe...',  
                       'class' => 'form-control dropdown-with-arrow',
                       'id' => 'xefrm-dropdown'
                   ],
                   'pluginOptions' => [
                      'allowClear' => true,
                       'width'=>'100%',
                      'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal2")'),
                   ],
            ])->label(false); ?>
        </div>
        <div class="col-md-12">
        	<div id="tt-hoc-vien">
        		
        	</div>
        </div>
        <div class="col-md-4">
        	<?= $form->field($model, 'trang_thai')->dropDownList(
        	    $keHoach->trang_thai_duyet==KeHoach::TT_NHAP ?TietHoc::getDmTrangThaiChuaDuyet() :( User::getCurrentUser()->idGiaoVien?TietHoc::getDmTrangThaiForGiaoVien():TietHoc::getDmTrangThai()), [
        	    //'prompt'=>'-Tất cả-'
        	]) ?>  
        </div>
         <div class="col-md-8">
        	<?= $form->field($model, 'ghi_chu')->textInput() ?>
        </div>
  
	</div>
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>

<script>
/* $('#hvfrm-dropdown').select2({
	dropdownParent: $('#ajaxCrudModal2'),
  	selectOnClose: true,
  	width: '100%'
}); */
/* $('#hvfrm-dropdown').on("select2:select", function(e) { 
   if(this.value != ''){
   		//getHocVienFromKeHoachAjax(this.value);
   } else {
   		//$('#tt-hoc-vien').html('');
   }
}); */

$('#hvfrm-dropdown').on('change', function () {
    $('#mhfrm-dropdown').val(null).trigger('change'); // reset city khi country thay đổi
});

/* function getHocVienFromKeHoachAjax(idhv){
    $.ajax({
        type: 'post',
        url: '/daotao/tiet-hoc/get-hoc-vien-from-ke-hoach-ajax?idhv=' + idhv,
        //data: frm.serialize(),
        success: function (data) {
            console.log('Submission was successful.');
            console.log(data);            
            if(data.status == 'success'){
            	$('#tt-hoc-vien').html(data.content);
            } else {
            	alert('Thông tin học viên không còn tồn tại trên hệ thống!');
            }
        },
        error: function (data) {
            console.log('An error occurred.');
            console.log(data);
        },
    });
} */
</script>
