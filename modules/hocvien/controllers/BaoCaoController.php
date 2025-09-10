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

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use app\modules\user\models\User;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
/**
 * HocVienController implements the CRUD actions for HvHocVien model.
 */
class BaoCaoController extends Controller
{
    public $freeAccessActions = [
        'rp-danh-sach-dang-ky', 
        'rp-danh-sach-dang-ky-print', 
        'rp-bien-ban-ban-giao', 
        'rp-bien-ban-ban-giao-print',
        'rp-bien-ban-ban-giao-full-print',
        'rp-bien-ban-thay-doi-hang-print',
        'rp-bien-ban-huy-ho-so-print',
        'xuat-danh-sach-ca-excel',
    ];
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
    public function beforeAction($action)
    {
        Yii::$app->params['moduleID'] = 'Module Quản lý Học viên';
        Yii::$app->params['modelID'] = 'Đăng ký học';
        //return true;
        return parent::beforeAction($action);
    }
    
    /**
     * xuất excel
     */
    public function actionXuatDanhSachCaExcel($startdate, $starttime, $enddate, $endtime, $byuser, $typereport,$byaddress){
        if($byuser==null){
            $byuser = 0;
        }

        if($starttime == null)
            $starttime = '00:00:00';
        if($endtime == null)
            $endtime = '23:59:59';
        $start = CustomFunc::convertDMYToYMD($startdate) . ' ' . $starttime;
        $end = CustomFunc::convertDMYToYMD($enddate) . ' ' . $endtime;;

        $query = NopHocPhi::find()->alias('t')->joinWith(['hocVien as hv'])->select(['t.*', 'hv.noi_dang_ky'])
            ->andFilterWhere(['>=', 't.thoi_gian_tao', new Expression("STR_TO_DATE('".$start."','%Y-%m-%d %H:%i:%s')")])
            ->andFilterWhere(['<=', 't.thoi_gian_tao', new Expression("STR_TO_DATE('".$end."','%Y-%m-%d %H:%i:%s')")]);
        if($byuser>0){
            $query = $query->andFilterWhere(['t.nguoi_tao' => $byuser]);
        }
        if($byaddress>0){
            $query = $query->andFilterWhere(['hv.noi_dang_ky' => $byaddress]);
        }
        $model=$query->all();
        $modelCount=$query->count();
        $modelSoTienNop = $query->sum('t.so_tien_nop');
        
        $queryCK = NopHocPhi::find()->alias('t')->joinWith(['hocVien as hv'])->select(['t.*', 'hv.noi_dang_ky'])
        ->andFilterWhere(['>=', 't.thoi_gian_tao', new Expression("STR_TO_DATE('".$start."','%Y-%m-%d %H:%i:%s')")])
        ->andFilterWhere(['<=', 't.thoi_gian_tao', new Expression("STR_TO_DATE('".$end."','%Y-%m-%d %H:%i:%s')")]);
        if($byuser>0){
            $queryCK = $queryCK->andFilterWhere(['t.nguoi_tao' => $byuser]);
        }
        if($byaddress>0){
            $queryCK = $queryCK->andFilterWhere(['hv.noi_dang_ky' => $byaddress]);
        }
        $queryCK = $queryCK->andFilterWhere(['t.hinh_thuc_thanh_toan' => 'CK']);
        $modelSoTienNopCK = $queryCK->sum('t.so_tien_nop');
        
        $queryTM = NopHocPhi::find()->alias('t')->joinWith(['hocVien as hv'])->select(['t.*', 'hv.noi_dang_ky'])
        ->andFilterWhere(['>=', 't.thoi_gian_tao', new Expression("STR_TO_DATE('".$start."','%Y-%m-%d %H:%i:%s')")])
        ->andFilterWhere(['<=', 't.thoi_gian_tao', new Expression("STR_TO_DATE('".$end."','%Y-%m-%d %H:%i:%s')")]);
        if($byuser>0){
            $queryTM = $queryTM->andFilterWhere(['t.nguoi_tao' => $byuser]);
        }
        if($byaddress>0){
            $queryTM = $queryTM->andFilterWhere(['hv.noi_dang_ky' => $byaddress]);
        }
        $queryTM = $queryTM->andFilterWhere(['t.hinh_thuc_thanh_toan' => 'TM']);
        
        $modelSoTienNopTM = $queryTM->sum('t.so_tien_nop');
        
        $queryChietKhau = NopHocPhi::find()->alias('t')->joinWith(['hocVien as hv'])->select(['t.*', 'hv.noi_dang_ky'])
        ->andFilterWhere(['>=', 't.thoi_gian_tao', new Expression("STR_TO_DATE('".$start."','%Y-%m-%d %H:%i:%s')")])
        ->andFilterWhere(['<=', 't.thoi_gian_tao', new Expression("STR_TO_DATE('".$end."','%Y-%m-%d %H:%i:%s')")]);
        if($byuser>0){
            $queryChietKhau = $queryChietKhau->andFilterWhere(['t.nguoi_tao' => $byuser]);
        }
        if($byaddress>0){
            $queryChietKhau = $queryChietKhau->andFilterWhere(['hv.noi_dang_ky' => $byaddress]);
        }
        $modelSoTienChietKhau = $queryChietKhau->sum('t.chiet_khau');
        
        
        // Load file Excel mẫu
        $template = \Yii::getAlias('@app/templates/bb_theo_ca.xlsx');
        $spreadsheet = IOFactory::load($template);
        $sheet = $spreadsheet->getActiveSheet();
        $thoiGianLabel = 'Thời gian từ ' .CustomFunc::convertYMDHISToDMYHI($start). ' đến ' .CustomFunc::convertYMDHISToDMYHI($end);
        $thoiGianLabel .= ' - Nhân viên nhận hồ sơ: ' . ($byuser>0 ? User::findOne($byuser)->getHoTen() : 'Tất cả');
        $nhanVienBaoCaoLabel = 'Nhân viên lập báo cáo: ' . User::getCurrentUser()->getHoTen();
        //ghi dòng tổng nợ còn lại
        $tongNoLabel = 'TỔNG NỢ CÒN LẠI (tính đến ' . CustomFunc::convertYMDHISToDMYHI($end) . '): ';
        $tongNoLabel .= ($byuser && User::findOne($byuser)!=null) ? number_format(User::getNoConLaiCuaNhanVien($byuser,$end)) : number_format(User::getNoConLaiCuaTatCaHocVien($end));
        
        $sheet->setCellValue('A2', $thoiGianLabel);
        $sheet->setCellValue('A3', $nhanVienBaoCaoLabel);
        $sheet->setCellValue('A4', $tongNoLabel);
        
        // Ví dụ: ghi dữ liệu từ dòng 7
        $row = 7;
        $data = [];
        //set data
        foreach ($model as $indexCt => $item){
            $dataChild = array();
            
            $numHis = NopHocPhi::find()->where(['id_hoc_vien'=>$item->id_hoc_vien])
            ->andWhere('id < ' . $item->id)->orderBy(['id'=>SORT_ASC])->count();
            $itemHis = NopHocPhi::find()->where(['id_hoc_vien'=>$item->id_hoc_vien])
            ->andWhere('id < ' . $item->id)->orderBy(['id'=>SORT_ASC])->all();
            
            $dataChild[] = $indexCt+1;
            $dataChild[] = $item->ma_so_phieu==null ? '' : CustomFunc::fillNumber($item->ma_so_phieu);
            $dataChild[] = $item->hocVien?$item->hocVien->ho_ten:'';
            $dataChild[] = $item->hocVien?$item->hocVien->so_cccd:'';
            $dataChild[] = $item->hocVien?$item->hocVien->hang->ten_hang:'';
            $dataChild[] = $item->hocVien->khoaHoc?$item->hocVien->khoaHoc->ten_khoa_hoc:'';
            if($numHis == 0){
                $dataChild[] = '';
                $dataChild[] = '';
                $dataChild[] = '';
                $dataChild[] = '';
                $dataChild[] = '';
                $dataChild[] = '';
            }else {
                if($numHis == 1){
                    foreach ($itemHis as $indexHis=>$iHis){
                        
                        if($iHis->hinh_thuc_thanh_toan == 'TM'){
                            $dataChild[] = $iHis->so_tien_nop;
                            $dataChild[] = '';
                        } else if($iHis->hinh_thuc_thanh_toan == 'CK'){
                            $dataChild[] = '';
                            $dataChild[] = $iHis->so_tien_nop;
                        }
                        
                        if($iHis->chiet_khau > 0){
                            $dataChild[] = $iHis->chiet_khau;
                        } else {
                            $dataChild[] = '';
                        }
                        $dataChild[] = '';
                        $dataChild[] = '';
                        $dataChild[] = '';
                    }
                }else if($numHis == 2){
                    foreach ($itemHis as $indexHis=>$iHis){
                        if($iHis->hinh_thuc_thanh_toan == 'TM'){
                            $dataChild[] = $iHis->so_tien_nop;
                            $dataChild[] = '';
                        } else if($iHis->hinh_thuc_thanh_toan == 'CK'){
                            $dataChild[] = '';
                            $dataChild[] = $iHis->so_tien_nop;
                        }
                        
                        if($iHis->chiet_khau > 0){
                            $dataChild[] = $iHis->chiet_khau;
                        } else {
                            $dataChild[] = '';
                        }
                    }
                }else if($numHis == 3){
                    foreach ($itemHis as $indexHis=>$iHis){
                        if($indexHis==0){
                            continue;
                        }
                        if($iHis->hinh_thuc_thanh_toan == 'TM'){
                            $dataChild[] = $iHis->so_tien_nop;
                            $dataChild[] = '';
                        } else if($iHis->hinh_thuc_thanh_toan == 'CK'){
                            $dataChild[] = '';
                            $dataChild[] = $iHis->so_tien_nop;
                        }
                        
                        if($iHis->chiet_khau > 0){
                            $dataChild[] = $iHis->chiet_khau;
                        } else {
                            $dataChild[] = '';
                        }
                    }
                }else if($numHis == 4){
                    foreach ($itemHis as $indexHis=>$iHis){
                        if($indexHis==0 || $indexHis==1){
                            continue;
                        }
                        if($iHis->hinh_thuc_thanh_toan == 'TM'){
                            $dataChild[] = $iHis->so_tien_nop;
                            $dataChild[] = '';
                        } else if($iHis->hinh_thuc_thanh_toan == 'CK'){
                            $dataChild[] = '';
                            $dataChild[] = $iHis->so_tien_nop;
                        }
                        
                        if($iHis->chiet_khau > 0){
                            $dataChild[] = $iHis->chiet_khau;
                        } else {
                            $dataChild[] = '';
                        }
                    }
                }else if($numHis == 5){
                    foreach ($itemHis as $indexHis=>$iHis){
                        if($indexHis==0 || $indexHis==1 || $indexHis==2){
                            continue;
                        }
                        if($iHis->hinh_thuc_thanh_toan == 'TM'){
                            $dataChild[] = $iHis->so_tien_nop;
                            $dataChild[] = '';
                        } else if($iHis->hinh_thuc_thanh_toan == 'CK'){
                            $dataChild[] = '';
                            $dataChild[] = $iHis->so_tien_nop;
                        }
                        
                        if($iHis->chiet_khau > 0){
                            $dataChild[] = $iHis->chiet_khau;
                        } else {
                            $dataChild[] = '';
                        }
                    }
                }
        }
        
        $dataChild[] = $item->hinh_thuc_thanh_toan=='TM' ? $item->so_tien_nop : '';
        $dataChild[] = $item->hinh_thuc_thanh_toan=='CK' ? $item->so_tien_nop : '';
        $dataChild[] = $item->chiet_khau;
        $dataChild[] = $item->so_tien_con_lai;
        $dataChild[] = User::findOne($item->nguoi_tao)? User::findOne($item->nguoi_tao)->ho_ten : '';
        
        $data[] = $dataChild;
        
        }
        
        
        
        
        
        /* $data = [
            [1, '03494', 'Nguyễn Tấn Lộc', '084207005619', 'Hạng A1', 'Khóa 1','', '', '', '', '', '', 240000, 0, 0, 0, 'Trần Minh Thư'],
            [2, '03495', 'Nguyễn Vũ Gia Huy', '084207006928', 'Hạng A1', 'Khóa 21', '', '', '', '', '', '', 240000, 0, 0, 0, 'Trần Minh Thư'],
            [3, '03496', 'Lê Thanh Sang', '084093008582', 'Hạng A1', 'Khóa 1', '', '', '', '', '', '', 240000, 0, 0, 0, 'Trần Minh Thư'],
        ]; */
        
        foreach ($data as $rowData) {
            $col = 'A';
            foreach ($rowData as $value) {
                $sheet->setCellValue($col . $row, $value);
                $col++;
            }
            $row++;
        }
        //tính tổng dòng cuối $row
        $sheet->setCellValue('L'.$row, 'TỔNG');
        $sheet->setCellValue('M'.$row, '=SUM(M7:M'.($row-1).')');
        $sheet->setCellValue('N'.$row, '=SUM(N7:N'.($row-1).')');
        $sheet->setCellValue('O'.$row, '=SUM(O7:O'.($row-1).')');
        
        //sét numberformat
        //$sheet->getStyle('G7:P'.($row-1))
        $sheet->getStyle('G7:P'.$row)
            ->getNumberFormat()
            ->setFormatCode('#,##0');
       
        // Format dòng tổng thành in đậm
        $sheet->getStyle('A'.$row.':Q'.$row)->getFont()->setBold(true);
        
        // Kẻ border toàn bảng
        //$sheet->getStyle("A7:Q" . ($row-1))->applyFromArray([
        $sheet->getStyle("A7:Q" . $row)->applyFromArray([
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN]
            ]
        ]);
        
        // Auto size
        foreach (range('A','Q') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        // Dọn sạch output buffer
        if (ob_get_length()) {
            ob_end_clean();
        }
        
        // Gửi header thủ công để ép download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="bao_cao_thu_chi_hoc_phi.xlsx"');
        header('Cache-Control: max-age=0');
        header('Pragma: public');
        
        // Xuất file
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
            
        /* return $this->asJson([
            'status' => 'success',
            'content' => $content,
        ]); */
                
    }
    
    /**
     * in biên bản thay đổi hạng
     * @param unknown $idbb
     * @return \yii\web\Response
     */
    public function actionRpBienBanThayDoiHangPrint($idbb){
        $model = ThayDoiHocPhi::findOne($idbb);
        $content = $this->renderPartial('rp_bien_ban_ban_thay_doi_hang_print', [
           'model'=>$model
        ]);

        return $this->asJson([
            'status' => 'success',
            'content' => $content,
        ]);
    }
    /**
     * in biên bản hủy hồ sơ
     * @param unknown $idhv
     * @return \yii\web\Response
     */
    public function actionRpBienBanHuyHoSoPrint($idhv){
        $model = DangKyHv::findOne($idhv);
        $content = $this->renderPartial('rp_bien_ban_huy_ho_so_print', [
            'model'=>$model
        ]);
        
        return $this->asJson([
            'status' => 'success',
            'content' => $content,
        ]);
    }
    /**
     * in danh sách theo ca
     */
    public function actionRpDanhSachDangKy(){
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            
            return [
                'title' => "Báo cáo danh sách học viên",
                'content' => $this->renderAjax('rp_danh_sach_dang_ky', [
                    
                ]),
                'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"])
            ];
        }
    }
    
    public function actionRpDanhSachDangKyPrint($startdate, $starttime, $enddate, $endtime, $byuser=0, $byhocphi='all', $sortby='date', $byhangdaotao=NULL, $typereport=0,$byaddress=null)//0 for all
    {
        if($byuser==null){
            $byuser = 0;
        }
        $start = CustomFunc::convertDMYToYMD($startdate) . ' ' . $starttime;
        $end = CustomFunc::convertDMYToYMD($enddate) . ' ' . $endtime;;
        
        // $start = '2025-03-31 06:00:00';
        //$end = '2025-04-01 11:00:00';
        $query = HocVien::find()->alias('t');
        //if($byhocphi != 'all'){
        $query = $query->select(['t.*', '(SELECT SUM(i.so_tien_nop) FROM hv_nop_hoc_phi AS i WHERE t.id = i.id_hoc_vien) as tongtiennop']);
        //}        
        $query=$query->andFilterWhere(['>=', 't.thoi_gian_tao', new Expression("STR_TO_DATE('".$start."','%Y-%m-%d %H:%i:%s')")]);
        $query=$query->andFilterWhere(['<=', 't.thoi_gian_tao', new Expression("STR_TO_DATE('".$end."','%Y-%m-%d %H:%i:%s')")]);
        if($byuser>0){
            $query = $query->andFilterWhere(['t.nguoi_tao' => $byuser]);
        }
        if($byhocphi != 'all'){
            if($byhocphi=='danop'){
                $query=$query->andFilterWhere(['>', '(SELECT SUM(i.so_tien_nop) FROM hv_nop_hoc_phi AS i WHERE t.id = i.id_hoc_vien)', 2000000]);
            }else if($byhocphi=='coc'){
                $query=$query->andFilterWhere(['<=', '(SELECT SUM(i.so_tien_nop) FROM hv_nop_hoc_phi AS i WHERE t.id = i.id_hoc_vien)', 2000000]);
            }
        }
        
        if($byhangdaotao!=NULL){
            $query = $query->andFilterWhere(['t.id_hang' => $byhangdaotao]);
        }
        
        if($byaddress!=NULL){
           // $byaddress = strtoupper($byaddress);
            $query = $query->andFilterWhere(['t.noi_dang_ky' => $byaddress]);
        }
        
        $model=$query->all();
        $modelCount=$query->count();       
       
        
        if($typereport==0){
            $content = $this->renderPartial('rp_danh_sach_dang_ky_print', [
                'model' => $model,
                'start'=>$start,
                'end'=>$end,
                'modelCount'=>$modelCount,
                'byuser' => $byuser,
                'byhangdaotao' => $byhangdaotao,
                'byaddress' => $byaddress
            ]);
        }
        return $this->asJson([
            'status' => 'success',
            'content' => $content,
        ]);
        
    }
    
    /**
     * in danh sách theo ca
     */
    public function actionRpBienBanBanGiao(){
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            
            return [
                'title' => "Biên bản bàn giao hồ sơ học viên",
                'content' => $this->renderAjax('rp_bien_ban_ban_giao', [
                    
                ]),
                'footer' => Html::button('Đóng lại', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => "modal"])
            ];
        }
    }
    
    public function actionRpBienBanBanGiaoPrint($startdate, $starttime, $enddate, $endtime, $byuser=0, $sortby='ngay', $byhangdaotao=NULL, $typereport=0, $byaddress=NULL, $bykhoa=NULL)//0 for all
    {
        if($byuser==null){
            $byuser = 0;
        }
        $start = CustomFunc::convertDMYToYMD($startdate) . ' ' . $starttime;
        $end = CustomFunc::convertDMYToYMD($enddate) . ' ' . $endtime;;
        
        // $start = '2025-03-31 06:00:00';
        //$end = '2025-04-01 11:00:00';
        $query = HocVien::find()->alias('t');
        //if($byhocphi != 'all'){
        /* $query = $query->select(['t.*', '(SELECT SUM(i.so_tien_nop) FROM hv_nop_hoc_phi AS i WHERE t.id = i.id_hoc_vien) as tongtiennop']); */
        //}
        
        $query=$query->andFilterWhere(['>=', 't.thoi_gian_hoan_thanh_ho_so', new Expression("STR_TO_DATE('".$start."','%Y-%m-%d %H:%i:%s')")]);
        $query=$query->andFilterWhere(['<=', 't.thoi_gian_hoan_thanh_ho_so', new Expression("STR_TO_DATE('".$end."','%Y-%m-%d %H:%i:%s')")]);
        if($byuser>0){
            $query = $query->andFilterWhere(['t.nguoi_tao' => $byuser]);
        }
        
        if($byhangdaotao!=NULL){
            $query = $query->andFilterWhere(['t.id_hang' => $byhangdaotao]);
        }
        
        if($byaddress!=NULL){
            //$byaddress = strtoupper($byaddress);
            $query = $query->andFilterWhere(['t.noi_dang_ky' => $byaddress]);
        }
        if($bykhoa!=NULL){
            //$byaddress = strtoupper($byaddress);
            $query = $query->andFilterWhere(['t.id_khoa_hoc' => $bykhoa]);
        }
        
        $model=$query->all();
        $modelCount=$query->count();
        
        if($sortby==null)
            $sortby = 'ngay';
        if($sortby == 'hang'){
            $model=$query->orderBy(['t.id_hang'=>SORT_ASC, 't.thoi_gian_hoan_thanh_ho_so'=>SORT_ASC])->all();
        } else if($sortby == 'ngay'){
            $model=$query->orderBy(['t.thoi_gian_hoan_thanh_ho_so'=>SORT_ASC])->all();
        }        

       
        
        
        if($typereport==0){
            $content = $this->renderPartial('rp_bien_ban_ban_giao_print', [
                'model' => $model,
                'start'=>$start,
                'end'=>$end,
                'modelCount'=>$modelCount,
                'byuser' => $byuser,
                'byhangdaotao' => $byhangdaotao,
                'sortby'=>$sortby,
                'byaddress' => $byaddress,
                'bykhoa' =>$bykhoa
            ]);
        }
        return $this->asJson([
            'status' => 'success',
            'content' => $content,
        ]);
        
    }
    
    public function actionRpBienBanBanGiaoFullPrint($startdate, $starttime, $enddate, $endtime, $byuser=0, $sortby='ngay', $byhangdaotao=NULL, $typereport=0, $byaddress=NULL, $bykhoa=NULL)//0 for all
    {
        if($byuser==null){
            $byuser = 0;
        }
        $start = CustomFunc::convertDMYToYMD($startdate) . ' ' . $starttime;
        $end = CustomFunc::convertDMYToYMD($enddate) . ' ' . $endtime;        
     
        if($typereport==0){
            $content = $this->renderPartial('rp_bien_ban_ban_giao_full_print', [
                'start'=>$start,
                'end'=>$end,
                'byuser' => $byuser,
                'byhangdaotao' => $byhangdaotao,
                'sortby'=>$sortby,
                'byaddress' => $byaddress,
                'bykhoa' =>$bykhoa
            ]);
        }
        return $this->asJson([
            'status' => 'success',
            'content' => $content,
        ]);
            
    }
    
}
