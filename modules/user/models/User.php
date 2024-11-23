<?php
namespace app\modules\user\models;

use yii\helpers\ArrayHelper;
use PhpParser\Node\Stmt\Expression;

class User extends UserBase{
    
    /**
     * lay danh sach tai khoan chua duoc lien ket voi nhan vien
     * @param string $tenMacDinh
     * @return array
     */
    public function getListUnused($tenMacDinh=NULL){
        
       
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
    
}