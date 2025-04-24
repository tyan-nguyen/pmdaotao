<?php

use yii\db\Migration;
use webvimark\modules\UserManagement\models\rbacDB\AuthItemGroup;
/**
 * Class m240528_130019_insert_auth_item_group_data
 */
class m250329_000001_insert_auth_item_group_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $data = [
            ['code' => 'quanLyHoSoDangKy', 'name' => 'Quản lý hồ sơ đăng ký', 'created_at' => time(), 'updated_at' => time()],
           ['code' => 'quanLyHoSoHocVien', 'name' => 'Quản lý hồ sơ học viên', 'created_at' => time(), 'updated_at' => time()],
            
        ];
        $check=AuthItemGroup::find()->where(['in','code',['quanLyHoSoDangKy', 'quanLyHoSoHocVien']])->count();
        if(!$check)
        foreach ($data as $item) {
            $authItemGroup = new AuthItemGroup();
            $authItemGroup->code = $item['code'];
            $authItemGroup->name = $item['name'];
            $authItemGroup->created_at = $item['created_at'];
            $authItemGroup->updated_at = $item['updated_at'];
            $authItemGroup->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        AuthItemGroup::deleteAll(['code' => ['quanLyHoSoDangKy', 'quanLyHoSoHocVien' ]]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240528_130019_insert_auth_item_group_data cannot be reverted.\n";

        return false;
    }
    */
}
