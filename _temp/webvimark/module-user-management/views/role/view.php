<?php
/**
 * @var yii\widgets\ActiveForm $form
 * @var array $childRoles
 * @var array $allRoles
 * @var array $routes
 * @var array $currentRoutes
 * @var array $permissionsByGroup
 * @var array $currentPermissions
 * @var yii\rbac\Role $role
 */

use webvimark\modules\UserManagement\components\GhostHtml;
use webvimark\modules\UserManagement\models\rbacDB\Role;
use webvimark\modules\UserManagement\UserManagementModule;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$this->title = $role->description;
Yii::$app->params['moduleID'] = 'Module Quản lý tài khoản';
Yii::$app->params['modelID'] = 'Phân quyền tài khoản';
?>

<h2 class="lte-hide-title"><?= $this->title ?></h2>

<?php if ( Yii::$app->session->hasFlash('success') ): ?>
	<!-- <div class="alert alert-success text-center"> -->
		<?php // Yii::$app->session->getFlash('success') ?>
		<div class="alert alert-success">
        	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true">×</button>
        	<span><svg xmlns="http://www.w3.org/2000/svg" height="40" width="40" viewBox="0 0 24 24">
        			<path fill="#28a745" d="M10.3125,16.09375a.99676.99676,0,0,1-.707-.293L6.793,12.98828A.99989.99989,0,0,1,8.207,11.57422l2.10547,2.10547L15.793,8.19922A.99989.99989,0,0,1,17.207,9.61328l-6.1875,6.1875A.99676.99676,0,0,1,10.3125,16.09375Z" opacity=".99"></path>
        			<path fill="#95dea5" d="M12,2A10,10,0,1,0,22,12,10.01146,10.01146,0,0,0,12,2Zm5.207,7.61328-6.1875,6.1875a.99963.99963,0,0,1-1.41406,0L6.793,12.98828A.99989.99989,0,0,1,8.207,11.57422l2.10547,2.10547L15.793,8.19922A.99989.99989,0,0,1,17.207,9.61328Z"></path>
        		</svg></span>
        	<strong>Chỉnh sửa thành công!</strong>
        	<hr class="message-inner-separator">
        	<p>Dữ liệu đã được lưu thành công!</p>
        </div>
	<!-- </div> -->
<?php endif; ?>

<p>
	<?= GhostHtml::a(UserManagementModule::t('back', 'Sửa'), ['update', 'id' => $role->name], ['class' => 'btn btn-sm btn-primary']) ?>
	<?= GhostHtml::a(UserManagementModule::t('back', 'Thêm mới'), ['create'], ['class' => 'btn btn-sm btn-success']) ?>
</p>

<div class="row">
	<div class="col-sm-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<strong>
					<span class="glyphicon glyphicon-th"></span> <?= UserManagementModule::t('back', 'Nhóm quyền con') ?>
				</strong>
			</div>
			<div class="panel-body">
				<?= Html::beginForm(['set-child-roles', 'id'=>$role->name]) ?>

				<?php foreach ($allRoles as $aRole): ?>
				<?php if( !str_starts_with($aRole['name'], 'user_') ):?>
					<label>
						<?php $isChecked = in_array($aRole['name'], ArrayHelper::map($childRoles, 'name', 'name')) ? 'checked' : '' ?>
						<input type="checkbox" <?= $isChecked ?> name="child_roles[]" value="<?= $aRole['name'] ?>">
						<?= $aRole['description'] ?>
					</label>

					<?= GhostHtml::a(
						'<span class="glyphicon glyphicon-edit"></span>',
						['/user-management/role/view', 'id'=>$aRole['name']],
						['target'=>'_blank']
					) ?>
					<br/>
				<?php endif; ?>
				<?php endforeach ?>


				<hr/>
				<?= Html::submitButton(
					'<span class="glyphicon glyphicon-ok"></span> Lưu lại',
					['class'=>'btn btn-primary btn-sm']
				) ?>

				<?= Html::endForm() ?>
			</div>
		</div>
	</div>

	<div class="col-sm-8">
		<div class="panel panel-default">
			<div class="panel-heading">
				<strong>
					<span class="glyphicon glyphicon-th"></span> Quyền
				</strong>
			</div>
			<div class="panel-body">
				<?= Html::beginForm(['set-child-permissions', 'id'=>$role->name]) ?>

				<div class="row">
					<?php foreach ($permissionsByGroup as $groupName => $permissions): ?>
					<?php if($groupName != 'User management'):?>
						<div class="col-sm-6">
							<fieldset>
								<legend><?= $groupName ?></legend>

								<?php foreach ($permissions as $permission): ?>
									<label>
										<?php $isChecked = in_array($permission->name, ArrayHelper::map($currentPermissions, 'name', 'name')) ? 'checked' : '' ?>
										<input type="checkbox" <?= $isChecked ?> name="child_permissions[]" value="<?= $permission->name ?>">
										<?= $permission->description ?>
									</label>

									<?= GhostHtml::a(
										'<span class="glyphicon glyphicon-edit"></span>',
										['/user-management/permission/view', 'id'=>$permission->name],
										['target'=>'_blank']
									) ?>
									<br/>
								<?php endforeach ?>

							</fieldset>
							<br/>
						</div>

					<?php endif;?>
					<?php endforeach ?>
				</div>

				<hr/>
				<?= Html::submitButton(
					'<span class="glyphicon glyphicon-ok"></span> Lưu lại',
					['class'=>'btn btn-primary btn-sm']
				) ?>

				<?= Html::endForm() ?>

			</div>
		</div>
	</div>
</div>

<?php
$this->registerJs(<<<JS

$('.role-help-btn').off('mouseover mouseleave')
	.on('mouseover', function(){
		var _t = $(this);
		_t.popover('show');
	}).on('mouseleave', function(){
		var _t = $(this);
		_t.popover('hide');
	});
JS
);
?>