<?php
use yii\helpers\Html;
use app\widgets\FileDisplayWidget;
use app\modules\hocvien\models\HocVien;

/* @var $this yii\web\View */
/* @var $model app\models\HvHocVien */
?>
<div class="hv-hoc-vien-view" id="hvContent">

    <div class="row">
        <!-- Thông tin học viên -->
        <div class="col-xl-6 col-md-12">
            <div class="card custom-card">
                <div class="card-header custom-card-header rounded-bottom-0">
                    <h6 class="card-title mb-0 text-center" style="color: red;">Thông tin học viên</h6>
                </div>
                <div class="card-body">
                    <div class="skill-tags">
                        <p><strong>Tên học viên:</strong> <?= $model->ho_ten ?></p>
                        <p><strong>Số ĐT:</strong> <?= $model->so_dien_thoai ?></p>
                        <p><strong>Giới tính:</strong> <?= $model->gioi_tinh == 1 ? 'Nam' : 'Nữ' ?></p>
                        <p><strong>Ngày sinh:</strong> <?= $model->getNgaySinh() ?></p>
                        <p><strong>Địa chỉ:</strong> <?= $model->diaChi ?></p>
                        <p><strong>Số CCCD:</strong> <?= $model->so_cccd ?></p>
                        <p><strong>Nơi đăng ký:</strong> <?= $model->getLabelNoiDangKy() ?></p>
                        <p><strong>Có xuất hóa đơn thuế:</strong> <?= $model->co_ho_so_thue?'<i class="ion-checkmark-round text-primary" data-bs-toggle="tooltip" aria-label="ion-checkmark-round" data-bs-original-title="ion-checkmark-round"></i> Có':'<i class="ion-close-round" data-bs-toggle="tooltip" aria-label="ion-close-round" data-bs-original-title="ion-close-round"></i> Không' ?></p>
                        <p><strong>Ghi chú:</strong> <?= $model->ghi_chu ?></p>
                    </div>
                </div>
            </div>
            
        </div>
        
        <!-- Thông tin học viên -->
        <div class="col-xl-6 col-md-12">
            
            <div class="card custom-card">
                <div class="card-header custom-card-header rounded-bottom-0">
                    <h6 class="card-title mb-0 text-center" style="color: red;">Thông tin khóa học</h6>
                </div>
                <div class="card-body">
                    <div class="skill-tags">
                        <p><strong>Tên khóa học:</strong> 
                            <?php if ($model->id_khoa_hoc === null): ?>
                                Học viên chưa được sắp khóa học
                            <?php else: ?>
                                <?= $model->khoaHoc->ten_khoa_hoc ?>
                            <?php endif; ?>
                        </p>
                        <p><strong>Hạng đào tạo:</strong> <?= $model->hangDaoTao->ten_hang ?></p>
        				<p><strong>HỌC PHÍ:</strong> <strong><?= number_format($model->tienHocPhi) ?></strong></p>
        				<p><strong>CHIẾT KHẤU:</strong> <strong><?= number_format($model->tienChietKhau) ?></strong></p>
        				<p><strong><strong>ĐÃ NỘP:</strong> <?= number_format($model->tienDaNop) ?></strong></p>
        				<p>- Thu tiền: <?= number_format($model->tienDaNopDuong) ?></p>
        				<p>- Chi tiền: <span style="color:red"><?= number_format($model->tienDaNopAm) ?></span></p>
        				
        				<p><strong>CÒN LẠI:</strong> <strong><?= number_format($model->tienChuaThanhToan) ?></strong></p>
                    </div>
                </div>
              
            </div>
            
        </div>

        <!-- Thông tin khóa học -->
        <div class="col-xl-12 col-md-12">
        
                <?php /* FileDisplayWidget::widget([
                     'type'=>'ALL',
                     'doiTuong'=>Hocvien::MODEL_ID,
                     'idDoiTuong'=>$model->id,
                ]) */ ?>
                
                <?= $this->render('hoc_phi', ['model' => $model]) ?>
        
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
                <?= Html::a('<i class="fas fa-dollar-sign"></i> Đóng học phí', '/hocvien/dang-ky-hv/create2?id='.$model->id, [
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
    </div>
    
</div>
<script>

function InPhieuThu(id,nhap) {
    $.ajax({
        type: 'POST',
        url: '/hocvien/dang-ky-hv/get-phieu-in-ajax?id=' + id + '&type=phieuthu&' + '&nhap=' + nhap,
        success: function (data) {
            if (data.status === 'success') {
                $('#print').html(data.content);
                //printPhieuXuat(); // Gọi hàm in phiếu
				printPhieu();
                // Khi in xong, cập nhật số lần in
                if(nhap == 0){//in thật
                    setTimeout(function() {
                        updatePrintCount(id);
                    }, 1000); // Đợi 1 giây sau khi in để cập nhật
                }
            } else {
                alert('Không thể tải phiếu!');
            }
        },
        error: function () {
            alert('Đã xảy ra lỗi.');
        }
    });
}

// Hàm cập nhật số lần in
function updatePrintCount(id) {
    $.ajax({
        type: 'POST',
        url: '/hocvien/dang-ky-hv/update-print-count?id='+id,
        success: function (response) {
            if (response.success) {
                $('#soLanIn'+id).text(response.so_lan_in); // Cập nhật số lần in
            } else {
                alert('Cập nhật số lần in thất bại!');
            }
        },
        error: function () {
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
</script>

