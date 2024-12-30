<?php

use yii\db\Migration;

/**
 * Class m241230_093137_create_fk_table_lich_thi
 */
class m241230_093137_create_fk_table_lich_thi extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey(
            'fk_khoa_hoc',
            'lh_lich_thi',
            'id_khoa_hoc',
            'hv_khoa_hoc',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_giao_vien',
            'lh_lich_thi',
            'id_giao_vien_gac',
            'nv_nhan_vien',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_nhom',
            'lh_lich_thi',
            'id_nhom',
            'hv_nhom',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_phong',
            'lh_lich_thi',
            'id_phong_thi',
            'lh_phong',
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
            'fk_khoa_hoc',
            'lh_lich_thi'
        );

        $this->dropForeignKey(
            'fk_giao_vien',
            'lh_lich_thi'
        );
        $this->dropForeignKey(
            'fk_nhom',
            'lh_lich_thi'
        );
        $this->dropForeignKey(
            'fk_phong',
            'lh_lich_thi'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241230_093137_create_fk_table_lich_thi cannot be reverted.\n";

        return false;
    }
    */
}
