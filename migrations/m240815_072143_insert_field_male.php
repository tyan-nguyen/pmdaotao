<?php

use yii\db\Migration;

/**
 * Class m240815_072143_insert_field_male
 */
class m240815_072143_insert_field_male extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('nv_nhan_vien','gioi_tinh','integer');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropColumn('nv_nhan_vien','gioi_tinh');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240815_072143_insert_field_male cannot be reverted.\n";

        return false;
    }
    */
}
