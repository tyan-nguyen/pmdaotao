<?php

use yii\db\Migration;


class m240802_014950_create_table_vb_file_van_ban extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      $this->createTable('vb_file_van_ban',[
        'id'=>$this->primaryKey(),
        'id_van_ban'=>$this->integer()->notNull(),
        'file_name'=>$this->string()->notNull(),
        'file_type'=>$this->string()->notNull(),
        'file_size'=>$this->string()->notNull(),
        'file_display_name'=>$this->string()->notNull(),
      ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropTable('vb_file_van_ban');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240802_014950_create_table_file_van_ban cannot be reverted.\n";

        return false;
    }
    */
}
