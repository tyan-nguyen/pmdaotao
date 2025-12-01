<?php

namespace app\modules\vanban\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\filters\AccessControl;
use app\modules\vanban\models\VanBan;
use app\modules\vanban\models\search\VanBanSearch;

/**
 * VbDenController implements the CRUD actions for VanBanDen model.
 */
class VanBanController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'ghost-access'=> [
                'class' => 'webvimark\modules\UserManagement\components\GhostAccessControl',
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    
    public function beforeAction($action)
    {
        Yii::$app->params['moduleID'] = 'Module Văn bản ';
        Yii::$app->params['modelID'] = 'Tra cứu văn bản';
        return parent::beforeAction($action);
    }
    
    /**
     * Lists all VanBanDen models.
     * @return mixed
     */
    public function actionTraCuu()
    {
        $searchModel = new VanBanSearch();
        
        if (isset($_POST['search']) && $_POST['search'] != null) {
            $dataProvider = $searchModel->search(Yii::$app->request->post(), $_POST['search']);
        } else if ($searchModel->load(Yii::$app->request->post())) {
            // Nếu có dữ liệu POST nhưng không có từ khóa tìm kiếm, nạp dữ liệu vào mô hình tìm kiếm
            $searchModel = new VanBanSearch(); // "reset"
            $dataProvider = $searchModel->search(Yii::$app->request->post());
        } else {
            // Nếu không có dữ liệu POST, chỉ gọi phương thức search với tham số queryParams
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        }
        
        // Render view 'index' và truyền đối tượng tìm kiếm và data provider vào view
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }    
    
}
