<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\modules\vanban\models\LoaiVanBan;
use kartik\date\DatePicker;
use app\modules\nhanvien\models\NhanVien;
use kartik\select2\Select2;
?>

<div class="van-ban-den-search">

    <?php $form = ActiveForm::begin([
        'id' => 'myFilterForm',
        'method' => 'get', // Chuyển từ POST sang GET
        'options' => [
            'class' => 'myFilterForm'
        ]
    ]); ?>

    <?= $form->field($model, 'id_loai_van_ban')->dropDownList(LoaiVanBan::getList(), ['prompt'=>'Chọn loại văn bản']) ?>
    
    <?= $form->field($model, 'nam')->dropDownList($model->getListSo(), [
	    'prompt'=>'Chọn sổ VB'
	]) ?>
	
	<div class="row">
		<div class="col-md-6">
        	<?= $form->field($model, 'so_vao_so')->textInput() ?>
        </div>
    	<div class="col-md-6">
    		<?= $form->field($model, 'so_vb')->textInput() ?>
    	</div>
    </div>
    
    <div class="row">
		<div class="col-md-6">
    		<?= $form->field($model, 'nguoi_ky')->textInput() ?>
    	</div>
    	<div class="col-md-6">
    		<?= $form->field($model, 'vbden_nguoi_nhan')->widget(Select2::classname(), [
                 'data' => NhanVien::getList(),
                    'language' => 'vi',
                    'options' => [
                        'placeholder' => 'Chọn người nhận...',
                        'data-dropdown-parent'=>"#offcanvasRight"
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
             ]);?>
    	</div>
   	</div>
    <?= $form->field($model, 'trich_yeu')->textInput() ?>
    
    <div class="row">
		<div class="col-md-6">
            <?= $form->field($model, 'vbden_ngay_den')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Chọn ngày đến ...'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd/mm/yyyy', // Đảm bảo khớp với định dạng trong CSDL
                ]
            ]); ?>
        </div>
        <div class="col-md-6">
			 <?= $form->field($model, 'vbden_ngay_chuyen')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Chọn ngày chuyển ...'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd/mm/yyyy',
                ]
            ]); ?>
       	</div>
     </div>

    <?php if (!Yii::$app->request->isAjax){ ?>
        <div class="form-group">
            <?= Html::submitButton('Tìm kiếm', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('Xóa tìm kiếm', ['class' => 'btn btn-outline-secondary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>

<style>
.van-ban-den-search label {
    font-weight: bold;
}
</style>
