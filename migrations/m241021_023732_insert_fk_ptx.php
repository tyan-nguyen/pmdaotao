<?php

use yii\db\Migration;

/**
 * Class m241021_023730_insert_fk_ptx
 */
class m241021_023732_insert_fk_ptx extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
         //FK cho bảng ptx_phieu_thue_xe 
         $this->addForeignKey(
            'fk-id_xe',
            'ptx_phieu_thue_xe',
            'id_xe',
            'ptx_xe',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-loai_hinh_thue',
            'ptx_phieu_thue_xe',
            'id_loai_hinh_thue',
            'ptx_loai_hinh_thue',
            'id',
            'CASCADE'
        );
        //FK cho bảng ptx_xe
        $this->addForeignKey(
            'fk-id_loai_xe_xe',
            'ptx_xe',
            'id_loai_xe',
            'ptx_loai_xe',
            'id',
            'CASCADE'
        );
        //FK cho bảng ptx_loai_hinh_xe
        $this->addForeignKey(
            'fk-loai_xe',
            'ptx_loai_hinh_thue',
            'id_loai_xe',
            'ptx_loai_xe',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-id_xe',
            'ptx_phieu_thue_xe'
        );
        $this->dropForeignKey(
            'fk-loai_hinh_thue',
            'ptx_phieu_thue_xe'
        );
        //
        $this->dropForeignKey(
            'fk-id_loai_xe_xe',
            'ptx_xe',
        );
        //
        $this->dropForeignKey(
            'fk-loai_xe',
            'ptx_loai_hinh_thue',
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241021_023730_insert_fk_ptx cannot be reverted.\n";

        return false;
    }
    */
}
