<?php

namespace app\modules\demxe\controllers;

use app\modules\demxe\controllers\LuotXeController;
use app\modules\demxe\models\DemXe;
use app\modules\demxe\models\search\DemXeSearch;
use Yii;

class CongChinhController extends LuotXeController
{
    /**
     * Lists all DemXe models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DemXeSearch();
        if (isset($_POST['search']) && $_POST['search'] != null) {
            $dataProvider = $searchModel->search(Yii::$app->request->post(), $_POST['search'], DemXe::CONG3);
        } else if ($searchModel->load(Yii::$app->request->post())) {
            $searchModel = new DemXeSearch(); // "reset"
            $dataProvider = $searchModel->search(Yii::$app->request->post(), null, DemXe::CONG3);
        } else {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, null, DemXe::CONG3);
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
