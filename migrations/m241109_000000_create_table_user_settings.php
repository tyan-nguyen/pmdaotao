<?php
use yii\db\Migration;

class m241109_000000_create_table_user_settings extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user_settings',[
            'id'=>$this->primaryKey(),
            'default_show_search'=>$this->boolean()->null(),
        ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user_settings');
    }
    
}
