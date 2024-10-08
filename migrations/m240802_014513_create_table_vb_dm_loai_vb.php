<?php

use yii\db\Migration;


class m240802_014513_create_table_vb_dm_loai_vb extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('vb_dm_loai_van_ban',[
            'id'=>$this->primaryKey(),
            'ten_loai'=>$this->string()->notNull(),
            'ghi_chu'=>$this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('vb_dm_loai_van_ban');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240802_014513_create_table_dm_loai_vb cannot be reverted.\n";

        return false;
    }
    */
}
