<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\thuexe\models\PhieuThueXe */
?>

<div class="phieu-thue-xe-view">
    <div class="row">
        <!-- Thông tin phiếu thuê xe -->
        <div class="col-xl-6 col-md-12 mb-3">
            <div class="card custom-card shadow-sm border-light">
                <div class="card-header bg-warning text-white rounded-top">
                    <h6 class="card-title mb-0 text-center "style="color: white;">Thông tin người thuê</h6>
                </div>
                <div class="card-body">
                <div class="skill-tags">
                   <table class="table table-bordered">
                      <tbody>
                         <?php if ($model->id_hoc_vien !== null): ?>
                            <tr>
                                <th style="width: 50%;">Họ tên học viên</th>
                                <td style="width: 50%;"><?= Html::encode($model->hocVien->ho_ten) ?></td>
                            </tr>
                            <tr>
                                <th style="width: 50%;">Địa chỉ</th>
                                <td style="width: 50%;"><?= Html::encode($model->hocVien->dia_chi) ?></td>
                            </tr>
                            <tr>
                                <th style="width: 50%;">Số CCCD</th>
                                <td style="width: 50%;"><?= Html::encode($model->hocVien->so_cccd) ?></td>
                            </tr>
                            <tr>
                               <th style="width: 50%;">Số điện thoại</th>
                               <td style="width: 50%;"><?= Html::encode($model->hocVien->so_dien_thoai) ?></td>
                            </tr>
                            <tr>
                               <th style="width: 50%;">Hạng đào tạo</th>
                               <td style="width: 50%;"><?= Html::encode($model->hocVien->hang->ten_hang) ?></td>
                            </tr>
                            <tr>
                               <th style="width: 50%;">Khóa học</th>
                               <td style="width: 50%;">
                                  <?= Html::encode($model->hocVien->khoaHoc ? $model->hocVien->khoaHoc->ten_khoa_hoc : 'Học viên chưa được sắp khóa học') ?>
                               </td>
                            </tr>
                            <?php else: ?>
                            <tr>
                               <th style="width: 50%;">Họ tên người thuê</th>
                               <td style="width: 50%;"><?= Html::encode($model->ho_ten_nguoi_thue) ?></td>
                            </tr>
                            <tr>
                               <th style="width: 50%;">Số CCCD người thuê</th>
                               <td style="width: 50%;"><?= Html::encode($model->so_cccd_nguoi_thue) ?></td>
                            </tr>
                            <tr>
                               <th style="width: 50%;">Địa chỉ người thuê</th>
                               <td style="width: 50%;"><?= Html::encode($model->dia_chi_nguoi_thue) ?></td>
                            </tr>
                            <tr>
                                <th style="width: 50%;">Số điện thoại người thuê</th>
                                <td style="width: 50%;"><?= Html::encode($model->so_dien_thoai_nguoi_thue) ?></td>
                           </tr>
                       <?php endif; ?>
                </tbody>
           </table>
           </div>

                </div>
            </div>
        </div>

        <div class="col-xl-6 col-md-12 mb-3">
            <div class="card custom-card shadow-sm border-light">
                <div class="card-header bg-success text-white rounded-top">
                    <h6 class="card-title mb-0 text-center" style="color: white;">Thông tin thuê xe</h6>
                </div>
                <div class="card-body">
                <div class="skill-tags">
                      <table class="table table-bordered">
                         <tbody>
                             <tr>
                                <th style="width: 50%;">Ngày thuê xe</th>
                                <td style="width: 50%;"><?= Html::encode(Yii::$app->formatter->asDate($model->ngay_thue_xe, 'php:d/m/Y')) ?></td>
                             </tr>
                             <tr>
                                <th>Xe thuê</th>
                                <td><?= Html::encode($model->xe->hieu_xe) ?></td>
                             </tr>
                             <tr>
                                <th>Loại hình thuê</th>
                                <td><?= Html::encode($model->loaiHinhThue->loai_hinh_thue) ?></td>
                             </tr>
                             <tr>
                               <th>Thời gian bắt đầu thuê</th>
                               <td><?= Html::encode(Yii::$app->formatter->asDatetime($model->thoi_gian_bat_dau_thue, 'php:d/m/Y | H:i:s')) ?></td>
                             </tr>
                             <tr>
                                <th>Thời gian trả xe</th>
                                <td><?= Html::encode(Yii::$app->formatter->asDatetime($model->thoi_gian_tra_xe_du_kien, 'php:d/m/Y | H:i:s')) ?></td>
                             </tr>
                             <tr>
                                <th>Chi phí thuê</th>
                                <td><?= Html::encode(Yii::$app->formatter->asDecimal($model->chi_phi_thue_du_kien, 0)) ?> VNĐ</td>
                             </tr>
                             <tr>
                                <th>Nhân viên cho thuê</th>
                                <td><?= Html::encode($model->nhanVien->ho_ten) ?></td>
                             </tr>
                             <tr>
                                <th>Nội dung thuê</th>
                                <td><?= Html::encode($model->noi_dung_thue) ?></td>
                             </tr>
                     </tbody>
                </table>
            </div>

                </div>
            </div>
        </div>

        <!-- Nút in phiếu -->
        <div class="col-12 text-center mt-3">
            <?= Html::button('<i class="fa fa-download"> </i> In Phiếu Thông Tin', ['class' => 'btn btn-success btn-lg', 'onclick' => 'InPhieuThongTin()']) ?>
        </div>

        <!-- Phần tử ẩn chứa nội dung phiếu -->
        <div style="display:none">
            <div id="print"></div>
        </div>
    </div>
</div>

<script>
function InPhieuThongTin() {
    var trangThai = '<?= $model->trang_thai ?>';

    if (trangThai !== 'Đã duyệt') {
        alert('Không thể in phiếu! Phiếu chưa được duyệt.');
        return;
    }

    $.ajax({
        type: 'POST',
        url: '/thuexe/phieu-thue-xe/get-phieu-in-ajax?id=' + <?= $model->id ?> + '&type=phieuthongtin',
        success: function (data) {
            if(data.status === 'success'){
                $('#print').html(data.content);
                printPhieuXuat();
            } else {
                alert('Không thể tải phiếu!');
            }
        },
        error: function () {
            alert('Đã xảy ra lỗi.');
        }
    });
}

function printPhieuXuat() {
    var printContents = document.getElementById('print').innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}
</script>
