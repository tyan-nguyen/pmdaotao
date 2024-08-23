<?php

use yii\db\Migration;

/**
 * Class m240823_075003_update_name_table_ho_so
 */
class m240823_075003_update_name_table_ho_so extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       $this->renameTable('kho_ho_so','kho_file');
       $this->renameTable('kho_loai_ho_so','kho_loai_file');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->renameTable('kho_file','kho_ho_so');
       $this->renameTable('kho_loai_file','kho_loai_ho_so');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240823_075003_update_name_table_ho_so cannot be reverted.\n";

        return false;
    }
    */
}
