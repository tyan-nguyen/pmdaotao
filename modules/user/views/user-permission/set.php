<?php
/**
 * @var yii\web\View $this
 * @var array $permissionsByGroup
 * @var webvimark\modules\UserManagement\models\User $user
 */

use webvimark\modules\UserManagement\components\GhostHtml;
use webvimark\modules\UserManagement\models\rbacDB\Role;
use yii\bootstrap5\BootstrapPluginAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

BootstrapPluginAsset::register($this);
$this->title = 'Phân quyền cho tài khoản: '. $user->username;
$checkRoleName = false;
?>

<div class="user-permission-form container-fluid formInput">    
    <?php if ( Yii::$app->session->hasFlash('success') ): ?>
    	<div class="alert alert-success text-center">
    		<?= Yii::$app->session->getFlash('success') ?>
    	</div>
    <?php endif; ?>
    
    <div class="row">
    	<div class="col-md-12">
        	<div class="card custom-card">
        		<div class="row">
        			<div class="col-md-4">
            			<div class="card-body pd-20 pd-md-40 shadow-none">
                        	<h5 class="card-title mg-b-20">Nhóm quyền</h5>
                        	<p class="text-muted card-sub-title mt-1">
                        		Chọn mục cần phân quyền cho tài khoản
                        	</p>
    
    				<?= Html::beginForm(['set-roles', 'id'=>$user->id]) ?>
    
    				<?php foreach (Role::getAvailableRoles() as $aRole): ?>
    					<?php if( $aRole['name']==$user->userRoleName){$checkRoleName = true;}?>
    					<?php if( $aRole['name']==$user->userRoleName || !str_starts_with($aRole['name'], 'user_') ):?>
    					<label>
    						<?php $isChecked = in_array($aRole['name'], ArrayHelper::map(Role::getUserRoles($user->id), 'name', 'name')) ? 'checked' : '' ?>
    
    						<?php if ( Yii::$app->getModule('user-management')->userCanHaveMultipleRoles ): ?>
    							<input type="checkbox" <?= $isChecked ?> name="roles[]" value="<?= $aRole['name'] ?>">
    
    						<?php else: ?>
    							<input type="radio" <?= $isChecked ?> name="roles" value="<?= $aRole['name'] ?>">
    
    						<?php endif; ?>
    
    						<?= $aRole['description'] ?>
    					</label>
    
    					<?= GhostHtml::a(
    						'<span class="glyphicon glyphicon-edit"></span>',
    						['/user-management/role/view', 'id'=>$aRole['name']],
    						['target'=>'_blank']
    					) ?>
    					<br/>
    					<?php endif;?>
    				<?php endforeach ?>
    
    				<br/>
    				
    				<?php if($checkRoleName==false):?>
    				
    				<?= Html::a(
    						'<span class="glyphicon glyphicon-edit"></span> Tạo phân quyền tùy chỉnh cho tài khoản',
    						[Yii::getAlias('@web/user/user-permission/set'), 'id'=>$user->id, 'createUserRole'=>'create'],
    						['data-pjax'=>1, 'role'=>'modal-remote']
    					) ?>
    				
    				<?php endif;?>
    
    				<?php /*if ( Yii::$app->user->isSuperadmin OR Yii::$app->user->id != $user->id ): ?>
    
    					<?= Html::submitButton(
    						'<span class="glyphicon glyphicon-ok"></span> ' . UserModule::t('back', 'Save'),
    						['class'=>'btn btn-primary btn-sm']
    					) ?>
    				<?php else: ?>
    					<div class="alert alert-warning well-sm text-center">
    						<?= UserModule::t('back', 'You can not change own permissions') ?>
    					</div>
    				<?php endif; */ ?>
    
    
    				<?= Html::endForm() ?>
    			</div><!-- card-body -->
			</div><!-- col-md-6 -->  
    
        	<div class="col-md-8">
    			<div class="card-body pd-20 pd-md-40 shadow-none">
                	<h5 class="card-title mg-b-20">Thông tin quyền tài khoản</h5>
                	<p class="text-muted card-sub-title mt-1">
                		Các quyền tài khoản có thể thực hiện
                	</p> 
                	<div class="row">
    					<?php foreach ($permissionsByGroup as $groupName => $permissions): ?>
    						
    						<div class="col-sm-6">
    							<fieldset>
    								<legend><?= $groupName ?></legend>
    
    								<ul>
    									<?php foreach ($permissions as $permission): ?>
    										<li>
    											<?= $permission->description ?>
    
    											<?= GhostHtml::a(
    												'<span class="glyphicon glyphicon-edit"></span>',
    												['/user-management/permission/view', 'id'=>$permission->name],
    												['target'=>'_blank']
    											) ?>
    										</li>
    									<?php endforeach ?>
    								</ul>
    							</fieldset>
    
    							<br/>
    						</div>
    						
    
    					<?php endforeach ?>
    					</div>
    
    				</div><!-- card-body -->
				</div><!-- col-md-6 --> 
					
					
    		</div><!-- row 2 -->
			</div><!-- card -->
		</div><!-- col-md-12 -->
    </div><!-- row -->

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