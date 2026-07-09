<?php

use yii\widgets\DetailView;
use app\widgets\FileDisplayWidget;
use app\modules\hocvien\models\HocVien;
use app\widgets\KhoDisplayWidget;
use app\custom\CustomFunc;
use app\modules\taisan\models\TaiSan;
use app\widgets\CardWidget;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\HvHocVien */
?>
<div class="hv-hoc-vien-view">

    <div class="row">
        <div class="col-xl-3 col-md-12">
            <div class="card custom-card">
                <div class="card-header custom-card-header rounded-bottom-0">
                    <div>
                        <h6 class="card-title mb-0 text-center" style="color: red;">Thông tin tài sản:</h6>
                    </div>
                </div>
                <div class="card-body">
                    <div class="skill-tags">
                        <?= $model->qrLink ? ('<p style="text-align:center;">' . Html::img($model->qrLink, ['style' => 'width:100px;height:100px;']) . '</p>') : '' ?>
                        <p><strong>Mã tài sản:</strong> <?= $model->ma_tai_san ?></p>
                        <p><strong>Tên tài sản:</strong> <?= $model->ten_tai_san ?></p>
                        <p>
                            <strong>Loại tài sản:</strong> <?= $model->loaiTaiSan->ten ?>
                        </p>
                        <p>
                            <strong>Danh mục tài sản:</strong> <?= $model->danhMuc->ten ?>
                        </p>
                        <p><strong>Model:</strong> <?= $model->model ?></p>
                        <p><strong>Serial:</strong> <?= $model->serial ?></p>
                        <p><strong>Trạng thái:</strong> <?= $model->trang_thai ?></p>
                        <p><strong>Ghi chú:</strong> <?= $model->ghi_chu ?></p>
                    </div>
                </div>
            </div>
            <div class="card custom-card">
                <div class="card-header custom-card-header rounded-bottom-0">
                    <div>
                        <h6 class="card-title mb-0 " style="color: red;">Thông tin sử dụng: </h6>
                    </div>
                </div>
                <div class="card-body">
                    <div class="skill-tags">
                        <p><strong>Mục đích sử dụng :</strong> <?= $model->muc_dich_su_dung ?></p>
                        <p><strong>Ngày đưa vào sử dụng: </strong><?= CustomFunc::convertYMDToDMY($model->ngay_dua_vao_su_dung) ?></p>
                        <p><strong>Người chịu trách nhiệm:</strong> <?= $model->nguoiChiuTrachNhiem ? $model->nguoiChiuTrachNhiem->ho_ten : '' ?></p>
                        <p><strong>Phòng ban:</strong> <?= $model->phongBan ? $model->phongBan->ten_phong_ban : '' ?></p>
                        <p><strong>Vị trí:</strong> <?= $model->vi_tri_id ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-9 col-md-12">
            <div class="card custom-card">
                <div class="card-header custom-card-header rounded-bottom-0">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link show active " id="add-document-tab" data-bs-toggle="tab" href="#add-document" role="tab" aria-controls="add-student" aria-selected="false" style="color: blue;"><i class="fa fa-file"></i> Thông tin chi tiết</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="manage-tab" data-bs-toggle="tab" href="#manage-div" role="tab" aria-controls="manage-div" aria-selected="false" style="color: blue;"><i class="fa fa-list-ul"></i> Thông tin quản lý</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="history-tab" data-bs-toggle="tab" href="#history-div" role="tab" aria-controls="history-div" aria-selected="false" style="color: blue;"><i class="fa fa-history"></i> Lịch sử</a>
                        </li>

                        <!-- <li class="nav-item" role="presentation">
                        <a class="nav-link " id="add-timetable-tab" data-bs-toggle="tab" href="#add-timetable" role="tab" aria-controls="add-student" aria-selected="false"style="color: blue;"><i class="fa fa-calendar"></i> Lịch học</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link " id="exsche-tab" data-bs-toggle="tab" href="#add-exsche" role="tab" aria-controls="add-exsche" aria-selected="false"style="color: blue;"><i class="fa fa-table"></i> Lịch thi</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="list-tab" data-bs-toggle="tab" href="#list" role="tab" aria-controls="list" aria-selected="true"style="color: blue;"><i class="fa fa-address-card"></i>  Kết quả thi</a>
                    </li>-->

                    </ul>
                </div>
                <div class="card-body">
                    <div class="skill-tags">
                        <div class="tab-content" id="myTabContent">
                            <!-- Nội dung Kết quả thi -->
                            <div class="tab-pane fade " id="list" role="tabpanel" aria-labelledby="list-tab">
                                <!-- Nội dung hiển thị khi click vào "Kết quả thi" -->
                                <?php // $this->render('ket_qua_thi', ['model' => $model]) 
                                ?>
                            </div>

                            <!-- Thông tin lịch sử -->
                            <div class="tab-pane fade" id="manage-div" role="tabpanel" aria-labelledby="manage-tab">

                                <!-- Thông tin file -->
                                <div class="col-xl-12 col-md-12">
                                    <div class="card custom-card">
                                        <div class="card-header custom-card-header rounded-bottom-0">
                                            <div>
                                                <h6 class="card-title mb-0 " style="color: red;">Thông tin quản lý: </h6>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="skill-tags">
                                                <p><strong>Nhà cung cấp :</strong> <?= $model->nhaCungCap ? $model->nhaCungCap->ten : '' ?></p>
                                                <p><strong>Số tiền: </strong> <?= number_format($model->so_tien) ?></p>
                                                <p><strong>Số hóa đơn:</strong> <?= $model->so_hoa_don ?></p>
                                                <p><strong>Số hợp đồng:</strong> <?= $model->so_hop_dong ?></p>
                                                <p><strong>Ngày mua: </strong><?= CustomFunc::convertYMDToDMY($model->ngay_mua) ?></p>
                                                <p><strong>Thời hạn bảo hành: </strong><?= CustomFunc::convertYMDToDMY($model->thoi_han_bao_hanh) ?></p>
                                                <p><strong>Ghi chú bảo hành: </strong><?= CustomFunc::convertYMDToDMY($model->ghi_chu_bao_hanh) ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-md-12">
                                    <div class="card custom-card">
                                        <div class="card-header custom-card-header rounded-bottom-0">
                                            <div>
                                                <h6 class="card-title mb-0 text-center" style="color: red;">File đính kèm</h6>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="skill-tags">

                                                <?= FileDisplayWidget::widget([
                                                    'type' => 'ALL',
                                                    'doiTuong' => TaiSan::MODEL_ID,
                                                    'idDoiTuong' => $model->id,
                                                ]) ?>


                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>

                            <!-- Thông tin lịch sử -->
                            <div class="tab-pane fade" id="history-div" role="tabpanel" aria-labelledby="history-tab">

                                <!-- Thông tin file -->
                                <div class="col-xl-12 col-md-12">
                                    <?= $this->render('view_item_history', ['model' => $model]) ?>
                                </div>

                            </div>

                            <!-- Nội dung Lịch học -->
                            <div class="tab-pane fade " id="add-timetable" role="tabpanel" aria-labelledby="add-timetable-tab">
                                <!-- Nội dung hiển thị khi click vào "Lịch học " -->
                                <?php // $this->render('testTKB',['modelHV'=>$model, 'weeks' => $weeks]) 
                                ?>
                            </div>

                            <!-- Nội dung Lịch thi -->
                            <div class="tab-pane fade " id="add-exsche" role="tabpanel" aria-labelledby="add-exsche-tab">
                                <!-- Nội dung hiển thị khi click vào "Lịch thi " -->
                                <?php // $this->render('_exsche',['model'=>$model]) 
                                ?>
                            </div>

                            <!-- Nội dung Tài liệu khóa học -->
                            <div class="tab-pane fade show active" id="add-document" role="tabpanel" aria-labelledby="add-document-tab">

                                <div class="col-xl-12 col-md-12">
                                    <div class="card custom-card">
                                        <div class="card-header custom-card-header rounded-bottom-0">
                                            <div>
                                                <h6 class="card-title mb-0 text-center" style="color: red;">Hình ảnh</h6>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="skill-tags">

                                                <?= FileDisplayWidget::widget([
                                                    'type' => 'IMAGE',
                                                    'doiTuong' => TaiSan::MODEL_ID,
                                                    'idDoiTuong' => $model->id,
                                                ]) ?>


                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php /* ?>
                                <?php
                                if (in_array($model->id_hang, HocVien::LOAI_HOC_VIEN_XE_MAY)) {
                                ?>

                                    <?php
                                    CardWidget::begin([
                                        'title' => 'Lịch sử thu hộ',
                                    ]);
                                    ?>

                                    <table class="table table-bordered table-responsive" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th>Loại thu</th>
                                                <th>Ngày đóng</th>
                                                <th>Số tiền</th>
                                                <th>Hình thức</th>
                                                <th>Người thu</th>
                                                <th>Ghi chú</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($model->dongTienLePhi != null) {
                                                $stt = 0;
                                                foreach ($model->dongTienLePhi as $tienLePhi) {
                                                    $stt++;
                                            ?>
                                                    <tr>
                                                        <td><?= $stt ?></td>
                                                        <td><?= $tienLePhi['type'] === 'ThuLanDau' ? 'Thu kèm học phí' : 'Thu hóa đơn lẻ' ?></td>
                                                        <td><?= $tienLePhi['thoi_gian'] ?></td>
                                                        <td><?= number_format($tienLePhi['so_tien']) ?></td>
                                                        <td><?= $tienLePhi['hinh_thuc'] ?></td>
                                                        <td><?= $tienLePhi['nguoi_thu'] ?></td>
                                                        <td><?= $tienLePhi['ghi_chu'] ?></td>
                                                    </tr>
                                                <?php
                                                }
                                            } else {
                                                ?>
                                                <tr>
                                                    <td colspan="7" class="text-center">Chưa có dữ liệu</td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>

                                    <?php
                                    CardWidget::end();
                                    ?>

                                    <?php
                                    CardWidget::begin([
                                        'title' => 'Lịch sử thi',
                                    ]);
                                    ?>

                                    <table class="table table-bordered table-responsive" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th>Kỳ thi</th>
                                                <th>SBD</th>
                                                <th>Họ tên</th>
                                                <th>Ngày sinh</th>
                                                <th>Số CMT</th>
                                                <th>Ghi chú</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $stt = 0;
                                            if ($model->fileThiXeMayContents != null) {
                                                foreach ($model->fileThiXeMayContents as $fileThiXeMayContent) {
                                                    $stt++;
                                            ?>
                                                    <tr>
                                                        <td><?= $stt ?></td>
                                                        <td><?= $fileThiXeMayContent->file->ten_khoa_thi ?></td>
                                                        <td><?= $fileThiXeMayContent->sbd ?></td>
                                                        <td><?= $fileThiXeMayContent->ho_ten ?></td>
                                                        <td><?= $fileThiXeMayContent->ngay_sinh ?></td>
                                                        <td><?= $fileThiXeMayContent->cccd ?></td>
                                                        <td><?= $fileThiXeMayContent->ghi_chu ?></td>
                                                    </tr>
                                                <?php
                                                }
                                            } else {
                                                ?>
                                                <tr>
                                                    <td colspan="7" class="text-center">Chưa có dữ liệu</td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>

                                    <?php
                                    CardWidget::end();
                                    ?>
                                <?php } ?>

                                <?= FileDisplayWidget::widget([
                                    'type' => 'ALL',
                                    'doiTuong' => HocVien::MODEL_ID,
                                    'idDoiTuong' => $model->id,
                                ]) ?>

                                <?= KhoDisplayWidget::widget([
                                    'doiTuong' => HocVien::MODEL_ID,
                                    'idDoiTuong' => $model->id
                                ]) ?>

                                <?php */ ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>