<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\nhanvien\models\NhanVien */
?>
<div class="nhan-vien-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_phong_ban',
            'ho_ten',
            'chuc_vu',
            'so_cccd',
            'dia_chi',
            'dien_thoai',
            'tai_khoan',
            'email:email',
            'trinh_do',
            'chuyen_nganh',
            'vi_tri_cong_viec',
            'kinh_nghiem_lam_viec:ntext',
            'ma_so_thue',
            'trang_thai',
            'nguoi_tao',
            'thoi_gian_tao',
        ],
    ]) ?>

</div>
