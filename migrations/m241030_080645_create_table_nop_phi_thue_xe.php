<?php

use yii\db\Migration;

/**
 * Class m241030_080645_create_table_nop_phi_thue_xe
 */
class m241030_080645_create_table_nop_phi_thue_xe extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('ptx_nop_phi_thue_xe',[
            'id'=>$this->primaryKey(),
            'id_phieu_thue_xe'=>$this->integer(),
            'id_hoc_vien'=>$this->integer(),
            'ho_ten_nguoi_thue'=>$this->string(50),
            'so_cccd_nguoi_thue'=>$this->string(15),
            'dia_chi_nguoi_thue'=>$this->string(),
            'so_dien_thoai_nguoi_thue'=>$this->string(12),
            'so_tien_nop'=>$this->double(),
            'nguoi_thu'=>$this->integer(),
            'bien_lai'=>$this->string(),
            'ngay_nop'=>$this->date(),
            'nguoi_tao'=>$this->integer(),
            'thoi_gian_tao'=>$this->integer(),
           ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('ptx_nop_phi_thue_xe');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241030_080645_create_table_nop_phi_thue_xe cannot be reverted.\n";

        return false;
    }
    */
}
