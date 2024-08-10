<?php

use yii\db\Migration;


class m240802_075440_create_table_nv_day extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       $this->createTable('nv_day',
       [
        'id'=>$this->primaryKey(),
        'id_nhan_vien'=>$this->integer()->notNull(),
        'id_hang_xe'=>$this->integer()->notNull(),
        'ly_thuyet'=>$this->boolean()->notNull(),
        'thuc_hanh'=>$this->boolean()->notNull(),
       ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropTable('nv_day');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240802_075440_create_table_day cannot be reverted.\n";

        return false;
    }
    */
}
