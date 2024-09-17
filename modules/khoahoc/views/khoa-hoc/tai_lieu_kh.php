<?php 
    use yii\widgets\DetailView;
    use yii\helpers\Html;
    use app\modules\khoahoc\models\KhoaHoc;
?>
<div class="col-md-8">
    	<div class="text-dark mb-2 ms-1 fs-20 tx-medium row">
        	<div class="col-md-4">   
            <?= Html::a('<i class="ti-file icon-custom" data-bs-toggle="tooltip" aria-label="Upload File" data-bs-original-title="Upload File"></i>', 
                   ['/kholuutru/file/upload-multi', 
                   'loaiDoiTuong'=>1,
                   'doiTuong'=>KhoaHoc::MODEL_ID,
                   'idDoiTuong'=>$model->id 
                      ],
                            [
                                'class'=>'btn ripple btn-warning btn-sm',
                                'role'=>'modal-remote-2'
                            ],
               )?>
        	</div>
            <div class="row">        		     		
            <?= $model->fileKH? $this->render('file_khoa_hoc', ['fileKhoaHoc'=>$model->fileKhoaHoc]) : '' ?>	
    		</div>
    	</div>
</div>
