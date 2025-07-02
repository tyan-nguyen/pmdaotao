<?php
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use app\modules\user\models\User;
use app\modules\user\models\UserBase;
use app\modules\hocvien\models\base\HocVienBase;

/* @var $this yii\web\View */
/* @var $model app\modules\kholuutru\models\KhoLuuTru */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="kho-luu-tru-search">

    <?php $form = ActiveForm::begin([
            'id' => 'myFilterForm',
            'method' => 'get', // Chuyển từ POST sang GET
            'options' => [
                'class' => 'myFilterForm'
            ]
      	]); ?>
	<div class="row">
		<div class="col-md-2">
          <?= $form->field($model->loadDefaultValues(), 'status')
        		->dropDownList(User::getStatusList()) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
        </div>
            <?php // $form->field($model, 'status')->textInput() ?>
        <!-- <div class="col-md-2">
            <?= $form->field($model, 'bind_to_ip')->textInput(['maxlength' => true]) ?>
        </div>  -->
        <!-- 
        <div class="col-md-2">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div> -->
         <div class="col-md-2">
            <?= $form->field($model, 'ho_ten')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-2">
        	<?= $form->field($model, 'user_type')->dropDownList(
                UserBase::getDmLoaiTaiKhoan(),
                ['prompt'=>'-Chọn loại tài khoản-']
            ) ?>
        </div>
        <div class="col-md-2">
        	<?= $form->field($model, 'noi_dang_ky')->dropDownList(
                HocVienBase::getDmNoiDangKy(),
                ['prompt'=>'-Chọn nơi nhận hồ sơ-']
                ) ?>
    	</div>
  		<div class="col-md-2">
  			<label>&nbsp;</label>
        	<?php if (!Yii::$app->request->isAjax){ ?>
        	  	<div class="form-group">
        	        <?= Html::submitButton('Tìm kiếm',['class' => 'btn btn-primary']) ?>
        	        <?= Html::resetButton('Xóa TK', ['class' => 'btn btn-outline-secondary']) ?>
        	    </div>
        	<?php } ?>
    	</div>
	
	</div>

    <?php ActiveForm::end(); ?>
    
</div>
