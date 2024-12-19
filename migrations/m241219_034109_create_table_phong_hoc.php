<?php

use yii\db\Migration;

/**
 * Class m241219_034109_create_table_phong_hoc
 */
class m241219_034109_create_table_phong_hoc extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('lh_phong_hoc',[
            'id'=>$this->primaryKey(),
            'ten_phong'=>$this->string(50),
            'so_do_phong'=>$this->string(),
            'ghi_chu'=>$this->text(),
            'nguoi_tao'=>$this->integer(),
            'thoi_gian_tao'=>$this->datetime(),
           ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropTable('lh_phong-hoc');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241219_034109_create_table_phong_hoc cannot be reverted.\n";

        return false;
    }
    */
}
