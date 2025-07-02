<?php

use app\modules\thuexe\models\HinhXe;
use app\custom\CustomFunc;

/* @var $this yii\web\View */
/* @var $model app\models\HvHocVien */
// Giả sử $id là ID của xe đang xem
$hinhXeList = HinhXe::find()->where(['id_xe' => $model->id])->all();

?>
<div class="hv-hoc-vien-view">
 
<div class="row">
    <div class="col-xl-4 col-md-12">
    <div class="card custom-card">
				<div class="card-header custom-card-header rounded-bottom-0">
					<div>
                        <h6 class="card-title mb-0 text-center" style="color: red;">Thông tin Xe:</h6>
					</div>
			    </div>
							<div class="card-body">
									<div class="skill-tags">
										<p><strong>Loại xe:</strong> <?= $model->loaiXe->ten_loai_xe?></p>
                                        <p><strong>Tên xe:</strong> <?= $model->hieu_xe?></p>
                                        <p><strong>Biển số xe:</strong> <?= $model->bien_so_xe?></p>
                                        <p><strong>Màu sắc:</strong> <?= $model->mau_sac?></p>
                                        <p><strong>Số hợp đồng xe:</strong> <?= $model->so_hop_dong?></p>
                                        <p><strong>Tình trạng xe:</strong> <?= $model->tinh_trang_xe ?></p>
                                        <p><strong>Trạng thái:</strong> <?= $model->trang_thai?></p>
                                        <p><strong>Phân loại:</strong> <?= $model->getLabelPhanLoaiXe() ?></p>
                                        <p><strong>Người phụ trách:</strong> <?= $model->giaoVien?$model->giaoVien->ho_ten:'' ?></p>
								    </div>
								    
								    <div class="skill-tags">
                                        <p><strong>Số khung:</strong> <?= $model->so_khung?></p>
                                        <p><strong>Số máy/Số động cơ:</strong> <?= $model->so_may?></p>
                                        <p><strong>Ngày đăng kiểm:</strong> <?= CustomFunc::convertYMDToDMY($model->ngay_dang_kiem)?></p>
                                        <p><strong>Xe mới/Đã qua sử dụng:</strong> <?= $model->la_xe_cu==1?'Xe đã qua sử dụng': 'Xe mới' ?></p>
                                        <p><strong>Giá trị xe:</strong> <?= number_format($model->so_tien) . ' đ' ?></p>
                                        <p><strong>Nhà cung cấp:</strong> <?= $model->nha_cung_cap ?></p>
                                        <p><strong>Số hóa đơn:</strong> <?= $model->so_hoa_don ?></p>
								    </div>
						    </div>
	</div>

    </div>
    <div class="col-xl-8 col-md-12">
    <div class="card custom-card">
        <div class="card-header custom-card-header rounded-bottom-0">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="add-document-tab" data-bs-toggle="tab" href="#add-document" role="tab" aria-controls="add-student" aria-selected="true" style="color: blue;">
                        <i class="fa fa-file-image-o"></i> Hình ảnh xe
                    </a>
                </li>     
            </ul>
        </div>
        <div class="card-body">
            <div class="skill-tags">
                <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade active show" id="add-document" role="tabpanel" aria-labelledby="add-document-tab">
    <?php if (!empty($hinhXeList)): ?>
        <div class="row">
            <?php foreach ($hinhXeList as $hinhXe): ?>
                <div class="col-md-4 mb-3">
                    <img src="<?= Yii::getAlias('@web/images/temp/' . $hinhXe->hinh_anh) ?>" alt="Hình ảnh xe" class="img-fluid rounded uniform-img" />
                </div>

            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Không có hình ảnh nào cho xe này.</p>
    <?php endif; ?>
</div>

                </div>
            </div>
        </div>
    </div>
</div>

</div>

</div>
<style>
    .uniform-img {
    width: 100%; 
    height: 150px; 
    object-fit: cover; 
    border-radius: 8px; 
}
</style>
