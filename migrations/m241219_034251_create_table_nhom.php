<?php

use yii\db\Migration;

/**
 * Class m241219_034251_create_table_nhom
 */
class m241219_034251_create_table_nhom extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('hv_nhom',[
            'id'=>$this->primaryKey(),
            'id_khoa_hoc'=>$this->integer()->notNull(),
            'ten_nhom' =>$this->string(50),
            'ghi_chu'=>$this->text(),
            'nguoi_tao'=>$this->integer(),
            'thoi_gian_tao'=>$this->datetime(),
           ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropTable('hv_nhom');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241219_034251_create_table_nhom cannot be reverted.\n";

        return false;
    }
    */
}
