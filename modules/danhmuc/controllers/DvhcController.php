<?php

namespace app\modules\danhmuc\controllers;

use yii\web\Controller;
use app\modules\danhmuc\models\DmXa;
use Yii;

/**
 * Default controller for the `danhmuc` module
 */
class DvhcController extends Controller
{
    /**
     * use địa chỉ
     * @param unknown $q
     * @return array|\yii\db\ActiveRecord[]
     */
    public function actionSearchXa($q = null)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;        
        
        $query = DmXa::find()->alias('t')
            ->joinWith(['tinh as ti'])    
            ->select(['t.id', "CONCAT(t.ten_xa_full, ' (', ti.ten_tinh , ')') AS text"]);
        if (!empty($q)) {
            $query->andFilterWhere( [ 'OR',
                ['like', 't.ten_xa_full', $q],
                ['like', 'ti.ten_tinh_full', $q]
            ]);
        }
        $results = $query->orderBy(['t.stt'=>SORT_ASC])->limit(20)->asArray()->all();
        return $results;
    }
    
    /**
     * get id of tinh by id cua xa
     */
    public function actionGetTinhByXa(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $idxa = \Yii::$app->request->post('idxa');
        
        $xa = DmXa::findOne($idxa);
        if($xa!=null){
            $value = $xa->id_tinh;
            $text = $xa->tinh->ten_tinh_full;
        }else{
            $value = '';
            $text = '';
        }
        return [
            'value' => $value,
            'text' => $text,
        ];
    }
}
