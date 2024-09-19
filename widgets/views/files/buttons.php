<?php
use yii\helpers\Html;
?>
<div class="text-dark mb-2 ms-1 fs-20 tx-medium row">
	<div style="position:relative;">	
		<div style="position:absolute; right:20px; top:0px;">
		<?= Html::a('<i class="ti-files" data-bs-toggle="tooltip" aria-label="ti-files" data-bs-original-title="ti-files"></i>', 
                    ['/kholuutru/file/upload-multi',
                        'doiTuong'=>$doiTuong,
                        'idDoiTuong'=>$idDoiTuong
                    ],
                    [
                        'class'=>'btn ripple btn-secondary btn-sm',
                        'role'=>'modal-remote-2'
                    ],
       )?>
       
       <?= Html::a('<i class="ti-file" data-bs-toggle="tooltip" aria-label="ti-file" data-bs-original-title="ti-file"></i>', 
           ['/kholuutru/file/upload-single',  
               'doiTuong'=>$doiTuong,
               'idDoiTuong'=>$idDoiTuong],
                    [
                        'class'=>'btn ripple btn-secondary btn-sm',
                        'role'=>'modal-remote-2'
                    ],
       )?>
       </div>
	</div>
</div>