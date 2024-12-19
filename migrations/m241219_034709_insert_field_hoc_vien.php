<?php

use yii\db\Migration;

/**
 * Class m241219_034709_insert_field_hoc_vien
 */
class m241219_034709_insert_field_hoc_vien extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('hv_hoc_vien','loai_dang_ky',$this->string(15));
        $this->addColumn('hv_hoc_vien','nguoi_duyet','integer');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {  
        $this->dropColumn('hv_hoc_vien','loai_dang_ky');
        $this->dropColumn('hv_hoc_vien','nguoi_duyet');
    }
    
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241219_034709_insert_field_hoc_vien cannot be reverted.\n";

        return false;
    }
    */
}
