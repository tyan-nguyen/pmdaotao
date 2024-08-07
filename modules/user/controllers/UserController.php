<?php

namespace app\modules\user\controllers;

use webvimark\components\AdminDefaultController;
use Yii;
use app\modules\user\models\User;
use webvimark\modules\UserManagement\models\search\UserSearch;
use yii\web\NotFoundHttpException;
use app\modules\dungchung\models\HistorySearch;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends AdminDefaultController
{
	/**
	 * @var User
	 */
	public $modelClass = 'app\modules\user\models\User';

	/**
	 * @var UserSearch
	 */
	public $modelSearchClass = 'webvimark\modules\UserManagement\models\search\UserSearch';

	/**
	 * @return mixed|string|\yii\web\Response
	 */
	public function actionCreate()
	{
		$model = new User(['scenario'=>'newUser']);

		if ( $model->load(Yii::$app->request->post()) && $model->save() )
		{
			return $this->redirect(['view',	'id' => $model->id]);
		}

		return $this->renderIsAjax('create', compact('model'));
	}

	/**
	 * @param int $id User ID
	 *
	 * @throws \yii\web\NotFoundHttpException
	 * @return string
	 */
	public function actionChangePassword($id)
	{
		$model = User::findOne($id);

		if ( !$model )
		{
			throw new NotFoundHttpException('User not found');
		}

		$model->scenario = 'changePassword';

		if ( $model->load(Yii::$app->request->post()) && $model->save() )
		{
			return $this->redirect(['view',	'id' => $model->id]);
		}

		return $this->renderIsAjax('changePassword', compact('model'));
	}
	
	/** 
	 * Xem lich su hoat dong ca nhan
	 * @return string
	 */
	public function actionActivity(){
	    Yii::$app->params['moduleID'] = 'Tài khoản';
	    Yii::$app->params['modelID'] = 'Lịch sử hoạt động';
	    $searchModel = new HistorySearch();
	    if ($searchModel->load(Yii::$app->request->post())) {
	        $searchModel = new HistorySearch(); // "reset"
	        $searchModel->nguoi_tao = Yii::$app->user->id;
	        $dataProvider = $searchModel->search(Yii::$app->request->post());
	    } else {
	        $searchModel->nguoi_tao = Yii::$app->user->id;
	        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
	    }
	    return $this->render('activity', [
	        'searchModel' => $searchModel,
	        'dataProvider' => $dataProvider,
	    ]);
	}

}
