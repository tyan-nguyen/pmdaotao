<?php

use yii\db\Migration;

/**
 * Class m241223_030430_insert_field_trang_thai_duyet
 */
class m241223_030430_insert_field_trang_thai_duyet extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      $this->addColumn('hv_hoc_vien','trang_thai_duyet',$this->string(15));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropColumn('hv_hoc_vien','trang_thai_duyet');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241223_030430_insert_field_trang_thai_duyet cannot be reverted.\n";

        return false;
    }
    */
}
