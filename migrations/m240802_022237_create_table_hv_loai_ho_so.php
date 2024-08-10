<?php

use yii\db\Migration;


class m240802_022237_create_table_hv_loai_ho_so extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       $this->createTable('hv_loai_ho_so',[
        'id'=>$this->primaryKey(),
        'ten_ho_so'=>$this->string()->notNull(),
        'loai'=>$this->string()->notNull(),
        'ho_so_bat_buot'=>$this->boolean()->notNull(),
        'ghi_chu'=>$this->text(),
       ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
      $this->dropTable('hv_loai_ho_so');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240802_022237_create_table_loai_ho_so cannot be reverted.\n";

        return false;
    }
    */
}
