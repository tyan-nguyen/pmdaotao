<?php

use yii\db\Migration;

/**
 * Class m240823_074711_update_loai_hs
 */
class m240823_074711_update_loai_hs extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       $this->dropColumn('kho_loai_ho_so','ten_ho_so');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->addColumn('kho_loai_ho_so','ten_ho_so','string');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240823_074711_update_loai_hs cannot be reverted.\n";

        return false;
    }
    */
}
