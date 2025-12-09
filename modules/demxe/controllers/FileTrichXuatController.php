<?php

namespace app\modules\demxe\controllers;

use Yii;
use app\modules\demxe\models\FileTrichXuat;
use app\modules\demxe\models\search\FileTrichXuatSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\filters\AccessControl;
use PhpOffice\PhpSpreadsheet\IOFactory;
use app\custom\CustomFunc;
use app\modules\demxe\models\FileTrichXuatContent;
use app\modules\demxe\models\DemXe;
use app\modules\thuexe\models\Xe;

/**
 * FileTrichXuatController implements the CRUD actions for FileTrichXuat model.
 */
class FileTrichXuatController extends Controller
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
     * Lists all FileTrichXuat models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new FileTrichXuatSearch();
  		if(isset($_POST['search']) && $_POST['search'] != null){
            $dataProvider = $searchModel->search(Yii::$app->request->post(), $_POST['search']);
        } else if ($searchModel->load(Yii::$app->request->post())) {
            $searchModel = new FileTrichXuatSearch(); // "reset"
            $dataProvider = $searchModel->search(Yii::$app->request->post());
        } else {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        }    
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * Readfile & import content file to db (file_trich_xuat_content).
     * @param integer $id
     * @return mixed
     */
    public function actionReadFile($id)
    {
        $model = FileTrichXuat::findOne($id);
        $filePath = Yii::getAlias('@webroot') . '/uploads/dem-xe/' . $model->url;
        // Đọc file Excel
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();
        
        //Xử lý lấy phần thời gian từ - đến lưu vào csdl file
        //echo $rows[0][0];
        
        $request = Yii::$app->request;
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        $textFirstRow = $rows[0][0];
        $tuNgay = '';
        $denNgay = '';
        if (stripos($rows[0][0], 'Từ ngày') !== false) {
            //từ ngày - đến ngày
            $text = $sheet->getCell('A1')->getValue();
            $matches = '';
            // Regex để lấy ngày
            preg_match('/Từ ngày (.*?) đến (.*)/', $text, $matches);            
            $fromDate = trim($matches[1] ?? '');
            $toDate   = trim($matches[2] ?? '');
            
            $fromDate = CustomFunc::convertDMYHISToYMDHIS($fromDate);
            $toDate = CustomFunc::convertDMYHISToYMDHIS($toDate);
            
        } else{
            //chỉ trong ngày
            //từ ngày - đến ngày
            $text = $sheet->getCell('A1')->getValue();
            $matches = '';
            // Regex để lấy ngày
            preg_match('/Ngày (.*?) từ (.*) đến (.*)/', $text, $matches);            
            $fromDate = trim( ($matches[1].' '.$matches[2]) ?? '');
            $toDate   = trim( ($matches[1].' '.$matches[3]) ?? '');
            
            $fromDate = CustomFunc::convertDMYHISToYMDHIS($fromDate);
            $toDate = CustomFunc::convertDMYHISToYMDHIS($toDate);
        }
        
        $model->thoi_gian_tu = $fromDate;
        $model->thoi_gian_den = $toDate;
        if($model->save()){
            unset($rows[0]);
            unset($rows[1]);
            foreach($rows as $row) {
                $modelData = new FileTrichXuatContent();
                $modelData->id_file = $model->id;
                $congId = array_search($row[1], DemXe::getDmCongFromCamera());
                $modelData->camera = $congId;
                $maXe = str_replace('-', '', $row[3]);
                $maXe = str_replace('.', '', $maXe);
                $maXe = str_replace(' ', '', $maXe);
                $modelData->ma_xe = strtoupper($maXe);//chuyển sang viết hoa các ký tự ABC
                $modelData->bien_so_xe = $row[3];
                $modelData->thoi_gian = CustomFunc::convertDMYHISToYMDHIS($row[6]);
                $modelData->save(false); // save không validate hoặc dùng validate tùy bạn
            }
        }
        
        return [
            'title'=> "File trích xuất",
            'content'=>"Đã đọc nội dung file từ: " . $fromDate . ' - ' . $toDate,
            'forceReload'=>'#crud-datatable-pjax',
            'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"])
        ];
        
    }
    
    /**
     * Readfile & import content file to db (file_trich_xuat_content).
     * @param integer $id
     * @return mixed
     */
    public function actionImportFile($id)
    {
        $model = FileTrichXuat::findOne($id);
        $filePath = Yii::getAlias('@webroot') . '/uploads/dem-xe/' . $model->url;
        
        $sLuongThanhCong = 0;
        $sLuongLoi = 0;
        $tinNhanLoi = '';
        $fileContent = FileTrichXuatContent::find()->where(['id_file'=>$id])
            ->orderBy(['thoi_gian'=>SORT_ASC])->all();
        $fileContentCount = FileTrichXuatContent::find()->where(['id_file'=>$id])->count();
        foreach ($fileContent as $iCt=>$ct){
            $xe = Xe::find()->where(['ma_bien_so'=>$ct->ma_xe])->one();
            if($xe){//**xe nhà
                //**nếu là cổng start thì tạo mới luôn
                if (in_array($ct->camera, DemXe::getDmCongStartXeNha(), true)) {
                    $demXe = new DemXe();
                    $demXe->ma_xe = $ct->ma_xe;
                    $demXe->bien_so_xe = $ct->bien_so_xe;
                    $demXe->ma_cong = DemXe::getCongThuocTram($ct->camera);
                    $demXe->id_xe = $xe->id;
      
                    $demXe->thoi_gian_bd = $ct->thoi_gian;
                    $demXe->thoi_gian_kt = '';
                    $demXe->so_gio = 0;
                    $demXe->so_phut = '';
                    $demXe->id_file = $ct->id_file;
                    $demXe->ghi_chu = '';
                    if($demXe->save()){
                        $sLuongThanhCong ++;
                    }
                } else if (in_array($ct->camera, DemXe::getDmCongEndXeNha(), true)) {
                    //trường hợp có xe ra gần nhất, thì edit thời gian về
                     $demXe = DemXe::find()->where(['ma_xe'=>$ct->ma_xe])->orderBy('id DESC')->one();
                     if($demXe!=null && $demXe->thoi_gian_kt == ''){
                         $demXe->thoi_gian_kt = $ct->thoi_gian;
                         $demXe->so_gio = CustomFunc::diffHours($demXe->thoi_gian_bd, $demXe->thoi_gian_kt);
                         $demXe->so_phut = CustomFunc::diffHoursMinutes($demXe->thoi_gian_bd, $demXe->thoi_gian_kt);
                         if($demXe->save()){
                             $sLuongThanhCong ++;
                         }
                     }else if(($demXe!=null && $demXe->thoi_gian_kt != null) || $demXe==null){
                         $sLuongLoi++;
                         $tinNhanLoi .= 'Xe nhà ' . $ct->ma_xe . ' - ' . $ct->thoi_gian . ' có đi vào nhưng không có dữ liệu đi.<br/>';
                         $demXe = new DemXe();
                         $demXe->ma_xe = $ct->ma_xe;
                         $demXe->bien_so_xe = $ct->bien_so_xe;
                         $demXe->ma_cong = DemXe::getCongThuocTram($ct->camera);
                         $demXe->id_xe = $xe->id;
                         
                         //$demXe->thoi_gian_bd = $ct->thoi_gian;
                         $demXe->thoi_gian_kt = $ct->thoi_gian;
                         $demXe->so_gio = 0;
                         $demXe->so_phut = '';
                         $demXe->id_file = $ct->id_file;
                         $demXe->ghi_chu = '';
                         if($demXe->save()){
                             //$sLuongThanhCong ++;
                         }
                     }
                }
            } else {//**xe la
                //**nếu là cổng end thì tạo mới luôn
                if (in_array($ct->camera, DemXe::getDmCongStartXeLa(), true)) {
                    $demXe = new DemXe();
                    $demXe->ma_xe = $ct->ma_xe;
                    $demXe->bien_so_xe = $ct->bien_so_xe;
                    $demXe->ma_cong = DemXe::getCongThuocTram($ct->camera);
                    //$demXe->id_xe = $xe->id;
                    
                    $demXe->thoi_gian_bd = $ct->thoi_gian;
                    $demXe->thoi_gian_kt = '';
                    $demXe->so_gio = 0;
                    $demXe->so_phut = '';
                    $demXe->id_file = $ct->id_file;
                    $demXe->ghi_chu = '';
                    if($demXe->save()){
                        $sLuongThanhCong ++;
                    }
                } else if (in_array($ct->camera, DemXe::getDmCongEndXeLa(), true)) {
                    //trường hợp có xe ra gần nhất, thì edit thời gian về
                    $demXe = DemXe::find()->where(['ma_xe'=>$ct->ma_xe])->orderBy('id DESC')->one();
                    if($demXe!=null && $demXe->thoi_gian_kt == ''){
                        $demXe->thoi_gian_kt = $ct->thoi_gian;
                        $demXe->so_gio = CustomFunc::diffHours($demXe->thoi_gian_bd, $demXe->thoi_gian_kt);
                        $demXe->so_phut = CustomFunc::diffHoursMinutes($demXe->thoi_gian_bd, $demXe->thoi_gian_kt);
                        if($demXe->save()){
                            $sLuongThanhCong ++;
                        }
                    }else if(($demXe!=null && $demXe->thoi_gian_kt != null) || $demXe==null){
                        $sLuongLoi++;
                        $tinNhanLoi .= 'Xe lạ ' . $ct->ma_xe . ' - ' . $ct->thoi_gian . ' có đi vào nhưng không có dữ liệu đi.<br/>';
                        $demXe = new DemXe();
                        $demXe->ma_xe = $ct->ma_xe;
                        $demXe->bien_so_xe = $ct->bien_so_xe;
                        $demXe->ma_cong = DemXe::getCongThuocTram($ct->camera);
                        //$demXe->id_xe = $xe->id;
                        
                        //$demXe->thoi_gian_bd = $ct->thoi_gian;
                        $demXe->thoi_gian_kt = $ct->thoi_gian;
                        $demXe->so_gio = 0;
                        $demXe->so_phut = '';
                        $demXe->id_file = $ct->id_file;
                        $demXe->ghi_chu = '';
                        if($demXe->save()){
                            //$sLuongThanhCong ++;
                        }
                    }
                }
            }
        }
        
        $request = Yii::$app->request;
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        return [
            'title'=> "File trích xuất",
            'content'=>"Đã import: " . $sLuongThanhCong . '/' . $fileContentCount.
                '<br/> Lỗi: ' . $sLuongLoi.
                '<br/> Thông báo lỗi: ' . $tinNhanLoi
                ,
            'forceReload'=>'#crud-datatable-pjax',
            'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"])
        ];
    }

    /**
     * Displays a single FileTrichXuat model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "FileTrichXuat",
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

    /**
     * Creates a new FileTrichXuat model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new FileTrichXuat();  

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Thêm mới FileTrichXuat",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Thêm mới FileTrichXuat",
                    'content'=>'<span class="text-success">Thêm mới thành công</span>',
                    'tcontent'=>'Thêm mới thành công!',
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::a('Tiếp tục thêm',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> "Thêm mới FileTrichXuat",
                    'content'=>$this->renderAjax('create', [
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
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
       
    }

    /**
     * Updates an existing FileTrichXuat model.
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
                    'title'=> "Cập nhật FileTrichXuat",
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
            	if(Yii::$app->params['showView']){
                    return [
                        'forceReload'=>'#crud-datatable-pjax',
                        'title'=> "FileTrichXuat",
                        'content'=>$this->renderAjax('view', [
                            'model' => $model,
                        ]),
                        'tcontent'=>'Cập nhật thành công!',
                        'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::a('Sửa',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                    ];    
                }else{
                	return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax','tcontent'=>'Cập nhật thành công!',];
                }
            }else{
                 return [
                    'title'=> "Cập nhật FileTrichXuat",
                    'content'=>$this->renderAjax('update', [
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
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing FileTrichXuat model.
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
     * Delete multiple existing FileTrichXuat model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkdelete()
    {        
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
        $delOk = true;
        $fList = array();
        foreach ( $pks as $pk ) {
            $model = $this->findModel($pk);
            try{
            	$model->delete();
            }catch(\Exception $e) {
            	$delOk = false;
            	$fList[] = $model->id;
            }
        }

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax',
            			'tcontent'=>$delOk==true?'Xóa thành công!':('Không thể xóa:'.implode('</br>', $fList)),
            ];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
       
    }

    /**
     * Finds the FileTrichXuat model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FileTrichXuat the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FileTrichXuat::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
