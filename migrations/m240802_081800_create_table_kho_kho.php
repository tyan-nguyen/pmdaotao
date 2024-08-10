<?php

use yii\db\Migration;

class m240802_081800_create_table_kho_kho extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       $this->createTable('kho_kho',
       [
        'id'=>$this->primaryKey(),
        'ten_kho'=>$this->string()->notNull(),
        'so_do_kho'=>$this->string(),
       ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('kho_kho');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240802_081800_create_table_kho cannot be reverted.\n";

        return false;
    }
    */
}
