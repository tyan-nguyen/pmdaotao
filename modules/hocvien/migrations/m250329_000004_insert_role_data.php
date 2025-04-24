<?php

use yii\db\Migration;
use webvimark\modules\UserManagement\models\rbacDB\Role;
/**
 * Class m240528_150329_insert_role_data
 */
class m250329_000004_insert_role_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    private $data=[
        [
            'name' => 'nQuanLyHoSoDangKy',
            'type' => 1,
            'description' => 'Quản lý hồ sơ đăng ký',
            'childrenNames'=>[
                'qXemDanhSachHocVienDangKy',
                'qXemHocVienDangKy',
                'qThemHocVienDangKy',
                'qSuaHocVienDangKy',
                'qXoaHocVienDangKy',
                'qThemDongHocPhiDangKy'
            ]
            
        ],
        [
            'name' => 'nQuanLyHoSoHocVien',
            'type' => 1,
            'description' => 'Quản lý hồ sơ học viên',
            'childrenNames'=>[
                'qXemDanhSachHocVien',
                'qXemHocVien',
                'qThemHocVien',
                'qSuaHocVien',
                'qXoaHocVien',
                'qDongHocPhi'
            ]
            
        ],
    ];
    public function safeUp()
    {
        
        $check=Role::find()->where([
            'in',
            'name',
            [
                'nQuanLyHoSoDangKy',
                'nQuanLyHoSoHocVien'
            ]

            ])->count();
        if(!$check)
        {
            foreach ($this->data as $item) {
                $authItem = new Role();
                $authItem->name = $item['name'];
                $authItem->type = $item['type'];
                $authItem->description = $item['description'];
                $authItem->created_at = time();
                $authItem->updated_at = time();
                $authItem->save();
                Role::addChildren($item['name'], $item['childrenNames'], $throwException = false);
            }
            
        }
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        foreach ($this->data as $item) {
            Role::removeChildren($item['name'], $item['childrenNames'], $throwException = false);
        }
        Role::deleteAll(['name' => [
            'nQuanLyHoSoDangKy',
            'nQuanLyHoSoHocVien'
            ]]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240528_150329_insert_role_data cannot be reverted.\n";

        return false;
    }
    */
}
