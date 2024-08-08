<?php

use yii\db\Migration;

/**
 * Class m240802_082755_create_table_ke
 */
class m240802_082755_create_table_ke extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
    $this->createTable('ke',
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
        $this->dropTable('ke');
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
