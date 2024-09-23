<?php

use yii\db\Migration;

/**
 * Class m240923_032341_update_field_doi_tuong_nv
 */
class m240923_032341_update_field_doi_tuong_nv extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('nv_nhan_vien','doi_tuong','tinyint');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('nv_nhan_vien','doi_tuong','string');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240923_032341_update_field_doi_tuong_nv cannot be reverted.\n";

        return false;
    }
    */
}
