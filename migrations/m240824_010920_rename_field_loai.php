<?php

use yii\db\Migration;

/**
 * Class m240824_010920_rename_field
 */
class m240824_010920_rename_field_loai extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       $this->renameColumn('kho_loai_file','loai','ten_loai');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->renameColumn('kho_loai_file','ten_loai','loai');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240824_010920_rename_field cannot be reverted.\n";

        return false;
    }
    */
}
