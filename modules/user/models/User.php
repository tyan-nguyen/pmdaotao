<?php
namespace app\modules\user\models;

use Yii;
use yii\helpers\ArrayHelper;
use app\modules\hocvien\models\HocVien;
use yii\db\Expression;

class User extends UserBase{
    
    /**
     * lay danh sach tai khoan chua duoc lien ket voi nhan vien
     * @param string $tenMacDinh
     * @return array
     */
    public function getListUnused($tenMacDinh=NULL){
        
       
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
    
    /**
     * get list nợ của nhân viên tiếp nhận hồ sơ (tất cả thời gian hoặc đến mốc thời gian)
     * $nhanvienid: kieu int, id cua user tiep nhan ho so
     * $endtime: Y-m-d H:i:s
     */
    public static function getNoConLaiCuaNhanVien($nhanvienid, $endtime=NULL){
        if($endtime==NULL){
            $listHvPhuTrach = HocVien::find()
                ->where(['nguoi_tao'=>$nhanvienid])
                ->andWhere("huy_ho_so = 0 OR thoi_gian_huy_ho_so <= '".$endtime . "'")
                ->all();
        } else {
            $listHvPhuTrach = HocVien::find()
                ->where(['nguoi_tao'=>$nhanvienid])
                /* ->andFilterWhere(['<=', 'thoi_gian_tao', new Expression("STR_TO_DATE('".$endtime."','%Y-%m-%d %H:%i:%s')")]) */
				//->andFilterWhere(['<=', 'thoi_gian_tao', $endtime])
				->andWhere("thoi_gian_tao <= '".$endtime . "'")
				->andWhere("huy_ho_so = 0 OR (huy_ho_so = 1 AND thoi_gian_huy_ho_so >= '".$endtime . "')")
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
            ->andWhere("huy_ho_so = 0 OR thoi_gian_huy_ho_so <= '".$endtime . "'")
            ->all();
        }else {
            $listHvPhuTrach = HocVien::find()
                /* ->andFilterWhere(['<=', 'thoi_gian_tao', new Expression("STR_TO_DATE('".$endtime."','%Y-%m-%d %H:%i:%s')")]) */
                /*->andFilterWhere(['<=', 'thoi_gian_tao', $endtime])*/
				->where("thoi_gian_tao <= '".$endtime . "'")
				->andWhere("huy_ho_so = 0 OR (huy_ho_so = 1 AND thoi_gian_huy_ho_so >= '".$endtime . "')")
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