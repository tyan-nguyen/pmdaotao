<?php

use yii\db\Migration;

/**
 * Class m241226_084726_create_table_lh_lich_thi
 */
class m241226_084726_create_table_lh_lich_thi extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('lh_lich_thi',[
            'id'=>$this->primaryKey(),
            'id_khoa_hoc'=>$this->integer()->notNull(),
            'id_nhom' =>$this->integer(),
            'id_phong'=>$this->integer()->notNull(),
            'id_giao_vien_gac'=>$this->integer()->notNull(),
            'thoi_gian_thi'=>$this->datetime(),
            'trang_thai'=>$this->string(20),
            'nguoi_tao'=>$this->integer(),
            'thoi_gian_tao'=>$this->datetime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropTable('lh_lich_thi');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241226_084726_create_table_lh_lich_thi cannot be reverted.\n";

        return false;
    }
    */
}
