<?php

use yii\db\Migration;


class m240802_013852_create_table_vb_van_ban extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this -> createTable('vb_van_ban',[
            'id'=> $this->primaryKey(),
            'id_loai_van_ban'=>$this->integer()->notNull(),
            'so_vb'=>$this->string()->notNull(),
            'ngay_ky'=>$this->date()->notNull(),
            'trich_yeu'=>$this->string()->notNull(),
            'nguoi_ky'=>$this->string()->notNull(),
            'vbden_ngay_den'=>$this->date(),
            'vbden_so_den'=>$this->integer(),
            'vbden_nguoi_nhan'=>$this->integer(),
            'vbden_ngay_chuyen'=>$this->date(),
            'vbdi_noi_nhan'=>$this->string(),
            'vbdi_so_luong_ban'=>$this->integer(),
            'vbdi_ngay_chuyen'=>$this->date(),
            'ghi_chu'=>$this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('vb_van_ban');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240802_013852_create_table_van_ban cannot be reverted.\n";

        return false;
    }
    */
}
