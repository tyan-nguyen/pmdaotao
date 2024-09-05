<?php

use yii\db\Migration;

/**
 * Class m240905_013104_update_kho_file
 */
class m240905_013104_update_kho_file extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       $this->addColumn('kho_file','ghi_chu',$this->text());
       $this->renameColumn('kho_file','ten_loai','loai_file');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropColumn('kho_file','ghi_chu');
       $this->renameColumn('kho_file','loai_file','ten_loai');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240905_013104_update_kho_file cannot be reverted.\n";

        return false;
    }
    */
}
