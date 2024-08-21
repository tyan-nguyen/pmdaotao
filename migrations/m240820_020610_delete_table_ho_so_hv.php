<?php

use yii\db\Migration;

/**
 * Class m240820_020610_delete_table_ho_so_hv
 */
class m240820_020610_delete_table_ho_so_hv extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
           //Xóa bỏ hồ sơ học viên 
        $this->dropTable('hv_ho_so_hoc_vien');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240820_020610_delete_table_ho_so_hv cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240820_020610_delete_table_ho_so_hv cannot be reverted.\n";

        return false;
    }
    */
}
