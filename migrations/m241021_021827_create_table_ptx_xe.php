<?php

use yii\db\Migration;

/**
 * Class m241021_021827_create_table_ptx_xe
 */
class m241021_021827_create_table_ptx_xe extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       $this->createTable('ptx_xe',[
        'id'=>$this->primaryKey(),
        'id_loai_xe'=>$this->integer()->notNull(),
        'hieu_xe'=>$this->string(50),
        'bien_so_xe'=>$this->string(50),
        'tinh_trang_xe'=>$this->text(),
        'trang_thai'=>$this->string(25),
       ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('ptx_xe');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241021_021827_create_table_ptx_xe cannot be reverted.\n";

        return false;
    }
    */
}
