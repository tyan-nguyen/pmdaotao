<?php

use yii\db\Migration;

/**
 * Class m240802_023155_create_table_ho_so_hoc_vien
 */
class m240802_023155_create_table_ho_so_hoc_vien extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
    $this->createTable('ho_so_hoc_vien',[
        'id'=>$this->primaryKey(),
        'id_hoc_vien'=>$this->integer()->notNull(),
        'id_loai_ho_so'=>$this->integer()->notNull(),
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
        $this->dropTable('ho_so_hoc_vien');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240802_023155_create_table_ho_so_hoc_vien cannot be reverted.\n";

        return false;
    }
    */
}
