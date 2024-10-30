<?php

use yii\db\Migration;

/**
 * Class m241021_084028_insert_field_dang_ap_dung
 */
class m241021_084028_insert_field_dang_ap_dung extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      $this->addColumn('ptx_loai_hinh_thue','dang_ap_dung','tinyint');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropColumn('ptx_loai_hinh_thue','dang_ap_dung');
    }
    

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241021_084028_insert_field_dang_ap_dung cannot be reverted.\n";

        return false;
    }
    */
}
