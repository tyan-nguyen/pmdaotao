<?php

use yii\db\Migration;

/**
 * Class m250328_082024_insert_table_hocVien
 */
class m250328_082024_insert_table_hocVien extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('hv_hoc_vien','ngay_het_han_cccd',$this->date());
        $this->addColumn('hv_hoc_vien','ma_so_phieu','integer');
        $this->addColumn('hv_hoc_vien','so_lan_in_phieu','integer');
        $this->addColumn('hv_hoc_vien','noi_dang_ky',$this->string(50));
        $this->alterColumn('hv_hoc_vien', 'so_cccd', $this->string()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('hv_hoc_vien', 'so_cccd', $this->string()->notNull());
        $this->dropColumn('hv_hoc_vien','ngay_het_han_cccd');
        $this->dropColumn('hv_hoc_vien','ma_so_phieu');
        $this->dropColumn('hv_hoc_vien','so_lan_in_phieu');
        $this->dropColumn('hv_hoc_vien','noi_dang_ky');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250328_082024_insert_table_hocVien cannot be reverted.\n";

        return false;
    }
    */
}
