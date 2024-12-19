<?php

use yii\db\Migration;

/**
 * Class m241219_083753_create_fk_lich_hoc
 */
class m241219_083753_create_fk_lich_hoc extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
          //FK cho bảng lh_lich_hoc
          $this->addForeignKey(
            'lh_khoa_hoc',
            'lh_lich_hoc',
            'id_khoa_hoc',
            'hv_khoa_hoc',
            'id',
            'CASCADE'
        );
          //FK cho bảng lh_lich_hoc
          $this->addForeignKey(
            'lh_giao_vien',
            'lh_lich_hoc',
            'id_giao_vien',
            'nv_nhan_vien',
            'id',
            'CASCADE'
        );

           //FK cho bảng lh_lich_hoc
           $this->addForeignKey(
            'lh_nhom_hoc',
            'lh_lich_hoc',
            'id_nhom',
            'hv_nhom',
            'id',
            'CASCADE'
        );

         //FK cho bảng lh_lich_hoc
         $this->addForeignKey(
            'lh_phong_hoc',
            'lh_lich_hoc',
            'id_phong',
            'lh_phong_hoc',
            'id',
            'CASCADE'
        );

            //FK cho bảng lh_lich_hoc
            $this->addForeignKey(
                'hv_khoa_hoc',
                'lh_phong_hoc',
                'id_khoa_hoc',
                'hv_khoa_hoc',
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
            'lh_khoa_hoc',
            'lh_lich_hoc'
        );

        $this->dropForeignKey(
            'lh_giao_vien',
            'lh_lich_hoc'
        );
        $this->dropForeignKey(
            'lh_nhom_hoc',
            'lh_lich_hoc'
        );
        $this->dropForeignKey(
            'lh_phong_hoc',
            'lh_lich_hoc'
        );
        $this->dropForeignKey(
            'hv_khoa_hoc',
            'lh_phong_hoc'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241219_083753_create_fk_lich_hoc cannot be reverted.\n";

        return false;
    }
    */
}
