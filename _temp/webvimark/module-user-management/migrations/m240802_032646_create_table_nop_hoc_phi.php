<?php

use yii\db\Migration;

/**
 * Class m240802_032646_create_table_nop_hoc_phi
 */
class m240802_032646_create_table_nop_hoc_phi extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('nop_hoc_phi',[
            'id'=>$this->primaryKey(),
            'id_hoc_vien'=>$this->integer()->notNull(),
            'so_tien_nop'=>$this->double()->notNull(),
            'ngay_nop'=>$this->date()->notNull(),
            'nguoi_thu'=>$this->integer()->notNull(),
            'bien_lai'=>$this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropTable('nop_hoc_phi');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240802_032646_create_table_nop_hoc_phi cannot be reverted.\n";

        return false;
    }
    */
}
