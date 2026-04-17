<?php

use app\custom\CustomFunc;
use app\modules\hocvien\models\DangKyHv;

?>
<!-- Thông tin học viên -->
<div class="row">
    <div class="col-xl-7 col-md-12">
        <div class="card custom-card">
            <div class="card-header custom-card-header rounded-bottom-0">
                <h6 class="card-title mb-0 text-center" style="color: red;">Thông tin học viên</h6>
            </div>
            <div class="card-body">
                <div class="skill-tags">
                    <p>
                        <strong>Tên học viên:</strong> <?= $model->ho_ten ?>
                        <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                        <strong>Giới tính:</strong> <?= $model->gioi_tinh == 1 ? 'Nam' : 'Nữ' ?>
                        <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                        <strong>Ngày sinh:</strong> <?= $model->getNgaySinh() ?>
                    </p>
                    <p>
                        <strong>Số ĐT:</strong> <?= $model->so_dien_thoai ?>
                        <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                        <strong>Địa chỉ:</strong> <?= $model->diaChi ?>
                    </p>
                    <p><strong>Số CCCD:</strong> <?= $model->so_cccd ?>
                        <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                        <strong>Ngày hết hạn CCCD:</strong> <?= $model->getNgayHetHanCccd() ?>
                    </p>
                    <p>
                        <strong>Nơi đăng ký:</strong> <?= $model->getLabelNoiDangKy() ?>
                        <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                        <strong>NV tiếp nhận:</strong> <?= $model->nguoiTao->ho_ten ?>
                    </p>
                    <p>
                        <strong>Ngày đăng ký:</strong> <?= CustomFunc::convertYMDHISToDMYHI($model->thoi_gian_tao) ?><strong> <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Nhận hồ sơ:</strong> <?= CustomFunc::convertYMDHISToDMYHI($model->thoi_gian_hoan_thanh_ho_so) ?>
                    </p>

                    <?php

                    use app\modules\user\models\User;
                    use yii\helpers\Html;

                    if ($model->id_lien_ket > 0) { ?>
                        <p>
                            <strong><i class="fa fa-chain"></i> Liên kết:</strong> <?= $model->lienKet ? $model->lienKet->ten_lien_ket : '-' ?>
                            <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            <strong>Ngày LK:</strong> <?= $model->ngay_lien_ket ? CustomFunc::convertYMDHISToDMYHI($model->ngay_lien_ket) : '-' ?>
                            <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            <strong>NV LK:</strong> <?= $model->nguoiLienKet ? $model->nguoiLienKet->ho_ten : '-' ?>
                        </p>
                    <?php } ?>

                    <?php if ($model->id_nhan_ho_so_ho > 0) { ?>
                        <p>
                            <strong><i class="mdi mdi-account-star"></i> Nhận hồ sơ hộ:</strong> <?= $model->nhanHoSoHo ? $model->nhanHoSoHo->ten_don_vi : '-' ?>
                            <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            <strong>Ngày nhập TH:</strong> <?= $model->ngay_nhap_ho_so_ho ? CustomFunc::convertYMDHISToDMYHI($model->ngay_nhap_ho_so_ho) : '-' ?>
                            <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            <strong>NV nhập TH:</strong> <?= $model->nguoiNhapNhanHoSoHo ? $model->nguoiNhapNhanHoSoHo->ho_ten : '-' ?>
                        </p>
                    <?php } ?>

                    <p>
                        <strong>Đã nhận áo:</strong> <?= $model->da_nhan_ao ? '<i class="ion-checkmark-round text-primary"></i> Có' : '<i class="ion-close-round" data-bs-toggle="tooltip" aria-label="ion-close-round" data-bs-original-title="ion-close-round"></i> Không' ?><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                        <strong>Size:</strong> <?= $model->size ? $model->size : '-' ?><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> <strong>Ngày nhận:</strong> <?= $model->ngay_nhan_ao ? CustomFunc::convertYMDToDMY($model->ngay_nhan_ao) : '-' ?> <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                        <strong>NV giao:</strong> <?= $model->nguoiGiaoAo ? $model->nguoiGiaoAo->ho_ten : '-' ?>
                    </p>
                    <p>
                        <strong>Đã nhận tài liệu:</strong> <?= $model->da_nhan_tai_lieu ? '<i class="ion-checkmark-round text-primary"></i> Có' : '<i class="ion-close-round" data-bs-toggle="tooltip" aria-label="ion-close-round" data-bs-original-title="ion-close-round"></i> Không' ?><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                        <strong>Ngày nhận:</strong> <?= $model->ngay_nhan_tai_lieu ? CustomFunc::convertYMDToDMY($model->ngay_nhan_tai_lieu) : '-' ?> <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                        <strong>NV giao:</strong> <?= $model->nguoiGiaoTaiLieu ? $model->nguoiGiaoTaiLieu->ho_ten : '-' ?>
                    </p>
                    <p><strong>Ghi chú thêm:</strong> <?= $model->ghi_chu ?></p>

                    <?php if ($model->huy_ho_so) { ?>
                        <p><strong>Trạng thái:</strong> Đã hủy hồ sơ
                            <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            <strong>Thời gian hủy:</strong> <?= CustomFunc::convertYMDHISToDMYHI($model->thoi_gian_huy_ho_so) ?>
                        </p>
                        <p><strong>Lý do hủy:</strong> <?= DangKyHv::getDmLyDoHuyLablel($model->loai_ly_do) ?>
                            <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            <strong>Lệ phí:</strong> <?= number_format($model->le_phi) ?>
                        </p>
                        <p><strong>Ghi chú hủy:</strong> <?= $model->ly_do_huy_ho_so ?></p>

                        <?= Html::button('<i class="fa fa-print"></i> In Phiếu hủy', [
                            'class' => 'btn btn-sm btn-default',
                            'onclick' => 'InPhieuHuyHoSo(' . $model->id . ')'
                        ]) ?>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-5 col-md-12">

        <div class="card custom-card">
            <div class="card-header custom-card-header rounded-bottom-0">
                <h6 class="card-title mb-0 text-center" style="color: red;">Thông tin học phí</h6>
            </div>
            <div class="card-body">
                <div class="skill-tags">
                    <p><strong>Tên khóa học:</strong>
                        <?php if ($model->id_khoa_hoc == null): ?>
                            Học viên chưa được sắp khóa học
                        <?php else: ?>
                            <?= $model->khoaHoc->ten_khoa_hoc ?>
                        <?php endif; ?>
                    </p>
                    <p><strong>Hạng đào tạo:</strong> <?= $model->hangDaoTao->ten_hang ?></p>

                    <!-- <p><strong>HỌC PHÍ:</strong> <strong><?= number_format($model->hocPhi->hoc_phi) ?></strong></p> -->
                    <p>
                        <strong>HỌC PHÍ:</strong> <strong><?= number_format($model->tienHocPhi) ?></strong>
                        <?= $model->thayDoiHangs ? Html::a('<i class="fas fa-external-link-alt"></i>', '/hocvien/dang-ky-hv/view-thay-doi-hang?id=' . $model->id, ['role' => 'modal-remote-2', 'title' => 'Xem quá trình thay đổi hạng', 'style' => 'float:none'])  : '' ?>
                    </p>

                    <!-- 
        				<p>Học phí thực tế: <?= number_format($model->tienHocPhi) ?></p>
        				<p>Học phí thực tế endtime: <?= number_format($model->getTienHocPhiTheoThoiGian('2025-05-23 15:49:45')) ?></p>
        				
        				 -->



                    <p><strong>CHIẾT KHẤU:</strong> <strong><?= number_format($model->tienChietKhau) ?></strong></p>
                    <p><strong><strong>ĐÃ NỘP:</strong> <?= number_format($model->tienDaNop) ?></strong></p>
                    <p>- Thu tiền: <?= number_format($model->tienDaNopDuong) ?></p>
                    <p>- Chi tiền: <span style="color:red"><?= number_format($model->tienDaNopAm) ?></span></p>

                    <p><strong>CÒN LẠI:</strong> <strong><?= number_format($model->tienChuaThanhToan) ?></strong></p>
                </div>
            </div>
            <!-- <div class="card-header custom-card-header rounded-bottom-0">
                    <h6 class="card-title mb-0 text-center" style="color: red;">Thông tin kiểm duyệt</h6>
                </div>
                <div class="card-body">
                    <div class="skill-tags">
                    <?php if ($model->trang_thai_duyet === 'DA_DUYET'): ?>
                             <span class="text-success">Đã duyệt</span>
                                <?php elseif ($model->trang_thai === 'KHONG_DUYET'): ?>
                             <span class="text-danger">Không duyệt</span>
                    <?php else: ?>
                         <span class="text-warning">Chờ duyệt</span>
                    <?php endif; ?>
                    </div>
                </div> -->
        </div>

    </div>



    <!-- nộp học phí -->
    <div class="col-xl-12 col-md-12">
        <?= $this->render('hoc_phi', ['model' => $model]) ?>
    </div>
    <div class="col-xl-12 col-md-12" style="text-align: right;margin-bottom:20px">
        <?php
        $user = User::getCurrentUser();
        // only show 'payment' if user chung co so
        ?>
        <?php /* ($model->noi_dang_ky == $user->noi_dang_ky || $user->superadmin) ? Html::a('<i class="fas fa-dollar-sign"></i> Đóng học phí', '/hocvien/dang-ky-hv/create2?id='.$model->id, [
                'title' => 'Đóng học phí',
                'role' => 'modal-remote',
                'class' => 'btn btn-warning', 
                'data-bs-placement' => 'top',
                'data-bs-toggle' => 'tooltip',
                'style'=>'color:white'
            ]) : '' */ ?>
        <?= Html::a('<i class="fas fa-dollar-sign"></i> Đóng học phí', '/hocvien/dang-ky-hv/create2?id=' . $model->id, [
            'title' => 'Đóng học phí',
            'role' => 'modal-remote',
            'class' => 'btn btn-warning',
            'data-bs-placement' => 'top',
            'data-bs-toggle' => 'tooltip',
            'style' => 'color:white;float:right'
        ]) ?>
    </div>

</div>