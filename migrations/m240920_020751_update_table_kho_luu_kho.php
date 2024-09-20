<?php

use yii\db\Migration;

/**
 * Class m240920_020751_update_table_kho_luu_kho
 */
class m240920_020751_update_table_kho_luu_kho extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('kho_luu_kho','loai_ho_so','loai_file');
        $this->renameColumn('kho_luu_kho','id_ho_so','id_file');
        $this->addColumn('kho_luu_kho','doi_tuong',$this->string(20));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('kho_luu_kho','loai_file','loai_ho_so');
        $this->renameColumn('kho_luu_kho','id_file','id_ho_so');
        $this->dropColumn('kho_luu_kho','doi_tuong');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240920_020751_update_table_kho_luu_kho cannot be reverted.\n";

        return false;
    }
    */
}
