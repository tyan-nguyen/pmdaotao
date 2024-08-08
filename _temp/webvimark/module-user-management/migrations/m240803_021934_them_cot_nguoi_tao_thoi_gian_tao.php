<?php

use yii\db\Migration;

/**
 * Class m240803_021934_them_cot_nguoi_tao_thoi_gian_tao
 */
class m240803_021934_them_cot_nguoi_tao_thoi_gian_tao extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //Thêm cột nguoi_tao cho các bảng 
        $this->addColumn('van_ban','nguoi_tao','integer');
        $this->addColumn('file_van_ban','nguoi_tao','integer');
        $this->addColumn('dm_loai_van_ban','nguoi_tao','integer');
        $this->addColumn('vb_dinh_kem','nguoi_tao','integer');
        $this->addColumn('kho','nguoi_tao','integer');
        $this->addColumn('ke','nguoi_tao','integer');
        $this->addColumn('ngan','nguoi_tao','integer');
        $this->addColumn('hop','nguoi_tao','integer');
        $this->addColumn('luu_kho','nguoi_tao','integer');
        $this->addColumn('nhan_vien','nguoi_tao','integer');
        $this->addColumn('phong_ban','nguoi_tao','integer');
        $this->addColumn('day','nguoi_tao','integer');
        $this->addColumn('hang_xe','nguoi_tao','integer');
        $this->addColumn('ho_so_nhan_vien','nguoi_tao','integer');
        $this->addColumn('loai_ho_so','nguoi_tao','integer');
        $this->addColumn('hoc_vien','nguoi_tao','integer');
        $this->addColumn('khoa_hoc','nguoi_tao','integer');
        $this->addColumn('tai_lieu_khoa_hoc','nguoi_tao','integer');
        $this->addColumn('nop_hoc_phi','nguoi_tao','integer');
        $this->addColumn('hang_dao_tao','nguoi_tao','integer');
        $this->addColumn('hoc_phi','nguoi_tao','integer');
        $this->addColumn('ho_so_hoc_vien','nguoi_tao','integer');
       
        //Thêm cột thời gian tạo cho các bảng 
        $this->addColumn('van_ban','thoi_gian_tao','datetime');
        $this->addColumn('file_van_ban','thoi_gian_tao','datetime');
        $this->addColumn('dm_loai_van_ban','thoi_gian_tao','datetime');
        $this->addColumn('vb_dinh_kem','thoi_gian_tao','datetime');
        $this->addColumn('kho','thoi_gian_tao','datetime');
        $this->addColumn('ke','thoi_gian_tao','datetime');
        $this->addColumn('ngan','thoi_gian_tao','datetime');
        $this->addColumn('hop','thoi_gian_tao','datetime');
        $this->addColumn('luu_kho','thoi_gian_tao','datetime');
        $this->addColumn('nhan_vien','thoi_gian_tao','datetime');
        $this->addColumn('phong_ban','thoi_gian_tao','datetime');
        $this->addColumn('day','thoi_gian_tao','datetime');
        $this->addColumn('hang_xe','thoi_gian_tao','datetime');
        $this->addColumn('ho_so_nhan_vien','thoi_gian_tao','datetime');
        $this->addColumn('loai_ho_so','thoI_gian_tao','datetime');
        $this->addColumn('hoc_vien','thoi_gian_tao','datetime');
        $this->addColumn('khoa_hoc','thoi_gian_tao','datetime');
        $this->addColumn('tai_lieu_khoa_hoc','thoi_gian_tao','datetime');
        $this->addColumn('nop_hoc_phi','thoi_gian_tao','datetime');
        $this->addColumn('hang_dao_tao','thoi_gian_tao','datetime');
        $this->addColumn('hoc_phi','thoi_gian_tao','datetime');
        $this->addColumn('ho_so_hoc_vien','thoi_gian_tao','datetime');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       
        $this->dropColumn('van_ban','nguoi_tao','integer');
        $this->dropColumn('file_van_ban','nguoi_tao','integer');
        $this->dropColumn('dm_loai_van_ban','nguoi_tao','integer');
        $this->dropColumn('vb_dinh_kem','nguoi_tao','integer');
        $this->dropColumn('kho','nguoi_tao','integer');
        $this->dropColumn('ke','nguoi_tao','integer');
        $this->dropColumn('ngan','nguoi_tao','integer');
        $this->dropColumn('hop','nguoi_tao','integer');
        $this->dropColumn('luu_kho','nguoi_tao','integer');
        $this->dropColumn('nhan_vien','nguoi_tao','integer');
        $this->dropColumn('phong_ban','nguoi_tao','integer');
        $this->dropColumn('day','nguoi_tao','integer');
        $this->dropColumn('hang_xe','nguoi_tao','integer');
        $this->dropColumn('ho_so_nhan_vien','nguoi_tao','integer');
        $this->dropColumn('loai_ho_so','nguoi_tao','integer');
        $this->dropColumn('hoc_vien','nguoi_tao','integer');
        $this->dropColumn('khoa_hoc','nguoi_tao','integer');
        $this->dropColumn('tai_lieu_khoa_hoc','nguoi_tao','integer');
        $this->dropColumn('nop_hoc_phi','nguoi_tao','integer');
        $this->dropColumn('hang_dao_tao','nguoi_tao','integer');
        $this->dropColumn('hoc_phi','nguoi_tao','integer');
        $this->dropColumn('ho_so_hoc_vien','nguoi_tao','integer');
       
     
        $this->dropColumn('van_ban','thoi_gian_tao','datetime');
        $this->dropColumn('file_van_ban','thoi_gian_tao','datetime');
        $this->dropColumn('dm_loai_van_ban','thoi_gian_tao','datetime');
        $this->dropColumn('vb_dinh_kem','thoi_gian_tao','datetime');
        $this->dropColumn('kho','thoi_gian_tao','datetime');
        $this->dropColumn('ke','thoi_gian_tao','datetime');
        $this->dropColumn('ngan','thoi_gian_tao','datetime');
        $this->dropColumn('hop','thoi_gian_tao','datetime');
        $this->dropColumn('luu_kho','thoi_gian_tao','datetime');
        $this->dropColumn('nhan_vien','thoi_gian_tao','datetime');
        $this->dropColumn('phong_ban','thoi_gian_tao','datetime');
        $this->dropColumn('day','thoi_gian_tao','datetime');
        $this->dropColumn('hang_xe','thoi_gian_tao','datetime');
        $this->dropColumn('ho_so_nhan_vien','thoi_gian_tao','datetime');
        $this->dropColumn('loai_ho_so','thoI_gian_tao','datetime');
        $this->dropColumn('hoc_vien','thoi_gian_tao','datetime');
        $this->dropColumn('khoa_hoc','thoi_gian_tao','datetime');
        $this->dropColumn('tai_lieu_khoa_hoc','thoi_gian_tao','datetime');
        $this->dropColumn('nop_hoc_phi','thoi_gian_tao','datetime');
        $this->dropColumn('hang_dao_tao','thoi_gian_tao','datetime');
        $this->dropColumn('hoc_phi','thoi_gian_tao','datetime');
        $this->dropColumn('ho_so_hoc_vien','thoi_gian_tao','datetime');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240803_021934_them_cot_nguoi_tao_thoi_gian_tao cannot be reverted.\n";

        return false;
    }
    */
}
