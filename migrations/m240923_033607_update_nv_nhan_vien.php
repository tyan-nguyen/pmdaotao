<?php

use yii\db\Migration;

/**
 * Class m240923_033607_update_nv_nhan_vien
 */
class m240923_033607_update_nv_nhan_vien extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       $this->alterColumn('nv_nhan_vien','chuc_vu',$this->text());
       $this->alterColumn('nv_nhan_vien','trinh_do',$this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('nv_nhan_vien','chuc_vu',$this->string());
        $this->alterColumn('nv_nhan_vien','trinh_do',$this->string());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240923_033607_update_nv_nhan_vien cannot be reverted.\n";

        return false;
    }
    */
}
