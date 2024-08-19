<?php

use yii\db\Migration;

/**
 * Class m240819_073110_loai_hs_doi_tuong
 */
class m240819_073110_loai_hs_doi_tuong extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('hv_loai_ho_so','doi_tuong','integer');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('nv_loai_ho_so','doi_tuong');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240819_073110_loai_hs_doi_tuong cannot be reverted.\n";

        return false;
    }
    */
}
