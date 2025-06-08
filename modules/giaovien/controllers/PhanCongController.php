<?php

namespace app\modules\giaovien\controllers;

use Yii;
use app\modules\giaovien\models\GiaoVien;
use app\modules\giaovien\models\search\GiaoVienSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\modules\nhanvien\models\To;
//use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use Datetime;
use app\modules\lichhoc\models\LichHoc;
use yii\web\BadRequestHttpException;
use app\modules\nhanvien\models\PhongBan;


//use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\filters\VerbFilter;
use app\modules\thuexe\models\Xe;
use app\modules\daotao\models\GvXe;
use app\modules\hocvien\models\HocVien;
use app\modules\daotao\models\GvHv;
use app\modules\khoahoc\models\KhoaHoc;
/**
 * NhanVienController implements the CRUD actions for NhanVien model.
 */
class PhanCongController extends Controller
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
     * Lists all NhanVien models.
     * @return mixed
     */
    public function beforeAction($action)
    {
        Yii::$app->params['moduleID'] = 'Module Quản lý Giáo viên';
        Yii::$app->params['modelID'] = 'Quản lý Giáo viên';
        return parent::beforeAction($action);
    }
    
    /**
     * phân công giáo viên phụ trách chọn xe
     * @param unknown $id: id cua giao vien
     * @return string[]
     */
    public function actionPcXe($id){
        $request = Yii::$app->request;
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = GiaoVien::findOne($id);
        if($model == null){
            return [
                'title'=> 'Thông báo',
                'content'=>'Giáo viên không tồn tại trên hệ thống!',
                'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"])
            ];
        }
        if($request->isAjax){
            if($request->isGet){
                return [
                    'title'=> "Phân công xe cho giáo viên",
                    'content'=>$this->renderAjax('_formPcXe', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"]). '&nbsp;' .
                    Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"])
                ];
            }else if($model->load($request->post())){
                //xoa xe bỏ ra trước
                /* $listGvXes = GvXe::find()->where([
                    'id_giao_vien'=>$id
                ])->all();
                //listxe in form
                $listXeNew = array();
                if($model->listXe != null){
                    foreach ($model->listXe as $idXe => $val){
                       $listXeNew[] = $idXe; 
                    }
                }
                foreach ($listGvXes as $itemGvXe){
                    if(!in_array($itemGvXe->id_xe, $listXeNew)){
                        $itemGvXe->delete();
                    }
                } */
                //xu ly them vao khsx
                if($model->listXe != null){
                    foreach ($model->listXe as $idXe => $val){
                        $modelXe = Xe::findOne($idXe);
                        //if($modelHocVien!= null && $modelHocVien->id_giao_vien == null){
                        if($modelXe!=null){
                            $checkGvXe = GvXe::find()->where([
                                'id_giao_vien'=>$id,
                                'id_xe'=>$idXe,
                            ])->one();
                            //-------------------------
                            //-------------------------
                            //-------------------------
                            if(!$checkGvXe){
                                $gvxe = new GvXe();
                                $gvxe->id_giao_vien = $id;
                                $gvxe->id_xe = $idXe;
                                $gvxe->save();
                            }
                        }
                        //}
                    }
                    return [
                        'title'=> "Phân công xe cho giáo viên",
                        'content'=>$this->renderAjax('_formPcXe', [
                            'model' => $model,
                        ]),
                        'tcontent'=>'Phân công xe cho giáo viên thành công!',
                        'footer'=> Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"]). '&nbsp;' .
                        Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"])
                    ];  
                }else{
                    $model->addError('listXe', 'Vui lòng chọn ít nhất một xe để phân công cho giáo viên.');
                    return [
                        'title'=> "Phân công xe cho giáo viên",
                        'content'=>$this->renderAjax('_formPcXe', [
                            'model' => $model,
                        ]),
                        'footer'=> Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"]). '&nbsp;' .
                        Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"])
                    ];
                }
                              
                
            }else{
                return [
                    'title'=> "Phân công xe cho giáo viên",
                    'content'=>$this->renderAjax('_formPcXe', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"]). '&nbsp;' .
                    Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"])
                ];
            }
        }//if isAjax
    }
    
    /**
     * xóa phân công giáo viên phụ trách chọn xe
     * @param unknown $id: id cua gvxe
     * @return string[]
     */
    public function actionXoaPcXe($id){
        $request = Yii::$app->request;
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = GvXe::findOne($id);
        $idGiaoVien = $model->id_giao_vien;
        if($model == null){
            return [
                'title'=> 'Thông báo',
                'content'=>'Dữ liệu không tồn tại trên hệ thống!',
                'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"])
            ];
        }
        if($request->isAjax){
            $model->delete();
            return [
                'title'=> "Phân công xe cho giáo viên",
                'content'=>$this->renderAjax('_formPcXe', [
                    'model' => GiaoVien::findOne($idGiaoVien),
                ]),
                'tcontent'=>'Hủy phân công xe cho giáo viên thành công!',
                'footer'=> Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"]). '&nbsp;' .
                Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"])
            ];
        }//if isAjax
    }
    
    /**
     * form chọn khóa học để phân công học viên cho giáo viên
     * @param unknown $idgv: id cua giao vien
     * @return string[]
     */
    public function actionChonKhoaHoc($idgv){
        $request = Yii::$app->request;
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = GiaoVien::findOne($idgv);
        if($model == null){
            return [
                'title'=> 'Thông báo',
                'content'=>'Giáo viên không tồn tại trên hệ thống!',
                'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"])
            ];
        }
        if($request->isAjax){
            if($request->isGet){
                return [
                    'title'=> "Chọn khóa học để phân công học viên cho giáo viên",
                    'content'=>$this->renderAjax('_formChonKhoaHoc', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"])
                ];
            }
        }//if isAjax
    }
    
    /**
     * phân công giáo viên phụ trách học viên
     * @param unknown $id: id cua giao vien
     * @param unknown $idkh: id cua khoa hoc
     * @return string[]
     */
    public function actionPcHv($id, $idKh){
        $request = Yii::$app->request;
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = GiaoVien::findOne($id);
        $modelKhoaHoc = KhoaHoc::findOne($idKh);
        if($model == null || $modelKhoaHoc == null){
            return [
                'title'=> 'Thông báo',
                'content'=>'Giáo viên hoặc khóa học không tồn tại trên hệ thống!',
                'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"])
            ];
        }
        if($request->isAjax){
            if($request->isGet){
                return [
                    'title'=> "Phân công học viên cho giáo viên",
                    'content'=>$this->renderAjax('_formPcHv', [
                        'model' => $model,
                        'modelKhoaHoc' =>$modelKhoaHoc
                    ]),
                    'footer'=> Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"]). '&nbsp;' .
                    Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"])
                ];
            }else if($model->load($request->post())){
                if($model->listHocVien != null){
                    foreach ($model->listHocVien as $idHocVien => $val){
                        $modelHocVien = HocVien::findOne($idHocVien);
                        if($modelHocVien!=null){
                            $checkGvHv = GvHv::find()->where([
                                'id_giao_vien'=>$id,
                                'id_hoc_vien'=>$idHocVien,
                            ])->one();
                            //thêm mới gv-hv
                            if(!$checkGvHv){
                                $gvhv = new GvHv();
                                $gvhv->id_giao_vien = $id;
                                $gvhv->id_hoc_vien = $idHocVien;
                                $gvhv->save();
                            }
                        }
                    }
                    return [
                        'title'=> "Phân công học viên cho giáo viên",
                        'content'=>$this->renderAjax('_formPcHv', [
                            'model' => $model,
                            'modelKhoaHoc' =>$modelKhoaHoc
                        ]),
                        'tcontent'=>'Phân công học viên cho giáo viên thành công!',
                        'footer'=> Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"]). '&nbsp;' .
                        Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"])
                    ];
                }else{
                    $model->addError('listHocVien', 'Vui lòng chọn ít nhất một học viên để phân công cho giáo viên.');
                    return [
                        'title'=> "Phân công học viên cho giáo viên",
                        'content'=>$this->renderAjax('_formPcHv', [
                            'model' => $model,
                            'modelKhoaHoc' =>$modelKhoaHoc
                        ]),
                        'footer'=> Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"]). '&nbsp;' .
                        Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"])
                    ];
                }
                
                
            }else{
                return [
                    'title'=> "Phân công học viên cho giáo viên",
                    'content'=>$this->renderAjax('_formPcHv', [
                        'model' => $model,
                        'modelKhoaHoc' =>$modelKhoaHoc
                    ]),
                    'footer'=> Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"]). '&nbsp;' .
                    Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"])
                ];
            }
        }//if isAjax
    }
    
    /**
     * xóa phân công giáo viên phụ trách học viên
     * @param unknown $id: id cua gvhv
     * @return string[]
     */
    public function actionXoaPcHv($id, $idKh){
        $request = Yii::$app->request;
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = GvHv::findOne($id);
        $idGiaoVien = $model->id_giao_vien;
        if($model == null){
            return [
                'title'=> 'Thông báo',
                'content'=>'Dữ liệu không tồn tại trên hệ thống!',
                'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"])
            ];
        }
        if($request->isAjax){
            $model->delete();
            return [
                'title'=> "Phân công học viên cho giáo viên",
                'content'=>$this->renderAjax('_formPcHv', [
                    'model' => GiaoVien::findOne($idGiaoVien),
                    'modelKhoaHoc' =>KhoaHoc::findOne($idKh),
                ]),
                'tcontent'=>'Hủy phân công học viên cho giáo viên thành công!',
                'footer'=> Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"]). '&nbsp;' .
                Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"])
            ];
        }//if isAjax
    }
    
    
}