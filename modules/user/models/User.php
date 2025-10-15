<?php
namespace app\modules\user\models;

use Yii;
use yii\helpers\ArrayHelper;
use app\modules\hocvien\models\HocVien;
use yii\db\Expression;
use app\modules\giaovien\models\GiaoVien;

class User extends UserBase{
    /**
     * get list nhan vien
     */
    public static function getListUsers(){
        $users = User::find()->where(['user_type'=>User::USER_TYPE_NHANHOSO])->all();
        return ArrayHelper::map($users, 'id', function($model) {
            return $model->ho_ten . ' (' . $model->username . ')';
        });
    }
    /**
     * get list tai khoan duyet ke hoach giao vien
     */
    public static function getListUserDuyetKeHoach(){
        $users = User::find()->where('id IN (19,7,4)')->orderBy(['id'=>SORT_DESC])->all();
        return ArrayHelper::map($users, 'id', function($model) {
            return $model->ho_ten . ' (' . $model->username . ')';
        });
    }
    /**
     * lay danh sach tai khoan chua duoc lien ket voi nhan vien
     * @param string $tenMacDinh
     * @return array
     */
    public function getListUnused($tenMacDinh=NULL){
        
       
    }
    /**
     * lay ho ten cua user by id_user
     * @param id of user $id
     * @return string
     */
    public static function getHoTenByID($id){
        $model = User::findOne($id);
        if($model)
            return $model->ho_ten;
            else
                return '';
    }
    /**
     * get id giao vien neu tai khoan la giao vien
     * @return int
     */
    public function getIdGiaoVien(){
        $giaoVien = GiaoVien::find()->where(['tai_khoan'=>Yii::$app->user->id])->one();
        if($giaoVien != null){
            return $giaoVien->id;
        } else {
            return null;
        }
    }
    
    public function getHoTen(){
        return $this->ho_ten?$this->ho_ten:$this->username;
    }
    /**
     * lay nhan vien co lien ket voi tai khoan
     * @return \yii\db\ActiveRecord|array|NULL
     */
    public function getNhanVien(){
        return 'test';
    }
    
    /**
     * hien thi ten nhan vien duoc lien ket voi tai khoan
     * @return string
     */
    public function getTenNhanVien(){
        return 'test';
    }
    
    /**
     * lay id nhan vien duoc lien ket voi tai khoan
     * @return string
     */
    public function getIdNhanVien(){
        return 'test';
    }
    
    /**
     * lay id bo phan duoc lien ket voi tai khoan
     * @return string
     */
    public function getIdBoPhan(){
        return 'test';
    }
    
    /**
     * hien thi chuc vu nhan vien duoc lien ket voi tai khoan
     * @return string
     */
    public function getChucVu(){
        return 'test';
    }
    
    /**
     * hien thi link den bang nhan vien
     * @return string
     */
    public function getShowLinkNhanVien(){
        return 'test';
    }

    public static function getList()
    {
        // Lấy danh sách nhân viên  và sắp xếp theo thứ tự bảng chữ cái
        $dsUser = User::find()
            ->orderBy(['username' => SORT_ASC])
            ->all();
    
        // Thêm dấu + vào trước tên nhân viên
        return ArrayHelper::map($dsUser, 'id', function($model) {
            return '+ ' . $model->username; // Thêm dấu + trước tên nhân viên
        });
    }
    
    public static function getListNvNhanHoSo()
    {
        // Lấy danh sách nhân viên  và sắp xếp theo thứ tự bảng chữ cái
        $dsUser = User::find()
            ->andFilterWhere(['user_type'=>self::USER_TYPE_NHANHOSO])
            ->orderBy(['username' => SORT_ASC])
            ->all();
        
        // Thêm dấu + vào trước tên nhân viên
        return ArrayHelper::map($dsUser, 'id', function($model) {
            return '+ ' . $model->ho_ten . ' (' . $model->username . ')' 
                . ($model->status==self::STATUS_INACTIVE?(' >>> KHÓA'):'') ; // Thêm dấu + trước tên nhân viên
        });
    }
    
    /**
     * get list nợ của nhân viên tiếp nhận hồ sơ (tất cả thời gian hoặc đến mốc thời gian)
     * $nhanvienid: kieu int, id cua user tiep nhan ho so
     * $endtime: Y-m-d H:i:s
     */
    public static function getNoConLaiCuaNhanVien($nhanvienid, $endtime=NULL){
        if($endtime==NULL){
            $listHvPhuTrach = HocVien::find()
                ->where(['nguoi_tao'=>$nhanvienid])
                ->andWhere("huy_ho_so = 0")
                ->andWhere("da_nop_du = 0")
                ->all();
        } else {
            $listHvPhuTrach = HocVien::find()
                ->where(['nguoi_tao'=>$nhanvienid])
                /* ->andFilterWhere(['<=', 'thoi_gian_tao', new Expression("STR_TO_DATE('".$endtime."','%Y-%m-%d %H:%i:%s')")]) */
				//->andFilterWhere(['<=', 'thoi_gian_tao', $endtime])
				->andWhere("thoi_gian_tao <= '".$endtime . "'")
				->andWhere("da_nop_du = 0")
				->andWhere("huy_ho_so = 0 OR (huy_ho_so = 1 AND thoi_gian_huy_ho_so > '".$endtime . "')")
                ->all();
        }
        ///////////////////////
        //$listHvPhuTrach = HocVien::find()->where(['nguoi_tao'=>$nhanvienid])->all();
        $tongConNo = 0;
        foreach ($listHvPhuTrach as $indexHvPhuTrach=>$hv){
            $tongConNo += $hv->getTienChuaThanhToanByEndTime($endtime);
        }
        return $tongConNo;
    }
    
