<?php
use yii\helpers\Html;
use app\widgets\FileDisplayWidget;
use app\modules\thuexe\models\PhieuThueXe;
/* @var $this yii\web\View */
/* @var $model app\modules\thuexe\models\PhieuThueXe */
?>

<div class="phieu-thue-xe-view">
  <div class="row">
   <div class="col-md-6"> 
    <div class="row">
        <!-- Thông tin phiếu thuê xe -->
        <div class="col-xl-12 col-md-12 mb-3">
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

        <div class="col-xl-12 col-md-12 mb-3">
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
                                 <td>
                                   <?php if ($model->loaiHinhThue->loai_hinh_thue === 'Buổi '): ?>
                                   <?= Html::encode($model->loaiHinhThue->loai_hinh_thue) ?> 
                                        | 
                                   <?= !empty($model->buoi) ? Html::encode($model->buoi) : 'Trống' ?>
                                     <?php else: ?>
                                       <?= Html::encode($model->loaiHinhThue->loai_hinh_thue) ?>
                                     <?php endif; ?>
                                 </td>
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
            <?= Html::button('<i class="fa fa-print"> </i> In Phiếu Thuê Xe', ['class' => 'btn btn-success btn-lg', 'onclick' => 'InPhieuThueXe()']) ?>
        </div>

        <!-- Phần tử ẩn chứa nội dung phiếu -->
        <div style="display:none">
            <div id="print"></div>
        </div>
    </div>
  </div>
  <div class="col-md-6">
    	<div class="card custom-card">
            <div class="card-header custom-card-header rounded-bottom-0">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="tabFile-tab" data-bs-toggle="tab" href="#tabFile" role="tab" aria-controls="tabFile" aria-selected="false"style="color: blue;"><i class="fa fa-folder"></i> Lưu trữ </a>
                    </li>
                </ul>
			</div>
           <div class="card-body">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active p-1" id="tabFile" role="tabpanel" aria-labelledby="list-tab">
                       <?= FileDisplayWidget::widget([
                            'type'=>'LOAIHOSO',
                            'doiTuong'=>PhieuThueXe::MODEL_ID,
                            'idDoiTuong'=>$model->id,
                        ])?>
                    </div>
                </div>
          </div>
        </div>   
   
  </div>
</div>
</div>

<script>
function InPhieuThueXe() {
    var trangThai = '<?= $model->trang_thai ?>';

    if ((trangThai !== 'Đã duyệt') && (trangThai !== 'Đã trả')){
        alert('Không thể in phiếu! Phiếu chưa được duyệt.');
        return;
    }

    $.ajax({
        type: 'POST',
        url: '/thuexe/phieu-thue-xe/get-phieu-in-ajax?id=' + <?= $model->id ?> + '&type=phieuthuexe',
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


</script>


