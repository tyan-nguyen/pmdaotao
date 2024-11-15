<?php

use yii\db\Migration;

/**
 * Class m241113_075737_create_table_tPhuongThucThue
 */
class m241113_075737_create_table_tPhuongThucThue extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('ptx_loai_hinh_thue_chi_tiet',[
            'id'=>$this->primaryKey(),
            'ten_loai_hinh_thue'=>$this->string(50),
            'don_vi_tinh'=>$this->string(20),
            'buoi'=>$this->string(20),
            'gio_bat_dau'=>$this->time(),
            'gio_ket_thuc'=>$this->time(),
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
      $this->dropTable('ptx_loai_hinh_thue_chi_tiet');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241113_075737_create_table_tPhuongThucThue cannot be reverted.\n";

        return false;
    }
    */
}
