<?php

use yii\db\Migration;

/**
 * Class m240802_075440_create_table_day
 */
class m240802_075440_create_table_day extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       $this->createTable('day',
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
       $this->dropTable('day');
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
