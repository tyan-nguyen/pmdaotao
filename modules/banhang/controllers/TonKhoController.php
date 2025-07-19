<?php

namespace app\modules\banhang\controllers;

use Yii;
use app\modules\banhang\models\HangHoa;
use app\modules\banhang\models\search\HangHoaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\filters\AccessControl;
use app\modules\banhang\models\DVT;
use app\modules\banhang\models\HangHoaLichSu;

class TonKhoController extends Controller
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
    
    /**
     * nhập kho lẻ
     */
    public function actionNhapKhoLe($id){
        $request = Yii::$app->request;
        $model = HangHoa::findOne($id);
        $modelNhapKho = new HangHoaLichSu();

        Yii::$app->response->format = Response::FORMAT_JSON;
        if($request->isGet){
            return [
                'title'=> "Nhập kho hàng hóa",
                'content'=>$this->renderAjax('nhap-kho', [
                    'model' => $model,
                    'modelNhapKho' => $modelNhapKho
                ]),
                'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                
            ];
        }else if($modelNhapKho->load($request->post())){
            $modelNhapKho->id_hang_hoa = $model->id;
            $modelNhapKho->so_luong_cu = $model->so_luong;
            $modelNhapKho->loai_thay_doi = HangHoaLichSu::LOAI_NHAPXUATKHO;
            if($modelNhapKho->so_luong){
                $modelNhapKho->so_luong_moi = $model->so_luong + $modelNhapKho->so_luong;
            }
            if($modelNhapKho->save()){
                //chinh sua so luong cua hang hoa
                $model->so_luong = $model->so_luong + $modelNhapKho->so_luong;
                $model->save();
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'forceClose'=>true,
                    'tcontent'=>'Nhập kho hàng hóa thành công!'
                ];
            }else{
                return [
                    'title'=> "Nhập kho hàng hóa",
                    'content'=>$this->renderAjax('nhap-kho', [
                        'model' => $model,
                        'modelNhapKho' => $modelNhapKho
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                    Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                    
                ];
            }
        }else{
            return [
                'title'=> "Nhập kho hàng hóa",
                'content'=>$this->renderAjax('nhap-kho', [
                    'model' => $model,
                    'modelNhapKho' => $modelNhapKho
                ]),
                'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                
            ];
        }
    }
    /**
     * xuất kho lẻ
     */
    public function actionXuatKhoLe($id){
        $request = Yii::$app->request;
        $model = HangHoa::findOne($id);
        $modelXuatKho = new HangHoaLichSu();
        
        Yii::$app->response->format = Response::FORMAT_JSON;
        if($request->isGet){
            return [
                'title'=> "Xuất kho hàng hóa",
                'content'=>$this->renderAjax('xuat-kho', [
                    'model' => $model,
                    'modelXuatKho' => $modelXuatKho
                ]),
                'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                
            ];
        }else if($modelXuatKho->load($request->post())){
            $modelXuatKho->id_hang_hoa = $model->id;
            $modelXuatKho->so_luong_cu = $model->so_luong;
            $modelXuatKho->loai_thay_doi = HangHoaLichSu::LOAI_NHAPXUATKHO;
            if($modelXuatKho->so_luong){
                $modelXuatKho->so_luong_moi = $model->so_luong - $modelXuatKho->so_luong;
                $modelXuatKho->so_luong = -$modelXuatKho->so_luong;
            }
            if($modelXuatKho->save()){
                //chinh sua so luong cua hang hoa
                $model->so_luong = $modelXuatKho->so_luong_moi;
                $model->save();
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'forceClose'=>true,
                    'tcontent'=>'Xuất kho hàng hóa thành công!'
                ];
            }else{
                return [
                    'title'=> "Xuất kho hàng hóa",
                    'content'=>$this->renderAjax('xuat-kho', [
                        'model' => $model,
                        'modelXuatKho' => $modelXuatKho
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                    Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                    
                ];
            }
        }else{
            return [
                'title'=> "Xuất kho hàng hóa",
                'content'=>$this->renderAjax('xuat-kho', [
                    'model' => $model,
                    'modelXuatKho' => $modelXuatKho
                ]),
                'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                
            ];
        }
    }
}