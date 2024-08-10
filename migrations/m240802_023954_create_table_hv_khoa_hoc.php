<?php

use yii\db\Migration;

class m240802_023954_create_table_hv_khoa_hoc extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       $this->createTable('hv_khoa_hoc',[
        'id'=>$this->primaryKey(),
        'id_hang'=>$this->integer()->notNull(),
        'ten_khoa_hoc'=>$this->string()->notNull(),
        'ngay_bat_dau'=>$this->date()->notNull(),
        'ngay_ket_thuc'=>$this->date()->notNUll(),
        'ghi_chu'=>$this->text(),
        'trang_thai'=>$this->string()->notNull(),
       ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropTable('hv_khoa_hoc');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240802_023954_create_table_khoa_hoc cannot be reverted.\n";

        return false;
    }
    */
}
