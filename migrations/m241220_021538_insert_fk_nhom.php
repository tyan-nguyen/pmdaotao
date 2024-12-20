<?php

use yii\db\Migration;

/**
 * Class m241220_021538_insert_fk_nhom
 */
class m241220_021538_insert_fk_nhom extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey(
            'fk_nhom',
            'hv_hoc_vien',
            'id_nhom',
            'hv_nhom',
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
            'fk_nhom',
            'hv_hoc_vien'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241220_021538_insert_fk_nhom cannot be reverted.\n";

        return false;
    }
    */
}
