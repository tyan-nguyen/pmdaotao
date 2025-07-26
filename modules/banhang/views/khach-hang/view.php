<?php
use app\widgets\FileDisplayWidget;
use app\modules\nhanvien\models\NhanVien;
use app\widgets\KhoDisplayWidget;

/* @var $this yii\web\View */
/* @var $model app\modules\nhanvien\models\NhanVien */
?>
<div class="nhan-vien-view">
 
<div class="row">
    <div class="col-xl-3 col-md-12">
    <div class="card custom-card">
				<div class="card-header custom-card-header rounded-bottom-0">
					<div>
						<h6 class="card-title mb-0 "style="color: red;">Thông tin khách hàng: </h6>
					</div>
			    </div>
							<div class="card-body">
									<div class="skill-tags">
                                        <p><strong>Họ Tên:</strong> <?= $model->ho_ten ?></p>
                                        <p><strong>Số điện thoại:</strong> <?= $model->so_dien_thoai?></p>
                                        <p><strong>Địa chỉ:</strong> <?= $model->dia_chi ?></p>
								    </div>
						    </div>
	</div>
</div>
        <div class="col-xl-9 col-md-12">
                           
		<div class="card custom-card">
            <div class="card-header custom-card-header rounded-bottom-0">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="cong-no-tab" data-bs-toggle="tab" href="#cong-no" role="tab" aria-controls="cong-no" aria-selected="false"style="color: blue;"><i class="fa fa-money-bill-wave"></i> Công nợ </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="don-hang-tab" data-bs-toggle="tab" href="#don-hang" role="tab" aria-controls="don-hang" aria-selected="false"style="color: blue;"><i class="fa fa-shopping-cart"></i> Đơn hàng </a>
                    </li>
                  
                </ul>
			</div>
                   <div class="card-body">
                      <div class="skill-tags">
                      
                        <div class="tab-content" id="myTabContent">
                             <div class="tab-pane fade show active" id="cong-no" role="tabpanel" aria-labelledby="cong-no-tab">
                                    <!-- Công nợ -->
                                    <?php // $this->render('cong_no', ['model' => $model]) ?>
                             </div>
                             <div class="tab-pane fade" id="don-hang" role="tabpanel" aria-labelledby="don-hang-tab">
                                    <!-- Đơn hàng -->
                                    <?php // $this->render('don_hang', ['model' => $model]) ?>
                             </div>
                        </div>
                      </div>
                  </div>
        </div>
    </div>

        </div>

</div>


