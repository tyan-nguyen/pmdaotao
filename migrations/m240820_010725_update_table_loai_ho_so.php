<?php

use yii\db\Migration;

/**
 * Class m240820_010725_update_table_loai_ho_so
 */
class m240820_010725_update_table_loai_ho_so extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //Đổi tên table hv_loai_ho_so thành kho_loai_ho_so
        $this->renameTable('hv_loai_ho_so','kho_loai_ho_so');
        //Đổi tên cột ho_so_bat_buot của bảng kho_loai_ho so lại thành ho_so_bat_buoc
        $this->renameColumn('kho_loai_ho_so','ho_so_bat_buot','ho_so_bat_buoc');
        //Đổi tên cột thoI_gian_tao của bảng kho_loai_ho_so lại thành thoI_gian_tao
      
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('kho_loai_ho_so', 'ho_so_bat_buoc', 'ho_so_bat_buot');
        $this->renameTable('kho_loai_ho_so', 'hv_loai_ho_so');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240820_010725_update_table_loai_ho_so cannot be reverted.\n";

        return false;
    }
    */
}
