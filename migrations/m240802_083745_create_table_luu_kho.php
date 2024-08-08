<?php

use yii\db\Migration;

/**
 * Class m240802_083745_create_table_luu_kho
 */
class m240802_083745_create_table_luu_kho extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      $this->createTable('luu_kho',[
        'id'=>$this->primaryKey(),
        'loai_ho_so'=>$this->string(),
        'id_ho_so'=>$this->integer()->notNull(),
        'id_kho'=>$this->integer()->notNull(),
        'id_ke'=>$this->integer()->notNull(),
        'id_ngan'=>$this->integer()->notNull(),
        'id_hop'=>$this->integer()->notNull(),
      ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropTable('luu_kho');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240802_083745_create_table_luu_kho cannot be reverted.\n";

        return false;
    }
    */
}
