<?php

namespace app\modules\banhang\controllers;

use Yii;
use app\modules\banhang\models\KhachHang;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\filters\AccessControl;

/**
 * KhachHangController implements the CRUD actions for KhachHang model.
 */
class KhachHangController extends Controller
{
    public function actionSearch($q = null)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $query = KhachHang::find()
            ->select(['id', "CONCAT(ho_ten, ' (', so_dien_thoai , ')') AS text"]);
        if (!empty($q)) {
            $query->andFilterWhere( [ 'OR',
                ['like', 'ho_ten', $q],
                ['like', 'so_dien_thoai', $q]
            ]);
        }
        $results = $query->orderBy(['id'=>SORT_DESC])->limit(10)->asArray()->all();
        return $results;
    }
    
    /**
     * refresh data in select2 dvt
     */
    public function actionRefreshSelect2($selected){
        Yii::$app->response->format = Response::FORMAT_JSON;
        //lay list khach hang
        $options = array();
        $vts = KhachHang::find()->all();
        if($vts != null){
            foreach ($vts as $indexVt => $vt){
                $options[$indexVt]['id'] = $vt->id;
                $options[$indexVt]['text'] = $vt->ho_ten;
                $options[$indexVt]['selected'] = $vt->id==$selected ? true : false;
            }
        }
        return $options;
    }
    
    /**
     * lấy thông tin khách hàng để tự động điền thông tin
     * @param int $idkh
     * @return string[]|NULL[]|string[]
     */
    public function actionGetKhachHangAjax($idkh){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $kh = KhachHang::findOne($idkh);
        if($kh != null){
            return [
                'status'=>'success',
                'khHoTen' => $kh->ho_ten,
                'khSDT' => $kh->so_dien_thoai,
                'khDiaChi' => $kh->dia_chi
            ];
        } else {
            return ['status'=>'failed'];
        }
    }   
}