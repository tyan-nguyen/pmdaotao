<?php

use yii\db\Migration;

/**
 * Class m241021_020732_create_table_ptx_loai_hinh_thue
 */
class m241021_020732_create_table_ptx_loai_hinh_thue extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       $this->createTable('ptx_loai_hinh_thue',[
        'id'=>$this->primaryKey(),
        'loai_hinh_thue'=>$this->string(20)->notNull(),
        'id_loai_xe'=>$this->integer()->notNull(),
        'gia_thue'=>$this->double()->notNull(),
        'ngay_ap_dung'=>$this->date()->notNull(),
        'ngay_ket_thuc'=>$this->date()->notNull(),
        'nguoi_tao'=>$this->integer(),
        'thoi_gian_tao'=>$this->datetime(),
       ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
      $this->dropTable('ptx_loai_hinh_thue');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241021_020732_create_table_ptx_loai_hinh_thue cannot be reverted.\n";

        return false;
    }
    */
}
