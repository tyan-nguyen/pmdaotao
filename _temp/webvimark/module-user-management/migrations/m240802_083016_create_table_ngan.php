<?php

use yii\db\Migration;

/**
 * Class m240802_083016_create_table_ngan
 */
class m240802_083016_create_table_ngan extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      $this->createTable('ngan',
      [
        'id'=>$this->primaryKey(),
        'ten_ngan'=>$this-> string()->notNull(),
      ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
      $this->dropTable('ngan');
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
