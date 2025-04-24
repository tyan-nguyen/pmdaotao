<?php

use yii\db\Migration;
use webvimark\modules\UserManagement\models\rbacDB\Route;
use webvimark\modules\UserManagement\models\rbacDB\Permission;
/**
 * Class m240528_140354_insert_auth_item_child_data
 */
class m250329_000003_insert_auth_item_child_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    private $data=[
        //hoc vien
        [
            'name' => 'qXemDanhSachHocVienDangKy',
            'route' => '/hocvien/dang-ky-hv/index',
            
        ],
        [
            'name' => 'qXemHocVienDangKy',
            'route' => '/hocvien/dang-ky-hv/view',
            
        ],
        [
            'name' => 'qThemHocVienDangKy',
            'route' => '/hocvien/dang-ky-hv/create',
            
        ],
        [
            'name' => 'qSuaHocVienDangKy',
            'route' => '/hocvien/dang-ky-hv/update',
            
        ],
        [
            'name' => 'qXoaHocVienDangKy',
            'route' => '/hocvien/dang-ky-hv/delete',
            
        ],
        [
            'name' => 'qXoaHocVienDangKy',
            'route' => '/hocvien/dang-ky-hv/bulkdelete',
        ],
        [
            'name' => 'qThemDongHocPhiDangKy',
            'route' => '/hocvien/dang-ky-hv/create2',
            
        ],
       //hoc vien
        [
            'name' => 'qXemDanhSachHocVien',
            'route' => '/hocvien/hoc-vien/index',
            
        ],
        [
            'name' => 'qXemHocVien',
            'route' => '/hocvien/hoc-vien/view',
            
        ],
        [
            'name' => 'qThemHocVien',
            'route' => '/hocvien/hoc-vien/create',
            
        ],
        [
            'name' => 'qSuaHocVien',
            'route' => '/hocvien/hoc-vien/update',
            
        ],
        [
            'name' => 'qXoaHocVien',
            'route' => '/hocvien/hoc-vien/delete',
        ],
        [
            'name' => 'qXoaHocVien',
            'route' => '/hocvien/hoc-vien/bulkdelete',
            
        ],
        [
            'name' => 'qDongHocPhi',
            'route' => '/hocvien/hoc-vien/mess',
            
        ],
        [
            'name' => 'qDongHocPhi',
            'route' => '/hocvien/hoc-vien/mess2',
            
        ],
    ];
    public function safeUp()
    {
        //Route::refreshRoutes();
        //sleep(3);
        foreach ($this->data as $item) {
            Permission::addChildren($item['name'], $item['route'], $throwException = false);
        }
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        foreach ($this->data as $item) {
            Permission::removeChildren($item['name'], $item['route'], $throwException = false);
        }
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240528_140354_insert_auth_item_child_data cannot be reverted.\n";

        return false;
    }
    */
}
