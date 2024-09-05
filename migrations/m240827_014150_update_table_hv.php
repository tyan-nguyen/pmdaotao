<?php

use yii\db\Migration;

/**
 * Class m240827_014150_update_table_hv
 */
class m240827_014150_update_table_hv extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       $this->dropColumn('hv_hoc_vien','ngay_cap_cccd');
       $this->dropColumn('hv_hoc_vien','noi_cap_cccd');
       $this->addColumn('hv_hoc_vien','gioi_tinh','integer');
       $this->addColumn('hv_hoc_vien','dia_chi','string');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->addColumn('hv_hoc_vien','ngay_cap_cccd','date');
       $this->addColumn('hv_hoc_vien','noi_cap_cccd','string');
       $this->dropColumn('hv_hoc_vien','gioi_tinh');
       $this->dropColumn('hv_hoc_vien','dia_chi');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240827_014150_update_table_hv cannot be reverted.\n";

        return false;
    }
    */
}
