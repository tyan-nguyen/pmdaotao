<?php

use yii\widgets\DetailView;
use app\widgets\FileDisplayWidget;
use app\modules\hocvien\models\HocVien;
use app\widgets\KhoDisplayWidget;
/* @var $this yii\web\View */
/* @var $model app\models\HvHocVien */
?>
<div class="hv-hoc-vien-view">
 
<div class="row">
    <div class="col-xl-3 col-md-12">
    <div class="card custom-card">
				<div class="card-header custom-card-header rounded-bottom-0">
					<div>
                        <h6 class="card-title mb-0 text-center" style="color: red;">Thông tin Xe:</h6>
					</div>
			    </div>
							<div class="card-body">
									<div class="skill-tags">
                                        <p><strong>Tên xe:</strong> <?= $model-> id ?></p>
                                        <p><strong>Hiệu xe:</strong> <?= $model->hieu_xe?></p>
                                        <p><strong>Biển số xe:</strong> <?= $model->bien_so_xe?></p>
                                        <p><strong>Tình trạng xe:</strong> <?= $model->tinh_trang_xe ?></p>
                                        <p><strong>Trạng thái:</strong> <?= $model->trang_thai?></p>
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
                        <i class="fa fa-file-image-o"></i> Hình ảnh xe
                    </a>
                </li>     
            </ul>
        </div>
        <div class="card-body">
            <div class="skill-tags">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade active show" id="add-document" role="tabpanel" aria-labelledby="add-document-tab">
                        <?= FileDisplayWidget::widget([
                             'type'=>'ALL',
                             'doiTuong'=>HocVien::MODEL_ID,
                             'idDoiTuong'=>$model->id,
                        ])?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

</div>

