<?php

use yii\db\Migration;

/**
 * Class m250102_023958_create_table_lh_ket_qua_thi
 */
class m250102_023958_create_table_lh_ket_qua_thi extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('lh_ket_qua_thi',[
            'id'=>$this->primaryKey(),
            'id_hoc_vien'=>$this->integer()->notNull(),
            'id_lich_thi'=>$this->integer()->notNull(),
            'id_phan_thi'=>$this->string(30),
            'diem_so'=>$this->integer(),
            'ket_qua'=>$this->string(20),
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
      $this->dropTable('lh_ket_qua_thi');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250102_023958_create_table_lh_ket_qua_thi cannot be reverted.\n";

        return false;
    }
    */
}
