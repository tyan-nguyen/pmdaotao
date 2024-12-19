<?php
use yii\helpers\Html;

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
                        <p><strong>Giới tính:</strong> <?= $model->gioi_tinh == 1 ? 'Nam' : 'Nữ' ?></p>
                        <p><strong>Ngày sinh:</strong> <?= $model->getNgaySinh() ?></p>
                        <p><strong>Địa chỉ:</strong> <?= $model->dia_chi ?></p>
                        <p><strong>Số CCCD:</strong> <?= $model->so_cccd ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thông tin khóa học -->
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
        
                    </div>
                </div>
                <div class="card-header custom-card-header rounded-bottom-0">
                    <h6 class="card-title mb-0 text-center" style="color: red;">Thông tin kiểm duyệt</h6>
                </div>
                <div class="card-body">
                    <div class="skill-tags">
                        <p><strong>Trạng thái:</strong> <?= $model->trang_thai ?></p>
                    </div>
                </div>
            </div>
        </div>
		<p>
            <?= Html::button('<i class="fa fa-print"> </i> In Phiếu Thông Tin', ['class' => 'btn btn-success', 'onclick' => 'InPhieuThongTin()']) ?>
       </p>

    <!-- Phần tử ẩn chứa nội dung phiếu -->
    <div style="display:none">
        <div id="print"></div>
    </div>
    </div>
    
</div>
<script>
function InPhieuThongTin() {
    $.ajax({
        type: 'POST',
        url: '/hocvien/dang-ky-hv/get-phieu-in-ajax?id=' + <?= $model->id ?> + '&type=phieuthongtin',
        success: function (data) {
            if(data.status === 'success'){
                $('#print').html(data.content);
                printPhieuXuat(); // Gọi hàm in phiếu
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
