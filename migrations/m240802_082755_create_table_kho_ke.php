<?php

use yii\db\Migration;

class m240802_082755_create_table_kho_ke extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
    $this->createTable('kho_ke',
    [
        'id'=>$this->primaryKey(),
        'id_kho'=>$this->integer()->notNUll(),
        'ten_ke'=>$this->string()->notNull(),
    
    ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('kho_ke');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240802_082755_create_table_ke cannot be reverted.\n";

        return false;
    }
    */
}
