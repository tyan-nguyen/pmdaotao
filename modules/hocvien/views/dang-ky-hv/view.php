<?php
/* @var $this yii\web\View */
/* @var $model app\models\HvHocVien */
?>
<div class="hv-hoc-vien-view" style="width: 700px; margin: 0 auto; font-family: Arial, sans-serif; font-size: 14px;">
    <p style="text-align: left; line-height: 1.5;">
        <strong>TRUNG TÂM GDNN & SÁT HẠCH LÁI XE NGUYỄN TRÌNH</strong>
       
    </p>
<br>
    <p style="text-align: center; margin-top: 30px;">
        <strong style="font-size: 18px;">PHIẾU ĐĂNG KÝ</strong>
    </p>

    <p style="margin-top: 40px; color: red;">
        <strong>Thông tin học viên:</strong>
    </p>
    
    <table style="width: 100%; margin-top: 10px; border-spacing: 10px;">
    <tr>
        <td style="width: 50%; vertical-align: top;"><strong>Họ tên học viên:</strong> <?= $model->ho_ten ?></td>
        <td style="width: 50%; vertical-align: top;"><strong>Ngày sinh:</strong> <?= $model->getNgaySinh() ?></td>
    </tr>
    <tr>
        <td style="width: 50%; vertical-align: top;"><strong>Giới tính:</strong> <?= $model->gioi_tinh == 1 ? 'Nam' : 'Nữ' ?></td>
        <td style="width: 50%; vertical-align: top;"><strong>Số CCCD:</strong> <?= $model->so_cccd ?></td>
    </tr>
    <tr>
        <td style="width: 50%; vertical-align: top;"><strong>Địa chỉ:</strong> <?= $model->dia_chi ?></td>
        <td style="width: 50%; vertical-align: top;"><strong>Số điện thoại:</strong> <?= $model->so_dien_thoai ?></td>
    </tr>
</table>


    <p style="margin-top: 30px; color: red;">
        <strong>Thông tin đào tạo</strong>
    </p>
    <p style="padding-left: 10px; "><strong style="font-weight: bold;">Hạng đào tạo:</strong> <?= $model->hangDaoTao ? $model->hangDaoTao->ten_hang : 'Chưa có hạng' ?></p>
    <?php 
$hocPhi = $model->getHocPhi();
if ($hocPhi): ?>
    <p style="padding-left: 10px;"><strong style="font-weight: bold;">Học phí:</strong> <u><?= number_format($hocPhi->hoc_phi, 0, ',', '.') ?> VND</u></p>
<?php else: ?>
    <p>Học phí chưa được cập nhật.</p>
<?php endif; ?>

   

    <div style="width: 100%; text-align: right;">
    <table style="width: 200px; padding: 10px; border-radius: 5px; margin-left: auto;">
        <tr>
            <td style="text-align: center;"><strong>Người lập phiếu</strong></td>
        </tr>
        <tr>
        <td style="height: 150px; text-align: center;"><strong><?= $model->nguoi_lap_phieu?></strong></td>
        </tr>
    </table>
</div>

  
   




   
</div>
