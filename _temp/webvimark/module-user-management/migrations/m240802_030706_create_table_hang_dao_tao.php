<?php

use yii\db\Migration;

/**
 * Class m240802_030706_create_table_hang_dao_tao
 */
class m240802_030706_create_table_hang_dao_tao extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       $this->createTable('hang_dao_tao',[
        'id'=>$this->primaryKey(),
        'ten_hang'=>$this->string()->notNull(),
        'ghi_chu'=>$this->text(),
       ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('hang_dao_tao');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240802_030706_create_table_hang_dao_tao cannot be reverted.\n";

        return false;
    }
    */
}
