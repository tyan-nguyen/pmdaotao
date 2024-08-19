<?php

use yii\db\Migration;

/**
 * Class m240814_035312_table_nv_to
 */
class m240814_035312_table_nv_to extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('nv_to',[
            'id'=>$this->primaryKey(),
            'id_phong_ban'=>$this->integer(),
            'ten_to'=>$this->string()->notNull(),
        ]);
        $this->addForeignKey(
            'fk-id_phong_ban_to',
            'nv_to',
            'id_phong_ban',
            'nv_phong_ban',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('nv_to');
       $this->dropForeignKey(
        'fk-id_phong_ban_to',
        'nv_to');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240814_035312_table_nv_to cannot be reverted.\n";

        return false;
    }
    */
}
