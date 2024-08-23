<?php

use yii\db\Migration;

/**
 * Class m240823_082547_table_file_vb_vb_dk
 */
class m240823_082547_table_file_vb_vb_dk extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable('vb_file_van_ban');
        $this->dropTable('vb_vb_dinh_kem');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->createTable('vb_file_van_ban',[
        'id'=>$this->primaryKey(),
        'id_van_ban'=>$this->integer()->notNull(),
        'file_name'=>$this->string(),
        'file_size'=>$this->string(),
        'file_type'=>$this->string(),
        'file_display_name'=>$this->string(),
        'nguoi_tao'=>$this->integer(),
        'thoi_gian_tao'=>$this->date()
      ]);

      $this->createTable('vb_vb_dinh_kem',[
        'id'=>$this->primaryKey(),
        'id_van_ban'=>$this->integer(),
        'id_van_ban_dinh_kem'=>$this->integer(),
        'nguoi_tao'=>$this->integer(),
        'thoi_gian_tao'=>$this->date(),
      ]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240823_082547_table_file_vb_vb_dk cannot be reverted.\n";

        return false;
    }
    */
}
