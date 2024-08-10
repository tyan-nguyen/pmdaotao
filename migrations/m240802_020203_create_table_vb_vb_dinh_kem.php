<?php

use yii\db\Migration;

class m240802_020203_create_table_vb_vb_dinh_kem extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('vb_vb_dinh_kem',[
            'id'=>$this->primaryKey(),
            'id_van_ban'=>$this->integer()->notNull(),
            'id_van_ban_dinh_kem'=>$this->integer(),
           ]);
    
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('vb_vb_dinh_kem');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240802_020203_create_table_van_ban_dinh_kem cannot be reverted.\n";

        return false;
    }
    */
}
