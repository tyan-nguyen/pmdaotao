<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\modules\khoahoc\models\KhoaHoc;
use app\modules\lichhoc\models\PhongHoc;
use app\modules\nhanvien\models\NhanVien;
use kartik\select2\Select2;
use kartik\datetime\DateTimePicker;
?>

<div class="lich-thi-search">
<?php $form = ActiveForm::begin([
        'id' => 'myFilterForm',
        'method' => 'get', 
        'options' => [
            'class' => 'myFilterForm'
        ]
]); ?>

<div class ="row">
         <div class="col-md-4">
             <?= $form->field($model, 'id_khoa_hoc')->widget(Select2::classname(), [
                 'data' => KhoaHoc::getList(),
                    'language' => 'vi',
                    'options' => ['placeholder' => 'Chọn khóa học...','id'=>'khoa-hoc2-dropdown'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
             ]);?>
         </div>
         <div class="col-md-4">
            <?= $form->field($model, 'id_nhom')->dropDownList([], [
                'id' => 'nhom2-dropdown', 
                'prompt' => 'Chọn nhóm...',
             ]) ?>
         </div>

         <div class="col-md-4">
            <?= $form->field($model, 'id_phong_thi')->widget(Select2::classname(), [
                 'data' => PhongHoc::getList(),
                    'language' => 'vi',
                    'options' => ['placeholder' => 'Chọn phòng học...'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
             ]);?>
         </div>
         <div class="col-md-4">
             <?= $form->field($model, 'id_giao_vien_gac')->widget(Select2::classname(), [
                 'data' => NhanVien::getList(),
                    'language' => 'vi',
                    'options' => ['placeholder' => 'Chọn cán bộ coi thi...'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
             ]);?>
         </div>
         <div class="col-md-4">
                   <?= $form->field($model, 'thoi_gian_thi')->widget(\kartik\datetime\DateTimePicker::classname(), [
                     'options' => ['placeholder' => 'Chọn thời gian thi...'],
                     'name' => 'dp_2',
                     'type' => DateTimePicker::TYPE_COMPONENT_PREPEND,
                     'language' => 'vi',
                     'pluginOptions' => [
                     'autoclose' => true,
                     'format' => 'hh:ii dd-mm-yyyy',
                     ]
                  ]); ?>
         </div>
    </div>
<div class="row">
   <?php if (!Yii::$app->request->isAjax){ ?>
    <div class="col-md-12 text-left">
        <div class="form-group mb-0">
	        <?= Html::submitButton('<i class="fe fe-search"></i> Tìm kiếm',['class' => 'btn btn-primary']) ?>
	        <?= Html::resetButton('<i class="fe fe-x"></i> Xóa tìm kiếm', ['class' => 'btn btn-info']) ?>
	    </div>
    </div>
    <?php } ?>
</div>
    <?php ActiveForm::end(); ?>
    
</div>


