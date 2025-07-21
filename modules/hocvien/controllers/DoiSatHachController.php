<?php

namespace app\modules\hocvien\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\modules\hocvien\models\DoiSatHach;
use app\modules\hocvien\models\DangKyHv;
/**
 * HocVienController implements the CRUD actions for HvHocVien model.
 */
class DoiSatHachController extends Controller
{
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
     * Thêm mới yêu cầu thay đổi ngày sát hạch
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $idhv //id is id of hocvien
     * @return mixed
     */
    public function actionCreate($idhv)
    {
        $request = Yii::$app->request;
        $hocVien = DangKyHv::findOne($idhv);
        $model = new DoiSatHach();
        Yii::$app->response->format = Response::FORMAT_JSON;
        if($request->isGet){
            return [
                'title'=> "Thay đổi ngày sát hạch học viên #" . $idhv,
                'content'=>$this->renderAjax('form', [
                    'model' => $model,
                    'hocVien' => $hocVien
                ]),
                'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
            ];
        }else if($model->load($request->post())){
            $model->id_hoc_vien = $hocVien->id;
            $model->id_hang = $hocVien->id_hang;
            if($model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'forceClose'=>true,
                    'title'=> "Thay đổi ngày sát hạch học viên #".$idhv,
                    'tcontent'=>'Đăng ký thay đổi ngày sát hạch thành công!',
                ];
            }
        }else{
            return [
                'title'=> "Thay đổi ngày sát hạch học viên #" . $idhv,
                'content'=>$this->renderAjax('form', [
                    'model' => $model,
                    'hocVien' => $hocVien
                ]),
                'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
            ];
        }
    }
    /**
     * chỉnh sửa yêu cầu thay đổi ngày sát hạch
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id //id is id of baoluu
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = DoiSatHach::findOne($id);
        $hocVien = DangKyHv::findOne($model->id_hoc_vien);
        
        Yii::$app->response->format = Response::FORMAT_JSON;
        if($request->isGet){
            return [
                'title'=> "Sửa yêu cầu thay đổi ngày sát hạch của học viên #" . $model->id_hoc_vien,
                'content'=>$this->renderAjax('form', [
                    'model' => $model,
                    'hocVien' => $hocVien
                ]),
                'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
            ];
        }else if($model->load($request->post())){
            $model->id_hoc_vien = $hocVien->id;
            $model->id_hang = $hocVien->id_hang;
            if($model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'forceClose'=>true,
                    'title'=> "Sửa yêu cầu thay đổi ngày sát hạch của học viên #". $model->id_hoc_vien,
                    'tcontent'=>'Lưu thông tin thành công!',
                ];
            }
        }else{
            return [
                'title'=> "Sửa yêu cầu thay đổi ngày sát hạch của học viên #" . $model->id_hoc_vien,
                'content'=>$this->renderAjax('form', [
                    'model' => $model,
                    'hocVien' => $hocVien
                ]),
                'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
            ];
        }
    }
    /**
     * Displays yêu cầu đổi ngày sát hạch.
     * @param integer $idhv --> id của học viên
     * @return mixed
     */
    public function actionView($idhv)
    {
        $model = DangKyHv::findOne($idhv);
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => "Lịch sử đổi ngày sát hạch của học viên  #" . $idhv,
                'content' => $this->renderAjax('view', [
                    'model' => $model,
                ]),
                Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"])
            ];
        }
    }
    /**
     * in biên bản yêu cầu dời ngày sát hạch
     * @param unknown $id
     * @return \yii\web\Response
     */
    public function actionRpDoiSatHachPrint($id){
        $model = DoiSatHach::findOne($id);
        $content = $this->renderPartial('rp_bao_luu_print', [
            'model'=>$model
        ]);
        
        return $this->asJson([
            'status' => 'success',
            'content' => $content,
        ]);
    }
    
    
}