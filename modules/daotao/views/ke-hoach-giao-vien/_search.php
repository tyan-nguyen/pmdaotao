<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\modules\giaovien\models\GiaoVien;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use app\modules\daotao\models\KeHoach;
use app\modules\user\models\User;

/* @var $this yii\web\View */
/* @var $model app\modules\daotao\models\KeHoach */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ke-hoach-search">

    <?php $form = ActiveForm::begin([
        	'id'=>'myFilterForm',
            'method' => 'get',
            'options' => [
                'class' => 'myFilterForm'
            ]
      	]); ?>
	<div class="row">
    <!-- <div class="col-md-3">    
    	<label>Giáo viên</label>
    	<?= $form->field($model, 'id_giao_vien')->widget(Select2::classname(), [
               'data' => GiaoVien::getList(),
               'language' => 'vi',
               'options' => [
                    'placeholder' => 'Chọn giáo viên...',  
                    'class' => 'form-control dropdown-with-arrow',
                    'id' => 'gv-dropdown',
                ],
               'pluginOptions' => [
                  'allowClear' => true,
                   'width'=>'100%'
              ],
        ])->label(false); ?>
    </div> -->
    <div class="col-md-3">    
    	<?= $form->field($model, 'ngay_thuc_hien')->widget(DatePicker::classname(), [
                 'options' => ['placeholder' => 'Chọn ngày thực hiện  ...'],
                 'pluginOptions' => [
                 'autoclose' => true,
                 'format' => 'dd/mm/yyyy',
                 'zIndexOffset'=>'9999',
                 'todayHighlight'=>true,
                 'todayBtn'=>true
          ]
        ])->label('Kế hoạch ngày'); ?>
    </div>
    <div class="col-md-3">    
    	<?= $form->field($model, 'trang_thai_duyet')->dropDownList(KeHoach::getDmTrangThai(), [
    	    'prompt'=>'-Tất cả-'
    	]) ?>    
    </div>
    <!-- <div class="col-md-2">    
        <?= $form->field($model, 'id_nguoi_duyet')->dropDownList(User::getList(), [
            'prompt'=>'Chọn'
        ]) ?>
    </div> -->
    <div class="col-md-3">    
    	<?= $form->field($model, 'thoi_gian_duyet')->widget(DatePicker::classname(), [
                 'options' => ['placeholder' => 'Chọn ngày duyệt  ...'],
                 'pluginOptions' => [
                 'autoclose' => true,
                 'format' => 'dd/mm/yyyy',
                 'zIndexOffset'=>'9999',
                 'todayHighlight'=>true,
                 'todayBtn'=>true
          ]
        ]);?>
    
    </div>
    <?php if (!Yii::$app->request->isAjax){ ?>
	 <div class="col-md-3">
	 	<label>&nbsp;</label>
	  	<div class="form-group">
	        <?= Html::submitButton('<i class="fas fa-search"></i> Tìm kiếm',['class' => 'btn btn-primary']) ?>
	        <?= Html::resetButton('<i class="fas fa-backspace"></i> Xóa T.K.', ['class' => 'btn btn-primary']) ?>
	    </div>
	</div>
	<?php } ?>
    
    </div>  
	

    <?php ActiveForm::end(); ?>
    
</div>
