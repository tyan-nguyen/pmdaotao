<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\modules\hocvien\models\DangKyHv;
use app\modules\thuexe\models\Xe;
use app\modules\giaovien\models\GiaoVien;
use app\modules\user\models\User;
use app\modules\daotao\models\TietHoc;
use app\models\DmTinh;
use app\models\DmXa;

class FixController extends Controller
{
    //public $freeAccessActions = ['fix-ngay-ht-hs'];
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'ghost-access'=> [
                'class' => 'webvimark\modules\UserManagement\components\GhostAccessControl',
            ],
        ];
    }
    
    /**
     * fixed mã biển số xe
     */
    public function actionFixMaBienSo(){
        $listXes = Xe::find()->where('ma_bien_so IS NULL');
        echo $listXes->count();
        $countSuc = 0;
        $listXess = $listXes->all();
        foreach ($listXess as $iXe=>$xe){
            $maBienSo = '';
            if($xe->bien_so_xe != ''){
                $maBienSo = $xe->bien_so_xe;
                $maBienSo = str_replace('-', '', $maBienSo);
                $maBienSo = str_replace('.', '', $maBienSo);
            }
            $xe->ma_bien_so = $maBienSo;
            if($xe->save()){
                $countSuc++;
            }
        }
        echo '<br/>Thành công: '. $countSuc;
    }
    
    /**
     * fixed ngày hoàn thành hồ sơ
     * dành cho dữ liệu cũ chưa có cột hoàn thành hồ sơ
     */
    public function actionFixNgayHtHs(){
        $hocViens = DangKyHv::find()->all();
        $sl = 0;
        foreach ($hocViens as $iHv=>$hocVien){
            if($hocVien->thoi_gian_hoan_thanh_ho_so == NULL){
                foreach ($hocVien->hvNopHocPhis as $inhp=>$nhp){
                    if($nhp->so_tien_con_lai <= $hocVien->tienHocPhi/2){
                        $hocVien->thoi_gian_hoan_thanh_ho_so = $nhp->thoi_gian_tao;
                        $hocVien->updateAttributes(['thoi_gian_hoan_thanh_ho_so']);
                        $sl++;
                        break;
                    }
                }
            }
        }
        echo 'Cập nhật ' .$sl .' dòng';
    }
    
    /**
     * import nhanh file excel danh sách xe
     */
    public function actionImportXe(){
        $fxls = Yii::getAlias('@webroot/xe.xlsx');
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($fxls);
        $xls_data = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        $sheet = $spreadsheet->getActiveSheet();
        $errorByRow = array();
        $errorByRow1 = array();
        $successCount = 0;
        $errorCount = 0;
        
        $startRow = 2;
        foreach ($xls_data as $index=>$row){
            if($index>=$startRow){
                $model = new Xe();
                $model->id_loai_xe = $row['B'];
                $model->phan_loai = $row['G'];
                $model->hieu_xe = $row['C'];
                $model->bien_so_xe = $row['F'];
                $model->tinh_trang_xe = 'BINHTHUONG';
                $model->trang_thai = 'Khả dụng';
                //$model->ghi_chu = '';
                $model->so_khung = $row['D'];
                $model->so_may = $row['E'];
               // $model->ngay_dang_kiem = null;
                $model->mau_sac = $row['I'];
                $model->la_xe_cu = $row['J'];
                //$model->so_tien = $row['K'];
                $model->so_tien = $sheet->getCell('K'.$index)->getValue();
                $model->nha_cung_cap = $row['L'];
                $model->so_hoa_don = $row['M'];
                $model->so_hop_dong = $row['N'];
                //$model->id_giao_vien = null;
                
                /* $model = new BoPhan();
                $model->ma_bo_phan = $row['B'];
                $model->ten_bo_phan = $row['C'];
                if($row['E']!=NULL){
                    $model->truc_thuoc = BoPhan::findOne(['ma_bo_phan'=>$row['E']])->id;
                }
                $model->la_dv_quan_ly = strtolower($row['F'])=='x'?1:0;
                $model->la_dv_su_dung = strtolower($row['G'])=='x'?1:0;
                $model->la_dv_bao_tri = strtolower($row['H'])=='x'?1:0;
                $model->la_dv_van_tai = strtolower($row['I'])=='x'?1:0;
                $model->la_dv_mua_hang = strtolower($row['J'])=='x'?1:0;
                $model->la_dv_quan_ly_kho = strtolower($row['K'])=='x'?1:0;
                $model->la_trung_tam_chi_phi = strtolower($row['L'])=='x'?1:0;
                */
                if($model->save()){
                    $successCount++;
                } else {
                    $errorCount++;
                    $errorByRow[$index] = 'Dòng '. $index . ' bị lỗi!';
                    $errorByRow1[$index] = $model->errors;
                }
            }
        }
        echo '<br/>successCount: ' .$successCount;
        echo '<br/>errorCount: ' .$errorCount;
        echo '<br/>errorByRow: ';
        print_r($errorByRow);    
        print_r($errorByRow1);    
    }
    
    /**
     * import nhanh file excel danh sách xe
     */
    public function actionImportGiaoVien(){
        $fxls = Yii::getAlias('@webroot/gv.xlsx');
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($fxls);
        $xls_data = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        $errorByRow = array();
        $errorByRow1 = array();
        $successCount = 0;
        $errorCount = 0;
        
        $userErrorCount = 0;
        $errorByRowUser = array();
        
        $startRow = 2;
        foreach ($xls_data as $index=>$row){
            if($index>=$startRow){               
                $model = new GiaoVien();
                $model->ho_ten = $row['B'];
                $model->dien_thoai = $row['C'];
                $model->ngay_sinh = $row['D'];
                $model->gioi_tinh = 1;
                $model->trang_thai = 'Đang làm việc';

                if($model->save()){
                    $successCount++;
                    $user = new User();
                    $user->username = $model->dien_thoai;
                    $user->password = '123456';
                    $user->status = 1;
                    $user->ho_ten = $model->ho_ten;
                    $user->user_type = User::USER_TYPE_GIAOVIEN;
                    $user->noi_dang_ky = null;
                    if($user->save()){
                        User::assignRole($user->id, 'nGiaoVien');
                        $model->refresh();
                        $model->tai_khoan = $user->id;
                        $model->save();
                    }else {
                        $userErrorCount++;
                        $errorByRowUser[$index] = $user->errors;
                    }
                } else {
                    $errorCount++;
                    $errorByRow[$index] = 'Dòng '. $index . ' bị lỗi!';
                    $errorByRow1[$index] = $model->errors;
                }
            }
        }
        echo '<br/>successCount: ' .$successCount;
        echo '<br/>errorCount: ' .$errorCount;
        echo '<br/>errorByRow: ';
        print_r($errorByRow);
        print_r($errorByRow1);
        echo '<br/>usererrorCount: ' .$userErrorCount;
        print_r($errorByRowUser);
    }
    
    /**
     * fixed tiết học không thuộc KH (các kế hoạch đã xóa)
     */
    public function actionXoaThungRacCuaKhgd(){
        /*************************************/
        $tietHocs = TietHoc::find()->where('id_ke_hoach NOT IN (SELECT id FROM gd_ke_hoach)')->count();
        echo $tietHocs;
       /* $tietHocs = TietHoc::find()->where('id_ke_hoach NOT IN (SELECT id FROM gd_ke_hoach)')->all();
        foreach ($tietHocs as $th){
            $th->delete();
        } */
    }
    
    /**
     * import file dm tỉnh
     */
    public function actionImportTinh(){
        $fxls = Yii::getAlias('@webroot/import_tinh.xlsx');
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($fxls);
        $xls_data = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        $sheet = $spreadsheet->getActiveSheet();
        $errorByRow = array();
        $errorByRow1 = array();
        $successCount = 0;
        $errorCount = 0;
        
        $startRow = 2;
        foreach ($xls_data as $index=>$row){
            if($index>=$startRow){
                $model = new DmTinh();
                $model->ma_tinh = $row['B'];
                $model->loai = $row['C'];
                $model->ten_tinh = $row['D'];
                $model->ten_tinh_full = $row['C'] . ' ' . $row['D'];
                $model->ghi_chu = '';
                $model->stt = $row['E'];
                
                if($model->save()){
                    $successCount++;
                } else {
                    $errorCount++;
                    $errorByRow[$index] = 'Dòng '. $index . ' bị lỗi!';
                    $errorByRow1[$index] = $model->errors;
                }
            }
        }
        echo '<br/>successCount: ' .$successCount;
        echo '<br/>errorCount: ' .$errorCount;
        echo '<br/>errorByRow: ';
        print_r($errorByRow);
        print_r($errorByRow1);
    }
    
    /**
     * import file dm xã
     */
    public function actionImportXa(){
        $fxls = Yii::getAlias('@webroot/import_xa.xlsx');
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($fxls);
        $xls_data = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        $sheet = $spreadsheet->getActiveSheet();
        $errorByRow = array();
        $errorByRow1 = array();
        $successCount = 0;
        $errorCount = 0;
        
        $startRow = 2;
        foreach ($xls_data as $index=>$row){
            if($index>=$startRow){
                $model = new DmXa();

                $tinh = DmTinh::find()->where(['ma_tinh'=>$row['E']])->one();
                if($tinh){
                    $model->id_tinh = $tinh->id;
                }
                $model->ma_tinh = $row['E'];
                $model->ma_xa = $row['B'];
                $model->loai = $row['C'];
                $model->ten_xa = $row['D'];
                $model->ten_xa_full = $row['C'] . ' ' . $row['D'];
                $model->ghi_chu = '';
                if($row['E'] == 86)
                    $model->stt = 10;
                else 
                    $model->stt = 1;
                
                if($model->save()){
                    $successCount++;
                } else {
                    $errorCount++;
                    $errorByRow[$index] = 'Dòng '. $index . ' bị lỗi!';
                    $errorByRow1[$index] = $model->errors;
                }
            }
        }
        echo '<br/>successCount: ' .$successCount;
        echo '<br/>errorCount: ' .$errorCount;
        echo '<br/>errorByRow: ';
        print_r($errorByRow);
        print_r($errorByRow1);
    }
    
    
    
}