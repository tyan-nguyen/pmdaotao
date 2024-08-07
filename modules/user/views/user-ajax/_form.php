<?php
//use yii\bootstrap5\Html;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use app\modules\user\models\User;

/* @var $this yii\web\View */
/* @var $model app\modules\user\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kuser-form container-fluid formInput">
    <?php $form = ActiveForm::begin([
        'layout' => 'horizontal',
        'options' => [
            'class' => 'form-horizontal'
        ],
        'fieldConfig' => [
            'template' => '<div class="col-sm-4">{label}</div><div class="col-sm-8">{input}{error}</div>',
            'labelOptions' => ['class' => 'col-md-12 control-label'],
        ],
    ]);?>
    <div class="row">
    	<div class="col-md-12">
        	<div class="card custom-card">
        		<div class="row">
        			<div class="col-md-6">
            			<div class="card-body pd-20 pd-md-40 shadow-none">
                        	<h5 class="card-title mg-b-20">Thông tin Tài khoản</h5>
                        	<p class="text-muted card-sub-title mt-1">
                        		Nhập thông tin tài khoản
                        	</p>

                            
                        
                            <?php // $form->errorSummary($model) ?>
                            
                            <?= $form->field($model->loadDefaultValues(), 'status')
                        		->dropDownList(User::getStatusList()) ?>
                        
                            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
                            
                            
                        
                            <?php // $form->field($model, 'status')->textInput() ?>
                        
                            <?= $form->field($model, 'bind_to_ip')->textInput(['maxlength' => true]) ?>
                        
                            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                        
                            <?php // $form->field($model, 'email_confirmed')->textInput() ?>
						</div><!-- card-body -->
					</div><!-- col-md-6 -->  
					<div class="col-md-6">
            			<div class="card-body pd-20 pd-md-40 shadow-none">
                        	<h5 class="card-title mg-b-20">Thông tin mật khẩu</h5>
                        	<p class="text-muted card-sub-title mt-1">
                        		<?= $model->isNewRecord ? 'Nhập thông tin mật khẩu' : 'Vui lòng chọn chức năng thay đổi mật khẩu để cập nhật lại mật khẩu mới' ?>
                        	</p> 
                        	<?php if ( $model->isNewRecord ): ?>
                        
                        		<?= $form->field($model, 'password')->passwordInput(['maxlength' => 255, 'autocomplete'=>'off']) ?>
                        
                        		<?= $form->field($model, 'repeat_password')->passwordInput(['maxlength' => 255, 'autocomplete'=>'off']) ?>
                        	<?php endif; ?>
						</div><!-- card-body -->
					</div><!-- col-md-6 --> 
				</div><!-- row 2 -->
			</div><!-- card -->
		</div><!-- col-md-12 -->
    </div><!-- row -->
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
