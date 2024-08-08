<?php

use yii\db\Migration;

/**
 * Class m240802_083217_create_table_hop
 */
class m240802_083217_create_table_hop extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      $this->createTable('hop',
      [
        'id'=>$this->primaryKey(),
        'id_ngan'=>$this->integer()->notNUll(),
        'ten_hop'=>$this->string()->notNull(),
  
      ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    $this->dropTable('hop');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240802_083217_create_table_hop cannot be reverted.\n";

        return false;
    }
    */
}
