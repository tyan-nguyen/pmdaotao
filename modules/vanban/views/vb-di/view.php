<?php

use yii\widgets\DetailView;
use app\modules\vanban\models\VanBanDi;
use app\widgets\FileDisplayWidget;
/* @var $this yii\web\View */
/* @var $model app\modules\vanban\models\VanBanDi */
?>
<div class="van-ban-den-view row">
 	<div class="col-md-4">
 	
 		<div class="card custom-card">
			<div class="card-header custom-card-header rounded-bottom-0">
				<div>
					<h6 class="card-title mb-0 ">Thông tin văn bản</h6>
				</div>
			</div>
			<div class="card-body">
				<div class="skill-tags">
					<ul class="list-unstyled mb-0">
						<li>Loai văn bản: <?= $model->so_loai_van_ban ?></li>
						<li>Ngày ký: <?= $model->ngayKy ?></li>
						<li>Trích yếu: <?= $model->trich_yeu ?></li>
					</ul>
				</div>
			</div>
		</div>
		
		<div class="card custom-card">
			<div class="card-header custom-card-header rounded-bottom-0">
				<div>
					<h6 class="card-title mb-0 ">Chuyển xử lý</h6>
				</div>
			</div>
			<div class="card-body">
				<div class="skill-tags">
					<ul class="list-unstyled mb-0">
						<li>Người ký: <?= $model->nguoi_ky ?></li>
						<li>Nơi nhận: <?= $model->vbdi_noi_nhan ?></li>
						<li>Số lượng bản: <?= $model->vbdi_so_luong_ban ?></li>
					</ul>
				</div>
			</div>
		</div>
		
		<div class="card custom-card">
			<div class="card-header custom-card-header rounded-bottom-0">
				<div>
					<h6 class="card-title mb-0 ">Lưu sổ văn bản</h6>
				</div>
			</div>
			<div class="card-body">
				<div class="skill-tags">
					<ul class="list-unstyled mb-0">
						<li>Số văn bản: <?= $model->so_vb ?></li>
						<li>Ngày chuyển: <?= $model->VbdiNC?></li>
						<li>Ghi chú: <?= $model->ghi_chu ?></li>
					</ul>
				</div>
			</div>
		</div>
        </div>
    
    <div class="col-md-8">
        <?= FileDisplayWidget::widget([
            'type'=>'ALL',
            'doiTuong'=>VanBanDi::MODEL_ID,
            'idDoiTuong'=>$model->id,
        ])?>
    </div>


</div>
	
