<?php

use yii\db\Migration;

/**
 * Class m240819_073558_table_tableto
 */
class m240819_073558_table_tableto extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('nv_to',[
            'id'=>$this->primaryKey(),
            'id_phong_ban'=>$this->integer(),
            'ten_to'=>$this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('nv_to');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240819_073558_table_tableto cannot be reverted.\n";

        return false;
    }
    */
}
