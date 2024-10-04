<?php

use yii\widgets\DetailView;
use app\modules\vanban\models\VanBanDi;
use app\widgets\FileDisplayWidget;
use app\widgets\KhoDisplayWidget;
use app\widgets\CardWidget;

/* @var $this yii\web\View */
/* @var $model app\modules\vanban\models\VanBanDi */
?>
<div class="van-ban-den-view row">
 	<div class="col-md-4">
 
		<?php CardWidget::begin(['title'=>'Thông tin văn bản']) ?>
			<ul class="list-unstyled mb-0">				
				<li>Số văn bản: <?= $model->so_vb ?></li>
        		<li>Loại VB: <?= $model->loaiVanBan->ten_loai ?></li>
        		<li>Ngày Ký: <?= $model->ngayKy ?></li>
        		<li>Người ký: <?= $model->nguoi_ky ?></li>
        		<li>Trích yếu: <?= $model->trich_yeu ?></li>    
        		<li>Số lượng bản: <?= $model->vbdi_so_luong_ban ?></li>		
        		<li>Nơi nhận: <?= $model->vbdi_noi_nhan ?></li>
			</ul>
		<?php CardWidget::end() ?>
		
		<?php CardWidget::begin(['title'=>'Vào sổ VB']) ?>
		<ul class="list-unstyled mb-0">
			<li>Vào sổ VB: <?= $model->nam ?></li>
			<li>Số vào sổ: <?= $model->so_vao_so ?></li>
			<li>Ghi chú: <?= $model->ghi_chu ?></li>
			<li>Ngày chuyển: <?= $model->VbdiNC?></li>
		</ul>
		<?php CardWidget::end() ?>
    </div>
    
    <div class="col-md-8">
    	<div class="card custom-card">
            <div class="card-header custom-card-header rounded-bottom-0">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="tabFile-tab" data-bs-toggle="tab" href="#tabFile" role="tab" aria-controls="tabFile" aria-selected="false"style="color: blue;"><i class="fa fa-folder"></i> Tệp tin</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="tabKho-tab" data-bs-toggle="tab" href="#tabKho" role="tab" aria-controls="tabKho" aria-selected="false"style="color: blue;"><i class="fa fa-map-marker"></i> Lưu trữ</a>
                    </li>
                </ul>
			</div>
           <div class="card-body">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active p-1" id="tabFile" role="tabpanel" aria-labelledby="list-tab">
                       <?= FileDisplayWidget::widget([
                            'type'=>'LOAIHOSO',
                            'doiTuong'=>VanBanDi::MODEL_ID,
                            'idDoiTuong'=>$model->id,
                        ])?>
                    </div>
                    <div class="tab-pane fade" id="tabKho" role="tabpanel" aria-labelledby="add-student-tab">
                        <?= KhoDisplayWidget::widget([
                            'doiTuong' => VanBanDi::MODEL_ID,
                            'idDoiTuong' => $model->id
                        ]) ?>
                    </div>
                </div>
          </div>
        </div>   
    </div>

</div>
	
