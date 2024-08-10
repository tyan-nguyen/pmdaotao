<?php

use yii\db\Migration;

class m240802_073745_create_table_nv_phong_ban extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('nv_phong_ban',[
            'id'=>$this->primaryKey(),
            'ten_phong_ban'=>$this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropTable('nv_phong_ban');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240802_073745_create_table_phong_ban cannot be reverted.\n";

        return false;
    }
    */
}
