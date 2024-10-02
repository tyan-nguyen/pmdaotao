<?php

use yii\db\Migration;

/**
 * Class m241002_011738_rename_field_vbden_so_den
 */
class m241002_011738_rename_field_vbden_so_den extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('vb_van_ban','vbden_so_den','so_vao_so');
    }
    
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('vb_van_ban','so_vao_so','vbden_so_den');
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
