<?php

use yii\db\Migration;

class m240802_083016_create_table_kho_ngan extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      $this->createTable('kho_ngan',
      [
        'id'=>$this->primaryKey(),
        'id_ke'=>$this->integer()->notNull(),
        'ten_ngan'=>$this-> string()->notNull(),
       
      ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
      $this->dropTable('kho_ngan');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240802_083016_create_table_ngan cannot be reverted.\n";

        return false;
    }
    */
}
