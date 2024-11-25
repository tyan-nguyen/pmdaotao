<?php

use yii\db\Migration;

/**
 * Class m241125_031108_create_table_ptx_hinh_xe
 */
class m241125_031108_create_table_ptx_hinh_xe extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('ptx_hinh_xe',[
            'id'=>$this->primaryKey(),
            'id_xe'=>$this->integer(),
            'hinh_anh'=>$this->text(),
            'nguoi_tao'=>$this->integer(),
            'thoi_gian_tao'=>$this->integer(),
           ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropTable('ptx_hinh_xe');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241125_031108_create_table_ptx_hinh_xe cannot be reverted.\n";

        return false;
    }
    */
}
