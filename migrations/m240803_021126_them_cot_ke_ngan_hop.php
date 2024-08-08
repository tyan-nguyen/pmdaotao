<?php

use yii\db\Migration;

/**
 * Class m240803_021126_them_cot_ke_ngan_hop
 */
class m240803_021126_them_cot_ke_ngan_hop extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       $this->addColumn('ke','id_kho','integer');
       $this->addColumn('ngan','id_ke','integer');
       $this->addColumn('hop','id_ngan','integer');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('ke','id_kho');
        $this->dropColumn('ngan','id_ke');
        $this->dropColumn('hop','id_ngan');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240803_021126_them_cot_ke_ngan_hop cannot be reverted.\n";

        return false;
    }
    */
}
