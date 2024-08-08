<?php

use yii\db\Migration;

/**
 * Class m240802_024906_create_table_tai_lieu_khoa_hoc
 */
class m240802_024906_create_table_tai_lieu_khoa_hoc extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       $this->createTable('tai_lieu_khoa_hoc',[
        'id'=>$this->primaryKey(),
        'id_khoa_hoc'=>$this->integer()->notNull(),
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
        $this->dropTable('tai_lieu_khoa_hoc');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240802_024906_create_table_tai_lieu_khoa_hoc cannot be reverted.\n";

        return false;
    }
    */
}
