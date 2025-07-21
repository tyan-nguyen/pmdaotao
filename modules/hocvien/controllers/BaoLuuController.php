<?php

namespace app\modules\hocvien\controllers;

use Yii;
use app\models\HvHocVien;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\filters\AccessControl;
use app\modules\hocvien\models\search\DangKyHvSearch;
use app\modules\hocvien\models\HocVien;
use app\modules\hocvien\models\DangKyHv;
use app\modules\hocvien\models\NopHocPhi;
use yii\web\UploadedFile;
use app\custom\CustomFunc;
use yii\db\Expression;
use app\modules\hocvien\models\ThayDoiHocPhi;
use app\modules\hocvien\models\BaoLuu;
/**
 * HocVienController implements the CRUD actions for HvHocVien model.
 */
class BaoLuuController extends Controller
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
     * Bảo lưu hồ sơ cho học viên
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $idhv //id is id of hocvien
     * @return mixed
     */
    public function actionCreate($idhv)
    {
        $request = Yii::$app->request;
        $hocVien = DangKyHv::findOne($idhv);
        $model = new BaoLuu();
        Yii::$app->response->format = Response::FORMAT_JSON;
        if($request->isGet){
            return [
                'title'=> "Bảo lưu hồ sơ học viên #" . $idhv,
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
            $model->id_khoa = $hocVien->id_khoa_hoc;
            $model->hoc_phi_da_dong = $hocVien->tienDaNop;
            if($model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'forceClose'=>true,
                    'title'=> "Bảo lưu hồ sơ học viên #".$idhv,
                    'tcontent'=>'Bảo lưu hồ sơ thành công!',
                ];
            }
        }else{
            return [
                'title'=> "Bảo lưu hồ sơ học viên #" . $idhv,
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
     * Bảo lưu hồ sơ cho học viên
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id //id is id of baoluu
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = BaoLuu::findOne($id);
        $hocVien = DangKyHv::findOne($model->id_hoc_vien);
        
        Yii::$app->response->format = Response::FORMAT_JSON;
        if($request->isGet){
            return [
                'title'=> "Sửa thông tin bảo lưu hồ sơ học viên #" . $model->id_hoc_vien,
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
            $model->id_khoa = $hocVien->id_khoa_hoc;
            $model->hoc_phi_da_dong = $hocVien->tienDaNop;
            if($model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'forceClose'=>true,
                    'title'=> "Bảo lưu hồ sơ học viên #". $model->id_hoc_vien,
                    'tcontent'=>'Lưu thông tin thành công!',
                ];
            }
        }else{
            return [
                'title'=> "Sửa thông tin bảo lưu hồ sơ học viên #" . $model->id_hoc_vien,
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
     * Displays bảo lưu.
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
                'title' => "Lịch sử bảo lưu của học viên  #" . $idhv,
                'content' => $this->renderAjax('view', [
                    'model' => $model,
                ]),
                Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"])
            ];
        }
    }
    /**
     * in biên bản bảo lưu
     * @param unknown $id
     * @return \yii\web\Response
     */
    public function actionRpBaoLuuPrint($id){
        $model = BaoLuu::findOne($id);
        $content = $this->renderPartial('rp_bao_luu_print', [
            'model'=>$model
        ]);
        
        return $this->asJson([
            'status' => 'success',
            'content' => $content,
        ]);
    }
    
    
}