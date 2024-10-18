<?php
use yii\helpers\Html;
use app\modules\nhanvien\models\NhanVien;
use app\modules\hocvien\models\NopHocPhi;
use app\modules\hocvien\models\HocVien;
use app\modules\hocvien\models\HocPhi;
use app\modules\hocvien\models\KhoaHoc;
use app\widgets\CardWidget;


// Tìm học viên hiện tại
$hocVien = HocVien::findOne($model->id);


// Tìm thông tin hạng đào tạo của học viên
$tenHang = $hocVien && $hocVien->hang ? $hocVien->hang->ten_hang : null;

// Tìm thông tin khóa học của học viên
$khoaHoc = $hocVien && $hocVien->id_khoa_hoc ? KhoaHoc::findOne($hocVien->id_khoa_hoc) : null;

// Tìm học phí dựa trên id_hoc_phi của khóa học
$hocPhiKhoaHoc = $khoaHoc && $khoaHoc->id_hoc_phi ? HocPhi::findOne($khoaHoc->id_hoc_phi) : null;

// Tìm thông tin các lần nộp học phí của học viên
$hocPhi = NopHocPhi::find()->where(['id_hoc_vien' => $hocVien->id])->all();

// Tính tổng số tiền đã nộp
$tongTienDaNop = 0;
foreach ($hocPhi as $nopPhi) {
    $tongTienDaNop += $nopPhi->so_tien_nop;
}

// Kiểm tra trạng thái nộp học phí
$trangThai = ($hocPhiKhoaHoc && $tongTienDaNop >= $hocPhiKhoaHoc->hoc_phi) ? 'Nộp đủ' : 'Chưa nộp đủ';

?>
<div id="hpContent" class="hoc-phi-view">
    <?php if (empty($hocPhi) ): ?>
        <!-- Học viên chưa đóng học phí -->
        <p style="color:red">Học viên chưa đóng học phí !.</p>
        <?php elseif (empty($hocPhiKhoaHoc)): ?>
            <p style="color:red">Khóa học chưa được cài đặt học phí!</p>
    <?php else: ?>
        <?php CardWidget::begin(['title'=>'Thông tin Học phí']) ?>
        <p class="text-align:center;"><b>Hạng xe:</b> <span style="color:blue"><?= $tenHang ?></span></p>
        <p class="text-align:center;"><b>Trạng thái học phí:</b> <span style="color:<?= $trangThai == 'Nộp đủ' ? 'green' : 'red' ?>"><?= $trangThai ?></span></p>
        <p class="text-align:center;">
           <b>Học phí phải nộp:</b> 
           <span style="color:blue">
                <?= number_format($hocPhiKhoaHoc->hoc_phi, 0, ',', '.') ?> VNĐ
           </span>
        </p>
        <p class="text-align:center;">
           <b>Học phí đã nộp:</b> 
           <span style="color:blue">
                <?= number_format($tongTienDaNop, 0, ',', '.') ?> VNĐ
           </span>
        </p>
        <p class="text-align:center;">
           <b>Học phí còn nợ:</b> 
           <span style="color:blue">
                <?= number_format($hocPhiKhoaHoc->hoc_phi - $tongTienDaNop , 0, ',', '.') ?> VNĐ
           </span>
        </p>
        <?php CardWidget::end() ?>
        <?php CardWidget::begin(['title'=>'Chi tiết']) ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Lần nộp</th>
                    <th>Ngày nộp</th>
                    <th>Số tiền nộp</th>
                    <th>Người thu</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $index = 1;
                foreach ($hocPhi as $hcPhi): ?>
                    <tr>
                        <td><?= $index ?></td>
                        <td><?= Yii::$app->formatter->asDate($hcPhi->ngay_nop, 'php:d-m-Y') ?></td>
                        <td><?= number_format($hcPhi->so_tien_nop, 0, ',', '.') . ' VNĐ' ?></td>
                        <td>
                            <?php
                            // Tìm thông tin người thu từ bảng user
                            $user = NhanVien::findOne($hcPhi->nguoi_thu);
                            echo $user ? Html::encode($user->ho_ten) : 'Không xác định';
                            ?>
                        </td>
                    </tr>
                <?php
                $index++;
                endforeach; ?>
            </tbody>
        </table>
        <?php CardWidget::end() ?>
    <?php endif; ?>
</div>
