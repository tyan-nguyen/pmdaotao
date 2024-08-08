<?php

use yii\db\Migration;

/**
 * Class m240802_033557_create_table_nhan_vien
 */
class m240802_033557_create_table_nhan_vien extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       $this->createTable('nhan_vien',[
        'id'=>$this->primaryKey(),
        'id_phong_ban'=>$this->integer(),
        'ho_ten'=>$this->string()->notNull(),
        'chuc_vu'=>$this->string(),
        'so_cccd'=>$this->string(),
        'dia_chi'=>$this->string(),
        'dien_thoai'=>$this->string(),
        'tai_khoan'=>$this->string(),
        'email'=>$this->string(),
        'trinh_do'=>$this->string(),
        'chuyen_nganh'=>$this->string(),
        'vi_tri_cong_viec'=>$this->string(),
        'kinh_nghiem_lam_viec'=>$this->text(),
        'ma_so_thue'=>$this->string(),
        'trang_thai'=>$this->string(),
              
    ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('nhan_vien');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240802_033557_create_table_nhan_vien cannot be reverted.\n";

        return false;
    }
    */
}
