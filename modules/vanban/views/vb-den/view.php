<?php

use yii\widgets\DetailView;
use yii\helpers\Html;
use app\modules\vanban\models\VanBanDen;

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
						<li>Số văn bản: <?= $model->ngayKy ?></li>
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
						<li>Số văn bản: <?= $model->so_vb ?></li>
						<li>Số văn bản: <?= $model->ngayKy ?></li>
						<li>Số văn bản: <?= $model->trich_yeu ?></li>
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
						<li>Số văn bản: <?= $model->ngayKy ?></li>
						<li>Số văn bản: <?= $model->trich_yeu ?></li>
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
    
                
                'vbden_so_den',
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
<<<<<<< HEAD
<<<<<<< HEAD
            'trich_yeu',
            'nguoi_ky',
        'vbden_ngay_den'=>[
            'attribute'=>'vbden_ngay_den',
            'value'=>$model->vbdenND
        ],

            
            'vbden_so_den',
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
    ]) ?>
=======
=======
>>>>>>> f2a9a068afd729919e5e31bb4a53cd5f865d480c
        ]) */ ?>
    </div>
    
    <div class="col-md-8">
    	<div class="text-dark mb-2 ms-1 fs-20 tx-medium row">
    		<div class="col-md-8">File văn bản</div>
        	<div class="col-md-4">
        		<?= Html::a('<i class="ti-files" data-bs-toggle="tooltip" aria-label="ti-files" data-bs-original-title="ti-files"></i>', 
                            ['/kholuutru/file/upload-single', 
                                'loaiDoiTuong'=>1,
                                'doiTuong'=>VanBanDen::MODEL_ID,
                                'idDoiTuong'=>$model->id
                            ],
                            [
                                'class'=>'btn ripple btn-primary btn-sm',
                                'role'=>'modal-remote-2'
                            ],
               )?>
               
               <?= Html::a('<i class="ti-file" data-bs-toggle="tooltip" aria-label="ti-file" data-bs-original-title="ti-file"></i>', 
                   ['/kholuutru/file/upload-multi',  
                       'loaiDoiTuong'=>1,
                       'doiTuong'=>VanBanDen::MODEL_ID,
                       'idDoiTuong'=>$model->id],
                            [
                                'class'=>'btn ripple btn-primary btn-sm',
                                'role'=>'modal-remote-2'
                            ],
               )?>
        	</div>
    	</div>
        	
    	<?= $model->fileVB ? $this->render('view_single_file', ['fileVB'=>$model->fileVB]) : '' ?>
    	
    	<div class="text-dark mb-2 ms-1 fs-20 tx-medium">File đính kèm</div>
    		<div class="row">        		
        		<?= $this->render('view_multi_file', ['fileDinhKem'=>$model->fileDinhKem]) ?>        		
    		</div>
    </div>

<<<<<<< HEAD

=======
>>>>>>> f2a9a068afd729919e5e31bb4a53cd5f865d480c
</div>


<script>
function funcOne($data){
	$('#fileContent').html($data);
}
</script>
