<?php
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use app\modules\kholuutru\models\LoaiFile;

/* @var $this yii\web\View */
/* @var $model app\modules\kholuutru\models\File */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="hinh-anh-form">

    <?php $form = ActiveForm::begin(['layout' => 'horizontal',
        'id' => 'docs-form', 
        'options' => [
            'class' => 'form-horizontal dropzone',
            'enctype' => 'multipart/form-data',
            //'data-pjax' => 1
        ],
        'fieldConfig' => [
            'template' => '<div class="col-sm-4">{label}</div><div class="col-sm-8">{input}{error}</div>',
            'labelOptions' => ['class' => 'col-md-12 control-label'],
        ],
    ]); ?>
    
    <?php if(!$loaiFile){
   	    echo $form->field($model, 'loai_file')->dropDownList(LoaiFile::getAllByDoiTuongArr($doiTuong), [
   	        'prompt' => '-Chọn loại file-'
   	    ]);
     } ?>
    
    <?= $model->isNewRecord ? $form->field($model, 'file')->fileInput() : '' ?>

    <?= $form->field($model, 'file_display_name')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'ghi_chu')->textarea(['rows' => 6]) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
