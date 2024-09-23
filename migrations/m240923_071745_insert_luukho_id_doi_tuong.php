<?php

use yii\db\Migration;

/**
 * Class m240923_071745_insert_luukho_id_doi_tuong
 */
class m240923_071745_insert_luukho_id_doi_tuong extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       $this ->addColumn('kho_luu_kho','id_doi_tuong','int');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropColumn('kho_luu_kho','id_doi_tuong');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240923_071745_insert_luukho_id_doi_tuong cannot be reverted.\n";

        return false;
    }
    */
}
