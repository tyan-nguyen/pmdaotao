<?php

use yii\helpers\Html;
use app\widgets\FileDisplayWidget;
use app\modules\hocvien\models\HocVien;
use app\custom\CustomFunc;
use app\modules\user\models\User;
use app\modules\hocvien\models\DangKyHv;
use app\widgets\CardWidget;

/* @var $this yii\web\View */
/* @var $model app\models\HvHocVien */
?>
<div class="hv-hoc-vien-view" id="hvContent">

    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card custom-card">
                <div class="card-header custom-card-header rounded-bottom-0">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link show active " id="info-tab" data-bs-toggle="tab" href="#info-div" role="tab" aria-controls="info-div" aria-selected="false" style="color: blue;"><i class="fa fa-file"></i> Thông tin học viên</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="exam-tab" data-bs-toggle="tab" href="#exam-div" role="tab" aria-controls="exam-div" aria-selected="false" style="color: blue;"><i class="fa fa-retweet"></i> Thu hộ/lần thi <span style="font-weight: bold;">(<?= $model->soLanThi ?>) </span></a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="file-tab" data-bs-toggle="tab" href="#file-div" role="tab" aria-controls="file-div" aria-selected="false" style="color: blue;"><i class="fa fa-paperclip"></i> File đính kèm</a>
                        </li>
                    </ul>
                </div>

                <div class="card-body">
                    <div class="skill-tags">
                        <div class="tab-content" id="myTabContent">

                            <!-- thông tin học viên  -->
                            <div class="tab-pane fade show active" id="info-div" role="tabpanel" aria-labelledby="info-tab">

                                <?= $this->render('view_item_info', ['model' => $model]) ?>

                            </div>

                            <!-- Thông tin thu hộ/lần thi -->
                            <div class="tab-pane fade" id="exam-div" role="tabpanel" aria-labelledby="exam-tab">


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
                                            <th style="text-align: center;">Hình thức</th>
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
                                                    <td style="text-align: center;"><?= $tienLePhi['hinh_thuc'] ?></td>
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

                            </div>

                            <!-- Thông tin file -->
                            <div class="tab-pane fade" id="file-div" role="tabpanel" aria-labelledby="file-tab">

                                <!-- Thông tin file -->
                                <div class="col-xl-12 col-md-12">

                                    <div class="card custom-card">
                                        <div class="card-header custom-card-header rounded-bottom-0">
                                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link show active " id="add-document-tab" data-bs-toggle="tab" href="#add-document" role="tab" aria-controls="add-student" aria-selected="false" style="color: blue;"><i class="fa fa-file"></i> Hồ sơ học viên</a>
                                                </li>

                                            </ul>
                                        </div>
                                        <div class="card-body">
                                            <div class="skill-tags">
                                                <!-- Nội dung Tài liệu khóa học -->
                                                <div class="tab-pane fade show active" id="add-document" role="tabpanel" aria-labelledby="add-document-tab">

                                                    <?= FileDisplayWidget::widget([
                                                        'type' => 'ALL',
                                                        'doiTuong' => Hocvien::MODEL_ID,
                                                        'idDoiTuong' => $model->id,
                                                    ]) ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>


    </div>
    <p>
        <?php /* Html::button('<i class="fa fa-print"> </i> In Phiếu Thông Tin', ['class' => 'btn btn-success', 'onclick' => 'InPhieuThongTin()']) */ ?>
    </p>

    <?php /* ?>
       
       <?= Html::dropDownList('tuychonin',null, [
           1=>'In phiếu thu 100%',
           2=>'In phiếu thu 50%',
           3=>'In phiếu thu tùy chọn',
           
       ], ['id'=>'ddlTuyChonIn', 'style'=>'padding:8px']) ?>
       <div class="btn-group">
          <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            In phiếu thu
          </button>
          <ul class="dropdown-menu">
            <li><?= Html::button('<i class="fa fa-print"> </i> Xem trước', ['class' => 'btn btn-default', 'style'=>'width:100%', 'onclick' => 'InPhieuThongTin(1)']) ?></li>
            <li><hr class="dropdown-divider"></li>
            <li><?= Html::button('<i class="fa fa-print"> </i> In Phiếu', ['class' => 'btn btn-success', 'style'=>'width:100%', 'onclick' => 'InPhieuThongTin(0)']) ?></li>
          </ul>
        </div>
        
        <?php */ ?>

    <!-- <div class="row pull-right">
        	<div class="col-md-12">
                <?= Html::a('<i class="fas fa-dollar-sign"></i> Đóng học phí', '/hocvien/dang-ky-hv/create2?id=' . $model->id, [
                    'title' => 'Đóng học phí',
                    'role' => 'modal-remote',
                    'class' => 'btn btn-warning',
                    'data-bs-placement' => 'top',
                    'data-bs-toggle' => 'tooltip',
                ]) ?>
            </div>
        </div>-->

    <?php /* ?>
       <p style="margin-top:10px">Lần in: <strong id="soLanIn"><?= $model->so_lan_in_phieu ?? 0 ?></strong></p>
 <?php */ ?>



    <!-- Phần tử ẩn chứa nội dung phiếu -->
    <div style="display:none">
        <div id="print"></div>
    </div>
    <!-- Phần tử ẩn chứa nội dung phiếu -->
    <div style="display:none">
        <div id="printDoiHang"></div>
    </div>
