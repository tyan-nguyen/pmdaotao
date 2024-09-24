<?php

use yii\db\Migration;

/**
 * Class m240924_024338_delete_data_doi_tuong
 */
class m240924_024338_delete_data_doi_tuong extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->update('nv_nhan_vien', ['doi_tuong' => null]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240924_024338_delete_data_doi_tuong cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240924_024338_delete_data_doi_tuong cannot be reverted.\n";

        return false;
    }
    */
}
