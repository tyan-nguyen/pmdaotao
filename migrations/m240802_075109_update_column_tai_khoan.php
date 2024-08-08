<?php

use yii\db\Migration;

/**
 * Class m240802_075109_update_column_tai_khoan
 */
class m240802_075109_update_column_tai_khoan extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       $this->alterColumn( 'nhan_vien','tai_khoan','boolean');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240802_075109_update_column_tai_khoan cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240802_075109_update_column_tai_khoan cannot be reverted.\n";

        return false;
    }
    */
}