    /**
     * get tổng nợ còn lại của tất cả học viên (tất cả thời gian hoặc đến mốc thời gian)
     */
    public static function getNoConLaiCuaTatCaHocVien($endtime=NULL){
        if($endtime==NULL){
            $listHvPhuTrach = HocVien::find()
            ->andWhere("huy_ho_so = 0")
            ->andWhere("da_nop_du = 0")
            ->all();
        }else {
            $listHvPhuTrach = HocVien::find()
                /* ->andFilterWhere(['<=', 'thoi_gian_tao', new Expression("STR_TO_DATE('".$endtime."','%Y-%m-%d %H:%i:%s')")]) */
                /*->andFilterWhere(['<=', 'thoi_gian_tao', $endtime])*/
				->where("thoi_gian_tao <= '".$endtime . "'")
				->andWhere("da_nop_du = 0")
				->andWhere("huy_ho_so = 0 OR (huy_ho_so = 1 AND thoi_gian_huy_ho_so > '".$endtime . "')")
                ->all();
        }
        //////////////////////////
        //$listHvPhuTrach = HocVien::find()->all();
        $tongConNo = 0;
        foreach ($listHvPhuTrach as $indexHvPhuTrach=>$hv){
            $tongConNo += $hv->getTienChuaThanhToanByEndTime($endtime);
        }
        return $tongConNo;
    }
    
    /**
     * get list nợ của nhân viên tiếp nhận hồ sơ (tất cả thời gian hoặc đến mốc thời gian)
     * chỉ lấy học viên có trường da_nop_du = 0 ***
     * $nhanvienid: kieu int, id cua user tiep nhan ho so
     * $endtime: Y-m-d H:i:s
     */
    public static function getNoConLaiCuaNhanVien2($nhanvienid, $endtime=NULL){
        if($endtime==NULL){
            $listHvPhuTrach = HocVien::find()
            ->where(['nguoi_tao'=>$nhanvienid])
            ->andWhere("huy_ho_so = 0")
            ->andWhere("da_nop_du = 0")
            ->all();
        } else {
            $listHvPhuTrach = HocVien::find()
            ->where(['nguoi_tao'=>$nhanvienid])
            /* ->andFilterWhere(['<=', 'thoi_gian_tao', new Expression("STR_TO_DATE('".$endtime."','%Y-%m-%d %H:%i:%s')")]) */
            //->andFilterWhere(['<=', 'thoi_gian_tao', $endtime])
            ->andWhere("thoi_gian_tao <= '".$endtime . "'")
            ->andWhere("da_nop_du = 0")
            ->andWhere("huy_ho_so = 0 OR (huy_ho_so = 1 AND thoi_gian_huy_ho_so > '".$endtime . "')")
            ->all();
        }
        ///////////////////////
        //$listHvPhuTrach = HocVien::find()->where(['nguoi_tao'=>$nhanvienid])->all();
        $tongConNo = 0;
        foreach ($listHvPhuTrach as $indexHvPhuTrach=>$hv){
            $tongConNo += $hv->getTienChuaThanhToanByEndTime($endtime);
        }
        return $tongConNo;
    }
    
    /**
     * get tổng nợ còn lại của tất cả học viên (tất cả thời gian hoặc đến mốc thời gian)
     * chỉ lấy học viên có trường da_nop_du = 0 ***
     */
    public static function getNoConLaiCuaTatCaHocVien2($endtime=NULL){
        if($endtime==NULL){
            $listHvPhuTrach = HocVien::find()
            ->andWhere("huy_ho_so = 0")
            ->andWhere("da_nop_du = 0")
            ->all();
        }else {
            $listHvPhuTrach = HocVien::find()
            /* ->andFilterWhere(['<=', 'thoi_gian_tao', new Expression("STR_TO_DATE('".$endtime."','%Y-%m-%d %H:%i:%s')")]) */
            /*->andFilterWhere(['<=', 'thoi_gian_tao', $endtime])*/
            ->where("thoi_gian_tao <= '".$endtime . "'")
            ->andWhere("da_nop_du = 0")
            ->andWhere("huy_ho_so = 0 OR (huy_ho_so = 1 AND thoi_gian_huy_ho_so > '".$endtime . "')")
            ->all();
        }
        //////////////////////////
        //$listHvPhuTrach = HocVien::find()->all();
        $tongConNo = 0;
        foreach ($listHvPhuTrach as $indexHvPhuTrach=>$hv){
            $tongConNo += $hv->getTienChuaThanhToanByEndTime($endtime);
        }
        return $tongConNo;
    }
    
}