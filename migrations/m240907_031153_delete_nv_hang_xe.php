<?php

use yii\db\Migration;

/**
 * Class m240907_031153_delete_nv_hang_xe
 */
class m240907_031153_delete_nv_hang_xe extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //Xóa kháo ngoại fk-id_hang_xe_hang_xe
      $this->dropForeignKey('fk-id_hang_xe_hang_xe','nv_day');
        //Xóa bảng nv_hang_xe
      $this->dropTable('nv_hang_xe');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addForeignKey(
            'fk-id_hang_xe_hang_xe',
            'nv_day',
            'id_hang_xe',
            'nv_hang_xe',
            'id',
            'CASCADE'
        );
        $this->createTable('nv_hang_xe',[
            'id'=>$this->primaryKey(),
            'ten_hang_xe'=>$this->string()->notNull(),
           ]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240907_031153_delete_nv_hang_xe cannot be reverted.\n";

        return false;
    }
    */
}
