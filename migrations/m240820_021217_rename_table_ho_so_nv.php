<?php

use yii\db\Migration;

/**
 * Class m240820_021217_rename_table_ho_so_nv
 */
class m240820_021217_rename_table_ho_so_nv extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
         //Đổi tên bảng nv_ho_so_nhan_vien thành bảng kho_ho_so
         $this->renameTable('nv_ho_so_nhan_vien','kho_ho_so');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameTable('kho_ho_so','nv_ho_so_nhan_vien');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240820_021217_rename_table_ho_so_nv cannot be reverted.\n";

        return false;
    }
    */
}
