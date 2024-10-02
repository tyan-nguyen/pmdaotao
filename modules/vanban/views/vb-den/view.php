<?php
use yii\widgets\DetailView;
use app\modules\vanban\models\VanBanDen;
use app\widgets\FileDisplayWidget;
use app\widgets\KhoDisplayWidget;

/* @var $this yii\web\View */
/* @var $model app\modules\vanban\models\VanBanDen */
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
						<li>Số văn bản: <?= $model->so_vb ?></li>
						<li>Ngày Ký: <?= $model->ngayKy ?></li>
						<li>Người ký: <?= $model->nguoi_ky ?></li>
						<li>Trích yếu: <?= $model->trich_yeu ?></li>
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
						<li>Vào sổ VB: <?= $model->nam ?></li>
						<li>Số vào sổ: <?= $model->ngayKy ?></li>
						<li>Số văn bản: <?= $model->trich_yeu ?></li>
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
    					<li>Người nhận: <?= $model->vbden_nguoi_nhan ?></li>
    					<li>Ngày chuyển: <?= $model->vbden_ngay_chuyen ?></li>
    				</ul>
				</div>
			</div>
		</div>
		
		
									
        <?php /* DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'id_loai_van_ban',
                'so_vb',
                'ngay_ky'=>[
                    'attribute' => 'ngay_ky',
                    'value'=>$model->ngayKy
                ],
                'trich_yeu',
                'nguoi_ky',
            'vbden_ngay_den' => [
                 'attribute' => 'vbden_ngay_den',
                 'value' => function($model) {
                 return Yii::$app->formatter->asDate($model->vbden_ngay_den, 'php:d/m/Y');
                    },
                ],
    
                
                'so_vao_so',
                'vbden_nguoi_nhan',
                'vbden_ngay_chuyen' => [
                    'attribute' => 'vbden_ngay_chuyen',
                    'value' => function($model) {
                    return Yii::$app->formatter->asDate($model->vbden_ngay_chuyen, 'php:d/m/Y');
                       },
                   ],
             
              
             
                'ghi_chu',
                'nguoi_tao',
                'thoi_gian_tao',
                'so_loai_van_ban',
            ],

            'trich_yeu',
            'nguoi_ky',
        'vbden_ngay_den'=>[
            'attribute'=>'vbden_ngay_den',
            'value'=>$model->vbdenND
        ],

            
            'so_vao_so',
            'vbden_nguoi_nhan',
            'vbden_ngay_chuyen' => [
                'attribute' => 'vbden_ngay_chuyen',
                'value' => function($model) {
                return Yii::$app->formatter->asDate($model->vbden_ngay_chuyen, 'php:d/m/Y');
                   },
               ],
         
          
         
            'ghi_chu',
            'nguoi_tao',
            'thoi_gian_tao',
            'so_loai_van_ban',
        ],
    ]) */ ?>

    </div>
    
    <div class="col-md-8">
    
    
    <div class="card-body p-0">
		<div class="panel panel-primary">
			<div class="tab-menu-heading tab-menu-heading-boxed">
				<div class="tabs-menu-boxed">
					<!-- Tabs -->
					<ul class="nav panel-tabs" role="tablist">
						<li><a href="#tabFile" class="active" data-bs-toggle="tab" aria-selected="true" role="tab" tabindex="-1">Tệp tin</a></li>
						<li><a href="#tabKho" data-bs-toggle="tab" aria-selected="false" role="tab" class="" tabindex="-1">Lưu trữ</a></li>
					</ul>
				</div>
			</div>
			<div class="panel-body tabs-menu-body ps">
				<div class="tab-content">
					<div class="tab-pane active show" id="tabFile" role="tabpanel">
						<?= FileDisplayWidget::widget([
                            'type'=>'LOAIHOSO',
                            'doiTuong'=>VanBanDen::MODEL_ID,
                            'idDoiTuong'=>$model->id,
                        ])?>
					</div>
					<div class="tab-pane" id="tabKho" role="tabpanel">						
                         <?= KhoDisplayWidget::widget([
                            'doiTuong' => VanBanDen::MODEL_ID,
                            'idDoiTuong' => $model->id
                        ]) ?>
					</div>
				</div>
			</div>
		</div>
	</div>          
    </div>


</div>
