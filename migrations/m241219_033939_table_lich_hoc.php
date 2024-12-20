<?php

use yii\db\Migration;

/**
 * Class m241219_033939_table_lich_hoc
 */
class m241219_033939_table_lich_hoc extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('lh_lich_hoc',[
            'id'=>$this->primaryKey(),
            'id_khoa_hoc'=>$this->integer()->notNull(),
            'hoc_phan'=>$this->string(25),
            'id_nhom' =>$this->integer(),
            'id_phong'=>$this->integer()->notNull(),
            'id_giao_vien'=>$this->integer()->notNull(),
            'ngay'=>$this->date(),
            'thu'=>$this->string(15),
            'tiet_bat_dau'=>$this->integer(),
            'tiet_ket_thuc'=>$this->integer(),
            'nguoi_tao'=>$this->integer(),
            'thoi_gian_tao'=>$this->datetime(),
           ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropTable('lh_lich_hoc');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241219_033939_table_lich_hoc cannot be reverted.\n";

        return false;
    }
    */
}
