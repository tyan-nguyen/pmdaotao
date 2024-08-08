<?php

namespace app\modules\vanban\controllers;
use yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use app\modules\vanban\models\VanBan;
/**
 * Default controller for the `vanban` module
 */
class VanBanDenController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $query = VanBan::find()->where(['id_loai_van_ban' => 1]);
    
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
    
        return $this->render('index', [
            'vanBanDenDataProvider' => $dataProvider,
        ]);
    }
    

    // Thêm văn bản đến
    public function actionCreate()
    {
        $model = new VanBan(['scenario' => VanBan::SCENARIO_VANBAN_DEN]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    // Sửa văn bản đến
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = VanBan::SCENARIO_VANBAN_DEN;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    // Xóa văn bản đến
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    // Hiển thị chi tiết văn bản đến
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    // Tìm model văn bản đến
    protected function findModel($id)
    {
        if (($model = VanBan::findOne(['id' => $id, 'id_loai_van_ban' => 2])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
