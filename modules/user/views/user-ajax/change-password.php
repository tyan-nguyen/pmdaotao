<?php

use webvimark\modules\UserManagement\UserManagementModule;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var webvimark\modules\UserManagement\models\User $model
 */

$this->title = 'Thay đổi mật khẩu cho tài khoản: ' . $model->username;

?>

<div class="user-update">

	<p class="text-primary"><?= $this->title ?></p>

	<div class="panel panel-default">
		<div class="panel-body">

			<div class="user-form">

				<?php $form = ActiveForm::begin([
					'id'=>'user',
					'layout'=>'horizontal',
				]); ?>

				<?= $form->field($model, 'password')->passwordInput(['maxlength' => 255, 'autocomplete'=>'off']) ?>

				<?= $form->field($model, 'repeat_password')->passwordInput(['maxlength' => 255, 'autocomplete'=>'off']) ?>


				<!-- <div class="form-group">
					<div class="col-sm-offset-3 col-sm-9">
						<?php if ( $model->isNewRecord ): ?>
							<?= Html::submitButton(
								'<span class="glyphicon glyphicon-plus-sign"></span> ' . UserManagementModule::t('back', 'Create'),
								['class' => 'btn btn-success']
							) ?>
						<?php else: ?>
							<?= Html::submitButton(
								'<span class="glyphicon glyphicon-ok"></span> ' . UserManagementModule::t('back', 'Save'),
								['class' => 'btn btn-primary']
							) ?>
						<?php endif; ?>
					</div>
				</div>-->

				<?php ActiveForm::end(); ?>

			</div>
		</div>
	</div>

</div>
