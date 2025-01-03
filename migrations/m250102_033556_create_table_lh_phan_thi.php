<?php

use yii\db\Migration;

/**
 * Class m250102_033556_create_table_lh_phan_thi
 */
class m250102_033556_create_table_lh_phan_thi extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('lh_phan_thi',[
            'id'=>$this->primaryKey(),
            'ten_phan_thi'=>$this->string(40),
            'id_hang'=>$this->string(15),
            'diem_toi_thieu'=>$this->integer(),
            'thu_tu_thi'=>$this->integer(),
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
       $this->dropTable('lh_phan_thi');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250102_033556_create_table_lh_phan_thi cannot be reverted.\n";

        return false;
    }
    */
}
