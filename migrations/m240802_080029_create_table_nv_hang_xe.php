<?php

use yii\db\Migration;


class m240802_080029_create_table_nv_hang_xe extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       $this->createTable('nv_hang_xe',[
        'id'=>$this->primaryKey(),
        'ten_hang_xe'=>$this->string()->notNull(),
       ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this-> dropTable('nv_hang_xe');
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
