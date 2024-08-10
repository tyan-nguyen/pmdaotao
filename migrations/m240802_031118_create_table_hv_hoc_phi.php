<?php

use yii\db\Migration;


class m240802_031118_create_table_hv_hoc_phi extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       $this->createTable('hv_hoc_phi',[
        'id'=>$this->primaryKey(),
        'id_hang'=>$this->integer()->notNull(),
        'hoc_phi'=>$this->double()->notNull(),
        'ngay_ap_dung'=>$this->date()->notNull(),
        'ngay_ket_thuc'=>$this->date()->notNull(),
       ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropTable('hv_hoc_phi');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240802_031118_create_table_hoc_phi cannot be reverted.\n";

        return false;
    }
    */
}
