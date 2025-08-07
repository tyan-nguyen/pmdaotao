<?php
use app\custom\CustomFunc;
use app\modules\daotao\models\KeHoach;
use app\modules\daotao\models\DmThoiGian;
use app\modules\daotao\models\TietHoc;
use yii\helpers\Html;
use app\modules\daotao\models\base\KeHoachBase;
use app\modules\user\models\User;
?>
<div class="row">
    <div class="col-xl-3 col-md-12">
    <div class="card custom-card">
		<div class="card-header custom-card-header rounded-bottom-0">
			<div>
                <h6 class="card-title mb-0 text-center" style="color: red;">Thông tin kế hoạch:</h6>
			</div>
	    </div>
		<div class="card-body">
				<div class="skill-tags">
                    <p><strong>Giáo viên:</strong> <?= $model->giaoVien?$model->giaoVien->ho_ten:''?></p>
                    <p><strong>Ngày tạo:</strong> <?= CustomFunc::convertYMDToDMY($model->ngay_thuc_hien)?></p>
                    <p><strong>Ghi chú:</strong> <?= $model->ghi_chu?></p>
                    <p><strong>Trạng thái:</strong> <?= KeHoach::getLabelTrangThaiBadge($model->trang_thai_duyet)?></p>
                    <p><strong>Người duyệt:</strong> <?= $model->nguoiDuyet?($model->nguoiDuyet->ho_ten?$model->nguoiDuyet->ho_ten:$model->nguoiDuyet->username):'' ?></p>
                    <p><strong>Ngày duyệt:</strong> <?= CustomFunc::convertYMDHISToDMYHI($model->thoi_gian_duyet)?></p>
                    <p><strong>Ghi chú duyệt:</strong> <?= $model->noi_dung_duyet ?></p>
                    
                     <p>
                     <?php /*$model->trang_thai_duyet==KeHoachBase::TT_NHAP?Html::a('Sửa',['update','id'=>$model->id],['class'=>'btn btn-warning','style'=>'color:black','role'=>'modal-remote']):''*/ ?>
                    <?php 
                    $user = User::getCurrentUser();                    
                    // chi hien thi nut trinh duyet theo 1 so trang thai
                    $checkPermission =  ($model->trang_thai_duyet==KeHoachBase::TT_NHAP || $model->trang_thai_duyet==KeHoachBase::TT_KHONGDUYET || $model->trang_thai_duyet==KeHoachBase::TT_DADUYET || $user->superadmin);
                    if($checkPermission){
                    ?>
                    <?= Html::a('Sửa',['update','id'=>$model->id],['class'=>'btn btn-warning','style'=>'color:black','role'=>'modal-remote']) ?>
                    &nbsp; <?= $model->trang_thai_duyet==KeHoachBase::TT_NHAP ? Html::a('Trình duyệt',['trinh-duyet','id'=>$model->id],['class'=>'btn btn-warning','style'=>'color:black','role'=>'modal-remote','data-confirm-title'=>'Xác nhận gửi duyệt?','data-confirm-message'=>'Sau khi trình duyệt sẽ tạm thời không thể chỉnh sửa, bạn có chắc chắn muốn tiếp tục?']) : '' ?>
                    &nbsp;                	
                    <?php } ?>
                    <?= Html::a('<i class="fas fa-print"></i> In', '#', [
                	    'class' => 'btn btn-warning', 
                	    'style'=>'color:black', 
                	    'onclick' => 'InKeHoach('.$model->id.')']) ?> 
                    </p>
			    </div>
	    </div>
	</div>

    </div>
    <div class="col-xl-9 col-md-12">
    <div class="card custom-card">
        <div class="card-header custom-card-header rounded-bottom-0">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="add-document-tab" data-bs-toggle="tab" href="#add-document" role="tab" aria-controls="add-student" aria-selected="true" style="color: blue;">
                        <i class="fa fa-file-image-o"></i> Kế hoạch chi tiết
                    </a>
                </li>     
            </ul>
        </div>
        <div class="card-body">
            <div class="skill-tags">
                <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade active show" id="add-document" role="tabpanel" aria-labelledby="add-document-tab">
                <div id="gioHocContent" style="max-height:600px;overflow: auto">
                <?= $this->render('../tiet-hoc/_viewFromKeHoach', ['model'=>$model]) ?>
				</div>
                 
    
				</div>

                </div>
            </div>
        </div>
    </div>
</div>

</div>

<!-- Phần tử ẩn chứa nội dung phiếu -->
<div style="display:none">
  <div id="print"></div>
</div>

<script>
function InKeHoach(id) {
    $.ajax({
        type: 'POST',
        url: '/daotao/ke-hoach/print?id=' + id,
        success: function (data) {
            if (data.status === 'success') {
                $('#print').html(data.content);
				printPhieu();
            } else {
                alert('Không thể tải phiếu!');
            }
        },
        error: function () {
            alert('Đã xảy ra lỗi.');
        }
    });
}
</script>