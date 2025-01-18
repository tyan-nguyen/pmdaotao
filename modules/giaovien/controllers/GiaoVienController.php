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
/**
 * NhanVienController implements the CRUD actions for NhanVien model.
 */
class GiaoVienController extends Controller
{
   

    /**
     * Lists all NhanVien models.
     * @return mixed
     */
    public function beforeAction($action)
	{
	    Yii::$app->params['moduleID'] = 'Module Quản lý Giáo viên';
	    Yii::$app->params['modelID'] = 'Quản lý Giáo viên';
	    return true;
	}
    
    public function actionIndex()
    {    
        $searchModel = new GiaoVienSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['doi_tuong' => ['1']]);
        $pagination = $dataProvider->getPagination();
        $pagination->pageSize = 20;
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'pagination' =>$pagination,
        ]);
    }


    /**
     * Displays a single NhanVien model.
     * @param integer $id
     * @return mixed
     */
    public function actionView2($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Giáo viên #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::a('Sửa',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    public function actionView($id)
{   
    $request = Yii::$app->request;

    // Lấy ngày bắt đầu và kết thúc từ bảng LichHoc
    $ngayBD = (new \yii\db\Query())
        ->select(['MIN(ngay)'])
        ->from('lh_lich_hoc') 
        ->where(['id_giao_vien' => $id])
        ->scalar(); 
    
    $ngayKT = (new \yii\db\Query())
        ->select(['MAX(ngay)'])
        ->from('lh_lich_hoc')
        ->where(['id_giao_vien' => $id])
        ->scalar();

    // Định dạng ngày
    $ngayBD = $ngayBD ? Yii::$app->formatter->asDate($ngayBD, 'php:d/m/Y') : null;
    $ngayKT = $ngayKT ? Yii::$app->formatter->asDate($ngayKT, 'php:d/m/Y') : null;

    // Kiểm tra trường hợp chỉ có một ngày
    if ($ngayBD === $ngayKT && $ngayBD !== null) {
        // Thêm 6 ngày vào ngayKT để đảm bảo có một tuần
        $date = DateTime::createFromFormat('d/m/Y', $ngayKT);
        $date->modify('+0 days');
        $ngayKT = $date->format('d/m/Y');
    }

    // Tạo danh sách tuần và tháng
    $weeks = $this->generateWeeks($ngayBD, $ngayKT);
    $months = $this->generateMonths($ngayBD, $ngayKT);

    // Xử lý hiển thị cho Ajax hoặc không phải Ajax
    if ($request->isAjax) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'title'=> "Giáo viên #".$id,
            'content'=>$this->renderAjax('view', [
                'model' => $this->findModel($id),
                'weeks'=>$weeks,
                'months'=>$months,
            ]),
            'footer'=> Html::button('Đóng lại', ['class'=>'btn btn-default pull-left', 'data-bs-dismiss'=>"modal"]) .
                      Html::a('Sửa', ['update', 'id' => $id], ['class'=>'btn btn-primary', 'role'=>'modal-remote'])
        ];    
    } else {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'weeks'=>$weeks,
            'months'=>$months,
        ]);
    }
}


    protected function generateWeeks($startDate, $endDate)
    {
        // Kiểm tra ngày bắt đầu và kết thúc
        if (!$startDate || !$endDate) {
            return []; // Trả về mảng rỗng nếu không có ngày hợp lệ
        }
    
        // Tạo đối tượng DateTime từ ngày bắt đầu và ngày kết thúc
        $start = DateTime::createFromFormat('d/m/Y', $startDate);
        $end = DateTime::createFromFormat('d/m/Y', $endDate);
    
        // Kiểm tra nếu không tạo được đối tượng DateTime
        if (!$start || !$end) {
            return []; // Trả về mảng rỗng nếu không tạo được đối tượng DateTime
        }
    
        // Điều chỉnh ngày về thứ Hai và Chủ Nhật gần nhất
        $start->modify('last monday');
        $end->modify('next sunday');
    
        $weeks = [];
        $weekNumber = 1;
    
        // Lặp qua các tuần và tạo danh sách tuần
        while ($start < $end) {
            $weekStart = clone $start;
            $weekEnd = (clone $start)->modify('+6 days');
    
            $weeks[$weekNumber] = sprintf(
                'Tuần %d [%s - %s]',
                $weekNumber,
                $weekStart->format('d/m/Y'),
                $weekEnd->format('d/m/Y')
            );
    
            $weekNumber++;
            $start->modify('+7 days');
        }
    
        return $weeks;
    }
    
    protected function generateMonths($startDate, $endDate)
    {
        // Kiểm tra ngày bắt đầu và kết thúc
        if (!$startDate || !$endDate) {
            return []; // Trả về mảng rỗng nếu không có ngày hợp lệ
        }
    
        // Tạo đối tượng DateTime từ ngày bắt đầu và ngày kết thúc
        $start = DateTime::createFromFormat('d/m/Y', $startDate);
        $end = DateTime::createFromFormat('d/m/Y', $endDate);
    
        // Kiểm tra nếu không tạo được đối tượng DateTime
        if (!$start || !$end) {
            return []; // Trả về mảng rỗng nếu không tạo được đối tượng DateTime
        }
    
        // Điều chỉnh ngày về thứ Hai và Chủ Nhật gần nhất
        $start->modify('last monday');
        $end->modify('next sunday');
    
        $weeksByMonth = [];
        $weekNumber = 1; // Số tuần liên tiếp trên toàn bộ khoảng thời gian
    
        // Lặp qua các tuần và nhóm theo tháng
        while ($start < $end) {
            $weekStart = clone $start;
            $weekEnd = (clone $start)->modify('+6 days');
            $monthLabel = 'Tháng ' . $weekStart->format('n/Y');
    
            if (!isset($weeksByMonth[$monthLabel])) {
                $weeksByMonth[$monthLabel] = [];
            }
    
            $weeksByMonth[$monthLabel][] = sprintf(
                'Tuần %d [%s - %s]',
                $weekNumber,
                $weekStart->format('d/m/Y'),
                $weekEnd->format('d/m/Y')
            );
    
            $weekNumber++; // Tăng tuần liên tục
            $start->modify('+7 days');
        }
    
        return $weeksByMonth;
    }
    
    



    /**
     * Creates a new NhanVien model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new GiaoVien();

        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Thêm Giáo viên",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                       
                    ]),
                    'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                                Html::button('Lưu lại', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "Thêm Giáo Viên",
                    'content' => '<span class="text-success">Thêm Giáo viên thành công !</span>',
                    'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                                Html::a('Tiếp tục thêm', ['create'], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => "Thêm Giáo viên",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                        
                    ]),
                    'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"]) .
                                Html::button('Lưu lại', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            }
        } else {
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                   
                ]);
            }
        }
    }
    

    /**
     * Updates an existing NhanVien model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
    $request = Yii::$app->request;
    $model = $this->findModel($id);       
    if($request->isAjax){
        /*
        *   Process for ajax request
        */
        Yii::$app->response->format = Response::FORMAT_JSON;
        if($request->isGet){
            return [
                'title'=> "Cập nhật Giáo viên #".$id,
                'content'=>$this->renderAjax('update', [
                    'model' => $model,
                ]),
                'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::button('Sửa',['class'=>'btn btn-primary','type'=>"submit"])
            ];         
        }else if ($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Giáo viên #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                               Html::a('Sửa',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{
             return [
                'title'=> "Cập nhật Giáo viên #".$id,
                'content'=>$this->renderAjax('update', [
                    'model' => $model,
                ]),
                'footer'=> Html::button('Đóng lại ',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                           Html::button('Lưu lại ',['class'=>'btn btn-primary','type'=>"submit"])
            ];        
        }
    }else{
        /*
        *   Process for non-ajax request
        */
        if ($model->load($request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    }


    /**
     * Delete an existing NhanVien model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
    }
     /**
     * Delete multiple existing NhanVien model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkdelete()
    {        
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' )); 
        foreach ( $pks as $pk ) {
            $model = $this->findModel($pk);
            $model->delete();
        }

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
       
    }

    /**
     * Finds the NhanVien model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return NhanVien the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GiaoVien::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionGetToList($id_phong_ban)
    {
        $tos = To::find()->where(['id_phong_ban' => $id_phong_ban])->all();
        if (empty($tos)) {
            return json_encode(['no_to' => 'Trống']);
        }
        $listTo = ArrayHelper::map($tos, 'id', 'ten_to');
        return json_encode($listTo);
    }

    public function actionLoadScheduleWeek($week_string, $idGV)
{
    if (preg_match('/Tuần \d+ \[(\d{2}\/\d{2}\/\d{4}) - (\d{2}\/\d{2}\/\d{4})\]/', $week_string, $matches)) {
        $dayBD = \DateTime::createFromFormat('d/m/Y', $matches[1])->format('Y-m-d');
        $dayKT = \DateTime::createFromFormat('d/m/Y', $matches[2])->format('Y-m-d');
                $data = LichHoc::find()
                ->where(['between', 'ngay', $dayBD, $dayKT])
                ->andwhere(['id_giao_vien' => $idGV])->all();
        return $this->renderPartial('_schedule_table', [
            'data' => $data,
        ]);
    }
    throw new BadRequestHttpException('Chuỗi tuần không hợp lệ.');
}


public function actionInsertPhongBan()
{
    $request = Yii::$app->request;
    $model = new PhongBan();  
    $modelGV = new GiaoVien();
    if($request->isAjax){
        /*
        *   Process for ajax request
        */
        Yii::$app->response->format = Response::FORMAT_JSON;
        if($request->isGet){
            return [
                'title'=> "Thêm phòng ban",
                'content'=>$this->renderAjax('create_PB', [
                    'model' => $model,
                ]),
                'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
    
            ];         
        }else if($model->load($request->post()) && $model->save()){
            return [
                'forceClose'=>true,   
                 'reloadType'=>'phongBan',
                 'reloadBlock'=>'#pbContent',
                 'reloadContent'=>$this->renderAjax('_form', [
                     'model' => $modelGV,
                     
                 ]),
                 
                 'tcontent'=>'Thêm phòng ban thành công !',
             ];         
        }
    }else{
        /*
        *   Process for non-ajax request
        */
        if ($model->load($request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
   
}

public function actionInsertTo()
    {
        $request = Yii::$app->request;
        $model = new To();  
        $modelGV = new GiaoVien();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Thêm tổ",
                    'content'=>$this->renderAjax('create_To', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceClose'=>true,   
                     'reloadType'=>'to',
                     'reloadBlock'=>'#pbContent',
                     'reloadContent'=>$this->renderAjax('_form', [
                         'model' => $modelGV,
                     ]),
                     
                     'tcontent'=>'Thêm tổ thành công !',
                 ];        
            }else{           
                return [
                    'title'=> "Thêm tổ",
                    'content'=>$this->renderAjax('create_To', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create_To', [
                    'model' => $model,
                ]);
            }
        }
       
    }
}
