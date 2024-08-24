<?php

use yii\db\Migration;

/**
 * Class m240824_011738_rename_field_id_loai_hs
 */
class m240824_011738_rename_field_id_loai_hs extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       $this->renameColumn('kho_file','id_loai_ho_so','ten_loai');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
      $this->renameColumn('kho_file','ten_loai','id_loai_ho_so');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240824_011738_rename_field_id_loai_hs cannot be reverted.\n";

        return false;
    }
    */
}
