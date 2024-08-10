<?php

use yii\db\Migration;


class m240803_021934_them_cot_nguoi_tao_thoi_gian_tao extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //Thêm cột nguoi_tao cho các bảng 
        $this->addColumn('vb_van_ban','nguoi_tao','integer');
        $this->addColumn('vb_file_van_ban','nguoi_tao','integer');
        $this->addColumn('vb_dm_loai_van_ban','nguoi_tao','integer');
        $this->addColumn('vb_vb_dinh_kem','nguoi_tao','integer');
        $this->addColumn('kho_kho','nguoi_tao','integer');
        $this->addColumn('kho_ke','nguoi_tao','integer');
        $this->addColumn('kho_ngan','nguoi_tao','integer');
        $this->addColumn('kho_hop','nguoi_tao','integer');
        $this->addColumn('kho_luu_kho','nguoi_tao','integer');
        $this->addColumn('nv_nhan_vien','nguoi_tao','integer');
        $this->addColumn('nv_phong_ban','nguoi_tao','integer');
        $this->addColumn('nv_day','nguoi_tao','integer');
        $this->addColumn('nv_hang_xe','nguoi_tao','integer');
        $this->addColumn('nv_ho_so_nhan_vien','nguoi_tao','integer');
        $this->addColumn('hv_loai_ho_so','nguoi_tao','integer');
        $this->addColumn('hv_hoc_vien','nguoi_tao','integer');
        $this->addColumn('hv_khoa_hoc','nguoi_tao','integer');
        $this->addColumn('hv_tai_lieu_khoa_hoc','nguoi_tao','integer');
        $this->addColumn('hv_nop_hoc_phi','nguoi_tao','integer');
        $this->addColumn('hv_hang_dao_tao','nguoi_tao','integer');
        $this->addColumn('hv_hoc_phi','nguoi_tao','integer');
        $this->addColumn('hv_ho_so_hoc_vien','nguoi_tao','integer');
       
        //Thêm cột thời gian tạo cho các bảng 
        $this->addColumn('vb_van_ban','thoi_gian_tao','datetime');
        $this->addColumn('vb_file_van_ban','thoi_gian_tao','datetime');
        $this->addColumn('vb_dm_loai_van_ban','thoi_gian_tao','datetime');
        $this->addColumn('vb_vb_dinh_kem','thoi_gian_tao','datetime');
        $this->addColumn('kho_kho','thoi_gian_tao','datetime');
        $this->addColumn('kho_ke','thoi_gian_tao','datetime');
        $this->addColumn('kho_ngan','thoi_gian_tao','datetime');
        $this->addColumn('kho_hop','thoi_gian_tao','datetime');
        $this->addColumn('kho_luu_kho','thoi_gian_tao','datetime');
        $this->addColumn('nv_nhan_vien','thoi_gian_tao','datetime');
        $this->addColumn('nv_phong_ban','thoi_gian_tao','datetime');
        $this->addColumn('nv_day','thoi_gian_tao','datetime');
        $this->addColumn('nv_hang_xe','thoi_gian_tao','datetime');
        $this->addColumn('nv_ho_so_nhan_vien','thoi_gian_tao','datetime');
        $this->addColumn('hv_loai_ho_so','thoI_gian_tao','datetime');
        $this->addColumn('hv_hoc_vien','thoi_gian_tao','datetime');
        $this->addColumn('hv_khoa_hoc','thoi_gian_tao','datetime');
        $this->addColumn('hv_tai_lieu_khoa_hoc','thoi_gian_tao','datetime');
        $this->addColumn('hv_nop_hoc_phi','thoi_gian_tao','datetime');
        $this->addColumn('hv_hang_dao_tao','thoi_gian_tao','datetime');
        $this->addColumn('hv_hoc_phi','thoi_gian_tao','datetime');
        $this->addColumn('hv_ho_so_hoc_vien','thoi_gian_tao','datetime');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       
        $this->dropColumn('vb_van_ban','nguoi_tao','integer');
        $this->dropColumn('vb_file_van_ban','nguoi_tao','integer');
        $this->dropColumn('vb_dm_loai_van_ban','nguoi_tao','integer');
        $this->dropColumn('vb_vb_dinh_kem','nguoi_tao','integer');
        $this->dropColumn('kho_kho','nguoi_tao','integer');
        $this->dropColumn('kho_ke','nguoi_tao','integer');
        $this->dropColumn('kho_ngan','nguoi_tao','integer');
        $this->dropColumn('kho_hop','nguoi_tao','integer');
        $this->dropColumn('kho_luu_kho','nguoi_tao','integer');
        $this->dropColumn('nv_nhan_vien','nguoi_tao','integer');
        $this->dropColumn('nv_phong_ban','nguoi_tao','integer');
        $this->dropColumn('nv_day','nguoi_tao','integer');
        $this->dropColumn('nv_hang_xe','nguoi_tao','integer');
        $this->dropColumn('nv_ho_so_nhan_vien','nguoi_tao','integer');
        $this->dropColumn('hv_loai_ho_so','nguoi_tao','integer');
        $this->dropColumn('hv_hoc_vien','nguoi_tao','integer');
        $this->dropColumn('hv_khoa_hoc','nguoi_tao','integer');
        $this->dropColumn('hv_tai_lieu_khoa_hoc','nguoi_tao','integer');
        $this->dropColumn('hv_nop_hoc_phi','nguoi_tao','integer');
        $this->dropColumn('hv_hang_dao_tao','nguoi_tao','integer');
        $this->dropColumn('hv_hoc_phi','nguoi_tao','integer');
        $this->dropColumn('hv_ho_so_hoc_vien','nguoi_tao','integer');
       
     
        $this->dropColumn('vb_van_ban','thoi_gian_tao','datetime');
        $this->dropColumn('vb_file_van_ban','thoi_gian_tao','datetime');
        $this->dropColumn('vb_dm_loai_van_ban','thoi_gian_tao','datetime');
        $this->dropColumn('vb_vb_dinh_kem','thoi_gian_tao','datetime');
        $this->dropColumn('kho_kho','thoi_gian_tao','datetime');
        $this->dropColumn('kho_ke','thoi_gian_tao','datetime');
        $this->dropColumn('kho_ngan','thoi_gian_tao','datetime');
        $this->dropColumn('kho_hop','thoi_gian_tao','datetime');
        $this->dropColumn('kho_luu_kho','thoi_gian_tao','datetime');
        $this->dropColumn('nv_nhan_vien','thoi_gian_tao','datetime');
        $this->dropColumn('nv_phong_ban','thoi_gian_tao','datetime');
        $this->dropColumn('nv_day','thoi_gian_tao','datetime');
        $this->dropColumn('nv_hang_xe','thoi_gian_tao','datetime');
        $this->dropColumn('nv_ho_so_nhan_vien','thoi_gian_tao','datetime');
        $this->dropColumn('hv_loai_ho_so','thoI_gian_tao','datetime');
        $this->dropColumn('hv_hoc_vien','thoi_gian_tao','datetime');
        $this->dropColumn('hv_khoa_hoc','thoi_gian_tao','datetime');
        $this->dropColumn('hv_tai_lieu_khoa_hoc','thoi_gian_tao','datetime');
        $this->dropColumn('hv_nop_hoc_phi','thoi_gian_tao','datetime');
        $this->dropColumn('hv_hang_dao_tao','thoi_gian_tao','datetime');
        $this->dropColumn('hv_hoc_phi','thoi_gian_tao','datetime');
        $this->dropColumn('hv_ho_so_hoc_vien','thoi_gian_tao','datetime');
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
