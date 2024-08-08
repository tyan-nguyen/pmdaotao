<?php

use yii\db\Migration;

/**
 * Class m240802_080029_create_table_hang_xe
 */
class m240802_080029_create_table_hang_xe extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       $this->createTable('hang_xe',[
        'id'=>$this->primaryKey(),
        'ten_hang_xe'=>$this->string()->notNull(),
       ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this-> dropTable('hang_xe');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240802_080029_create_table_hang_xe cannot be reverted.\n";

        return false;
    }
    */
}
