<?php

use yii\db\Migration;


class m240802_021844_create_table_hv_hoc_vien extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('hv_hoc_vien',[
            'id'=>$this->primaryKey(),
            'id_khoa_hoc'=>$this->integer()->notNull(),
            'ho_ten'=>$this->string()->notNull(),
            'so_dien_thoai'=>$this->string()->notNull(),
            'so_cccd'=>$this->string()->notNull(),
            'ngay_cap_cccd'=>$this->date()->notNull(),
            'noi_cap_cccd'=>$this->string()->notNull(),
            'trang_thai'=>$this->string()->notNull(),
           ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('hv_hoc_vien');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240802_021844_create_table_hoc_vien cannot be reverted.\n";

        return false;
    }
    */
}
