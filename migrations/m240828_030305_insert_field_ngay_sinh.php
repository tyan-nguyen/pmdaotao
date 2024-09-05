<?php

use yii\db\Migration;

/**
 * Class m240828_030305_insert_field_ngay_sinh
 */
class m240828_030305_insert_field_ngay_sinh extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       $this->addColumn('nv_nhan_vien','ngay_sinh','date');
       $this->addColumn('hv_hoc_vien','ngay_sinh','date');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropColumn('nv_nhan_vien','ngay_sinh');
       $this->dropColumn('hv_hoc_vien','ngay_sinh');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240828_030305_insert_field_ngay_sinh cannot be reverted.\n";

        return false;
    }
    */
}
