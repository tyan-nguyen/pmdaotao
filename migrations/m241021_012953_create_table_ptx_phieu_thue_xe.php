<?php

use yii\db\Migration;

/**
 * Class m241021_012953_create_table_ptx_phieu_thue_xe
 */
class m241021_012953_create_table_ptx_phieu_thue_xe extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('ptx_phieu_thue_xe',[
            //Thông tin tin thuê 
            'id'=>$this->primaryKey(),
            'ngay_thue_xe'=>$this->date(),
            'id_hoc_vien'=>$this->integer(),
            'ho_ten_nguoi_thue'=>$this->string(),
            'so_cccd_nguoi_thue'=>$this->string(),
            'dia_chi_nguoi_thue'=>$this->string(),
            'so_dien_thoai_nguoi_thue'=>$this->string(),
            'id_xe'=>$this->integer()->notNull(),
            'id_loai_hinh_thue'=>$this->integer(),
            'thoi_gian_bat_dau_thue'=>$this->datetime(),
            'thoi_gian_tra_xe_du_kien'=>$this->datetime(),
            'chi_phi_thue_du_kien'=>$this->double(),
            'thoi_gian_tra_xe'=>$this->datetime(),
            'chi_phi_thue_phat_sinh'=>$this->double(),
            'id_nhan_vien_cho_thue'=>$this->integer(),
            'noi_dung_thue'=>$this->text(),
            //Thông tin trả 
            'ngay_tra_xe'=>$this->date(),
            'tinh_trang_xe_khi_tra'=>$this->text(),
            'id_nhan_vien_ky_tra'=>$this->integer(),
            //Thông tin kiểm duyệt
            'id_nguoi_gui'=>$this->integer(),
            'thoi_gian_gui'=>$this->datetime(),
            'ghi_chu_nguoi_gui'=>$this->text(),
            'id_nguoi_duyet'=>$this->integer(),
            'thoi_gian_duyet'=>$this->datetime(),
            'ghi_chu_nguoi_duyet'=>$this->string(),
            'trang_thai'=>$this->string(25,),
            'nguoi_tao'=>$this->integer(),
            'thoi_gian_tao'=>$this->datetime(),
          ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropTable('ptx_phieu_thue_xe');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241021_012953_create_table_ptx_phieu_thue_xe cannot be reverted.\n";

        return false;
    }
    */
}
