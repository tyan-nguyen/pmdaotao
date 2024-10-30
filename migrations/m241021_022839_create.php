<?php

use yii\db\Migration;

/**
 * Class m241021_022839_create
 */
class m241021_022839_create extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       $this->createTable('ptx_loai_xe',[
        'id'=>$this->primaryKey(),
        'ten_loai_xe'=>$this->string(50)->notNull(),
        'ghi_chu'=>$this->text(),
        'nguoi_tao'=>$this->integer(),
        'thoi_gian_tao'=>$this->integer(),
       ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
      $this->dropTable('ptx_loai_xe');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241021_022839_create cannot be reverted.\n";

        return false;
    }
    */
}
