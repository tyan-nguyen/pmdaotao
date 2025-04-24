<?php

use yii\db\Migration;
use webvimark\modules\UserManagement\models\rbacDB\Permission;

/**
 * Class m240528_132744_insert_auth_item_data
 */
class m250329_000002_insert_auth_item_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $data = [
            //hoc vien dang ky
            [
                'name' => 'qXemDanhSachHocVienDangKy',
                'type' => 2,
                'description' => 'Quyền xem danh sách học viên đăng ký',
                'created_at' => time(),
                'updated_at' => time(),
                'group_code' => 'quanLyHoSoDangKy',
            ],
            [
                'name' => 'qXemHocVienDangKy',
                'type' => 2,
                'description' => 'Quyền xem học viên đăng ký',
                'created_at' => time(),
                'updated_at' => time(),
                'group_code' => 'quanLyHoSoDangKy',
            ],
            [
                'name' => 'qThemHocVienDangKy',
                'type' => 2,
                'description' => 'Quyền thêm học viên đăng ký',
                'created_at' => time(),
                'updated_at' => time(),
                'group_code' => 'quanLyHoSoDangKy',
            ],
            [
                'name' => 'qSuaHocVienDangKy',
                'type' => 2,
                'description' => 'Quyền sửa học viên đăng ký',
                'created_at' => time(),
                'updated_at' => time(),
                'group_code' => 'quanLyHoSoDangKy',
            ],
            [
                'name' => 'qXoaHocVienDangKy',
                'type' => 2,
                'description' => 'Quyền xóa học viên đăng ký',
                'created_at' => time(),
                'updated_at' => time(),
                'group_code' => 'quanLyHoSoDangKy',
            ],
            [
                'name' => 'qThemDongHocPhiDangKy',
                'type' => 2,
                'description' => 'Quyền thêm đóng học phí',
                'created_at' => time(),
                'updated_at' => time(),
                'group_code' => 'quanLyHoSoDangKy',
            ],
            //hoc vien
            [
                'name' => 'qXemDanhSachHocVien',
                'type' => 2,
                'description' => 'Quyền Xem danh sách học viên',
                'created_at' => time(),
                'updated_at' => time(),
                'group_code' => 'quanLyHoSoHocVien',
            ],
            [
                'name' => 'qXemHocVien',
                'type' => 2,
                'description' => 'Quyền Xem học viên',
                'created_at' => time(),
                'updated_at' => time(),
                'group_code' => 'quanLyHoSoHocVien',
            ],
            [
                'name' => 'qThemHocVien',
                'type' => 2,
                'description' => 'Quyền Thêm mới học viên',
                'created_at' => time(),
                'updated_at' => time(),
                'group_code' => 'quanLyHoSoHocVien',
            ],
            [
                'name' => 'qSuaHocVien',
                'type' => 2,
                'description' => 'Quyền Sửa học viên',
                'created_at' => time(),
                'updated_at' => time(),
                'group_code' => 'quanLyHoSoHocVien',
            ],
            [
                'name' => 'qXoaHocVien',
                'type' => 2,
                'description' => 'Quyền Xóa học viên',
                'created_at' => time(),
                'updated_at' => time(),
                'group_code' => 'quanLyHoSoHocVien',
            ],
            [
                'name' => 'qDongHocPhi',
                'type' => 2,
                'description' => 'Quyền đóng học phí',
                'created_at' => time(),
                'updated_at' => time(),
                'group_code' => 'quanLyHoSoHocVien',
            ],
            
        ];
        $check=Permission::find()->where([
            'in',
            'name',
            [
                //hoc vien dang ky
                'qXemDanhSachHocVienDangKy',
                'qXemHocVienDangKy',
                'qThemHocVienDangKy',
                'qSuaHocVienDangKy',
                'qXoaHocVienDangKy',
                'qThemDongHocPhiDangKy',
                //hoc vien
                'qXemDanhSachHocVien',
                'qXemHocVien',
                'qThemHocVien',
                'qSuaHocVien',
                'qXoaHocVien',
                'qDongHocPhi'
            ]

            ])->count();
        if(!$check)
        foreach ($data as $item) {
            $authItem = new Permission();
            $authItem->name = $item['name'];
            $authItem->type = $item['type'];
            $authItem->description = $item['description'];
            $authItem->created_at = $item['created_at'];
            $authItem->updated_at = $item['updated_at'];
            $authItem->group_code = $item['group_code'];
            $authItem->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        Permission::deleteAll(['name' => [
            //hoc vien dang ky
            'qXemDanhSachHocVienDangKy',
            'qXemHocVienDangKy',
            'qThemHocVienDangKy',
            'qSuaHocVienDangKy',
            'qXoaHocVienDangKy',
            'qThemDongHocPhiDangKy',
            //hoc vien
            'qXemDanhSachHocVien',
            'qXemHocVien',
            'qThemHocVien',
            'qSuaHocVien',
            'qXoaHocVien',
            'qDongHocPhi'
            ]]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240528_132744_insert_auth_item_child_data cannot be reverted.\n";

        return false;
    }
    */
}