</div>

</div>
<script>
    function InPhieuThu(id, nhap) {
        $.ajax({
            type: 'POST',
            url: '/hocvien/dang-ky-hv/get-phieu-in-ajax?id=' + id + '&type=phieuthu&' + '&nhap=' + nhap,
            success: function(data) {
                if (data.status === 'success') {
                    $('#print').html(data.content);
                    //printPhieuXuat(); // Gọi hàm in phiếu
                    printPhieu();
                    // Khi in xong, cập nhật số lần in
                    if (nhap == 0) { //in thật
                        setTimeout(function() {
                            updatePrintCount(id);
                        }, 1000); // Đợi 1 giây sau khi in để cập nhật
                    }
                } else {
                    alert('Không thể tải phiếu!');
                }
            },
            error: function() {
                alert('Đã xảy ra lỗi.');
            }
        });
    }

    // Hàm cập nhật số lần in
    function updatePrintCount(id) {
        $.ajax({
            type: 'POST',
            url: '/hocvien/dang-ky-hv/update-print-count?id=' + id,
            success: function(response) {
                if (response.success) {
                    $('#soLanIn' + id).text(response.so_lan_in); // Cập nhật số lần in
                } else {
                    alert('Cập nhật số lần in thất bại!');
                }
            },
            error: function() {
                alert('Lỗi kết nối server!');
            }
        });
    }


    function printPhieuXuat() {
        var printContents = document.getElementById('print').innerHTML;

        // Tạo iframe ẩn
        var iframe = document.createElement('iframe');
        iframe.style.position = 'absolute';
        iframe.style.width = '0px';
        iframe.style.height = '0px';
        iframe.style.border = 'none';

        // Thêm iframe vào body
        document.body.appendChild(iframe);

        // Ghi nội dung cần in vào iframe
        var doc = iframe.contentWindow.document;
        doc.open();
        doc.write(`
        <html>
            <head>
                <title>In phiếu</title>
                <style>
                    body { font-family: Arial, sans-serif; margin: 20px; }
                </style>
            </head>
            <body>
                ${printContents}
            </body>
        </html>
    `);
        doc.close();


        iframe.contentWindow.focus();
        iframe.contentWindow.print();

        // Xóa iframe 
        setTimeout(() => document.body.removeChild(iframe), 1000);
    }

    function InPhieuHuyHoSo(id) {
        $.ajax({
            type: 'POST',
            url: '/hocvien/bao-cao/rp-bien-ban-huy-ho-so-print?idhv=' + id,
            success: function(data) {
                if (data.status === 'success') {
                    $('#printDoiHang').html(data.content);
                    printPhieuDoiHang();
                } else {
                    alert('Không thể tải phiếu!');
                }
            },
            error: function() {
                alert('Đã xảy ra lỗi.');
            }
        });
    }
</script>