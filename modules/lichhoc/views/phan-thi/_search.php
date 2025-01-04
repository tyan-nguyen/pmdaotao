<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\modules\hocvien\models\HangDaoTao;
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
               <?= $form->field($model, 'ten_phan_thi')->textInput(['maxlength' => true]) ?>
         </div>
         <div class="col-md-4">
                <?= $form->field($model, 'id_hang')->dropDownList(
                   HangDaoTao::getList(), 
                     [
                         'prompt' => 'Chọn hạng',
                         'class' => 'form-control dropdown-with-arrow',
                         'id' => 'hang-dropdown',
                     ]
                ) ?>
         </div>
         <div class="col-md-4">
              <?= $form->field($model, 'diem_dat_toi_thieu')->textInput(['type' => 'number', 'min' => 0]) ?>
         </div>
         <div class="col-md-4">
         <?= $form->field($model, 'thu_tu_thi')->dropDownList(
               [
                  '1' => '1',
                  '2' => '2',
                  '3' => '3',
                  '4' => '4',
                  '5' => '5',
               ],
               [
                  'prompt' => 'Chọn thứ tự phần thi', 
                  'id' => 'luot-thi-dropdown',
               ]
            ) ?>
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


