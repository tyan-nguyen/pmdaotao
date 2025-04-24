<?php
use yii\helpers\Html;
use app\modules\nhanvien\models\NhanVien;
use app\modules\hocvien\models\NopHocPhi;
use app\modules\hocvien\models\HocVien;
use app\modules\hocvien\models\HocPhi;
use app\modules\hocvien\models\KhoaHoc;
use app\widgets\CardWidget;
use app\modules\user\models\User;
use app\custom\CustomFunc;


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

<?php if (empty($hocPhiKhoaHoc)){?>
 <?php CardWidget::begin(['title'=>'Chi tiết nộp học phí']) ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Số phiếu</th>
                    <th>Loại</th>
                    <th>Số tiền</th>
                    <th>Chiết khấu</th>
                    <th>Còn lại</th>
                    <th>Ngày nộp</th>
                    <th>Người thu</th>
                    <th>Ghi chú</th>
                    <th><i class="fas fa-print"></i></th>
                    <th></th>
                    <!-- <th>Biên lai</th> -->
                </tr>
            </thead>
            <tbody>
                <?php
                $index = 1;
                foreach ($hocPhi as $hcPhi): ?>
                    <tr <?= ($hcPhi->loai_phieu==NopHocPhi::PHIEUCHILABEL)?'class="tr-red"':'' ?> >
                        <td><?= $index ?></td>
                        <td><?= CustomFunc::fillNumber($hcPhi->ma_so_phieu) ?></td>
                        <td><?= $hcPhi->getLoaiNop() ?> (<?= $hcPhi->hinh_thuc_thanh_toan ?>)</td>
                        
                        <td><?= number_format($hcPhi->so_tien_nop, 0, ',', '.') ?></td>
                        <td><?= number_format($hcPhi->chiet_khau, 0, ',', '.') ?></td>
                        <td><?= number_format($hcPhi->so_tien_con_lai, 0, ',', '.') ?></td>
                        <!-- <td><?= Yii::$app->formatter->asDate($hcPhi->ngay_nop, 'php:d/m/Y') ?></td> -->
                        <td><?= CustomFunc::convertYMDHISToDMYHI($hcPhi->thoi_gian_tao) ?></td>
                        
                        <td>
                            <?php
                            // Tìm thông tin người thu từ bảng user
                            $user = User::findOne($hcPhi->nguoi_thu);
                            echo $user ? Html::encode($user->username) : 'Không xác định';
                            ?>
                        </td>
                        
                        <td><?= $hcPhi->ghi_chu ?></td>
                        
                        <td><span id="soLanIn<?= $hcPhi->id ?>"><?= $hcPhi->so_lan_in_phieu ?></span></td>
                        <td>
                        	<div class="btn-group">
                              <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                In
                              </button>
                              <ul class="dropdown-menu">
                                <li><?= Html::button('<i class="fa fa-print"> </i> Xem trước (bản nháp)', ['class' => 'btn btn-default', 'style'=>'width:100%', 'onclick' => 'InPhieuThu('.$hcPhi->id.',1)']) ?></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><?= Html::button('<i class="fa fa-print"> </i> In Phiếu (Ký tên đóng dấu)', ['class' => 'btn btn-success', 'style'=>'width:100%', 'onclick' => 'InPhieuThu('.$hcPhi->id.',0)']) ?></li>
                              </ul>
                            </div>
                        </td>
                        <!-- <td>
                            <?= Html::a('<i class="fas fa-eye"> </i>', 
                                             ['/hocvien/hoc-vien/bien-lai','idHP' => $hcPhi->id],
                                                [
                                                   'class' => 'btn ripple btn-primary btn-sm',
                                                   'title' => 'Xem biên lai',
                                                   'style' => 'color: white;',
                                                   'role' => 'modal-remote-2',
                                                ]
                            ) ?>
                        </td>-->
                    </tr>
                <?php
                $index++;
                endforeach; ?>
            </tbody>
        </table>
        <?php CardWidget::end() ?>
<?php } ?>