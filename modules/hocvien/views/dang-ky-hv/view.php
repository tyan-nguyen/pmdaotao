<?php
use yii\helpers\Html;
use app\widgets\FileDisplayWidget;
use app\modules\hocvien\models\HocVien;
use app\custom\CustomFunc;
use app\modules\user\models\User;

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
                        <p><strong>Tên học viên:</strong> <?= $model->ho_ten ?><strong>
                        <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                        Số ĐT:</strong> <?= $model->so_dien_thoai ?></p>                        
                        <p><strong>Giới tính:</strong> <?= $model->gioi_tinh == 1 ? 'Nam' : 'Nữ' ?>
                        <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                        <strong>Ngày sinh:</strong> <?= $model->getNgaySinh() ?></p>
                        <p><strong>Địa chỉ:</strong> <?= $model->dia_chi ?></p>
                        <p><strong>Số CCCD:</strong> <?= $model->so_cccd ?>
                        <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                        <strong>Ngày hết hạn CCCD:</strong> <?= $model->getNgayHetHanCccd()?></p>
                        <p><strong>Nơi đăng ký:</strong> <?= $model->getLabelNoiDangKy() ?></p>
                        <p><strong>Đã nhận đồng phục:</strong> <?= $model->da_nhan_ao?'<i class="ion-checkmark-round text-primary"></i> Có':'<i class="ion-close-round" data-bs-toggle="tooltip" aria-label="ion-close-round" data-bs-original-title="ion-close-round"></i> Không' ?><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> <strong>Size:</strong> <?= $model->size ?><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> <strong>Ngày nhận:</strong> <?= CustomFunc::convertYMDToDMY($model->ngay_nhan_ao) ?></p>
                        <p><strong>Ngày đăng ký:</strong> <?= CustomFunc::convertYMDHISToDMYHI($model->thoi_gian_tao) ?><strong> <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Nhận hồ sơ:</strong> <?= CustomFunc::convertYMDHISToDMYHI($model->thoi_gian_hoan_thanh_ho_so) ?></p>    
                        <p><strong>Ghi chú thêm:</strong> <?= $model->ghi_chu ?></p>
                    </div>
                </div>
            </div>
         </div>
         <div class="col-xl-6 col-md-12">
            
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
                         
        				<p><strong>HỌC PHÍ:</strong> <strong><?= number_format($model->hocPhi->hoc_phi) ?></strong></p>
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
        <div class="col-md-12" style="text-align: right;margin-bottom:20px">
            <?php 
                $user = User::getCurrentUser();
                // only show 'payment' if user chung co so
            ?>
            <?= ($model->noi_dang_ky == $user->noi_dang_ky || $user->superadmin) ? Html::a('<i class="fas fa-dollar-sign"></i> Đóng học phí', '/hocvien/dang-ky-hv/create2?id='.$model->id, [
                'title' => 'Đóng học phí',
                'role' => 'modal-remote',
                'class' => 'btn btn-warning', 
                'data-bs-placement' => 'top',
                'data-bs-toggle' => 'tooltip',
                'style'=>'color:white'
            ]) : '' ?>
        </div>

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
                             'type'=>'ALL',
                             'doiTuong'=>Hocvien::MODEL_ID,
                             'idDoiTuong'=>$model->id,
                        ])?>
                        
                        
                        
                        
                        
                        
                        
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

