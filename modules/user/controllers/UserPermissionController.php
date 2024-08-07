<?php

namespace app\modules\user\controllers;

use webvimark\components\BaseController;
use webvimark\modules\UserManagement\models\rbacDB\Permission;
use webvimark\modules\UserManagement\models\rbacDB\Role;
use app\modules\user\models\User;
use app\modules\user\UserModule;
use yii\web\NotFoundHttpException;
use Yii;
use yii\web\Response;
use yii\helpers\Html;

class UserPermissionController extends BaseController
{

	/**
	 * @param int $id User ID
	 *
	 * @throws \yii\web\NotFoundHttpException
	 * @return string
	 */
	public function actionSet($id, $createUserRole=NULL)
	{
	    $request = Yii::$app->request;
		$user = User::findOne($id);
		if($request->isAjax){
		    if($createUserRole=='create'){
		        $user->createUserRoleName();
		    }
		    /*
		     *   Process for ajax request
		     */
		    Yii::$app->response->format = Response::FORMAT_JSON;
    		if ( !$user )
    		{
    			throw new NotFoundHttpException('User not found');
    		}
    
    		$permissionsByGroup = [];
    		$permissions = Permission::find()
    			->andWhere([
    				Yii::$app->getModule('user-management')->auth_item_table . '.name'=>array_keys(Permission::getUserPermissions($user->id))
    			])
    			->joinWith('group')
    			->all();
    
    		foreach ($permissions as $permission)
    		{
    			$permissionsByGroup[@$permission->group->name][] = $permission;
    		}
    
    		//return $this->renderIsAjax('set', compact('user', 'permissionsByGroup'));
    		return [
    		    'title'=> "Phân quyền User",
    		    'content'=>$this->renderAjax('set', compact('user', 'permissionsByGroup')),
    		    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
    		    Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
    		];   
		} else {
		    throw new NotFoundHttpException('Yêu cầu không hợp lệ!');
		}
	}

	/**
	 * @param int $id - User ID
	 *
	 * @return \yii\web\Response
	 */
	public function actionSetRoles($id)
	{
	    $request = Yii::$app->request;
	    if($request->isAjax){
	        /*
	         *   Process for ajax request
	         */
	        Yii::$app->response->format = Response::FORMAT_JSON;
    		if ( !Yii::$app->user->isSuperadmin AND Yii::$app->user->id == $id )
    		{
    			Yii::$app->session->setFlash('error', UserModule::t('back', 'You can not change own permissions'));
    			return $this->redirect(['set', 'id'=>$id]);
    		}
    
    		$oldAssignments = array_keys(Role::getUserRoles($id));
    
    		// To be sure that user didn't attempt to assign himself some unavailable roles
    		$newAssignments = array_intersect(Role::getAvailableRoles(Yii::$app->user->isSuperAdmin, true), (array)Yii::$app->request->post('roles', []));
    
    		$toAssign = array_diff($newAssignments, $oldAssignments);
    		$toRevoke = array_diff($oldAssignments, $newAssignments);
    
    		foreach ($toRevoke as $role)
    		{
    			User::revokeRole($id, $role);
    		}
    
    		foreach ($toAssign as $role)
    		{
    			User::assignRole($id, $role);
    		}
    
    		Yii::$app->session->setFlash('success', UserModule::t('back', 'Đã lưu thông tin thành công'));
    
    		//return $this->redirect(['set', 'id'=>$id]);
    		$user = User::findOne($id);
    		if ( !$user )
    		{
    		    throw new NotFoundHttpException('User not found');
    		}
    		
    		$permissionsByGroup = [];
    		$permissions = Permission::find()
    		->andWhere([
    		    Yii::$app->getModule('user-management')->auth_item_table . '.name'=>array_keys(Permission::getUserPermissions($user->id))
    		])
    		->joinWith('group')
    		->all();
    		
    		foreach ($permissions as $permission)
    		{
    		    $permissionsByGroup[@$permission->group->name][] = $permission;
    		}
    		return [
    		    'title'=> "Phân quyền User",
    		    'content'=>$this->renderAjax('set', compact('user', 'permissionsByGroup')),
    		    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
    		    Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
    		];   
	    }
	}
}
