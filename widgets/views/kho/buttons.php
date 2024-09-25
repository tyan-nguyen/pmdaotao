<?php
use yii\helpers\Html;
?>
<div class="text-dark mb-2 ms-1 fs-20 tx-medium row">
	<div style="position:relative;">	
		<div style="position:absolute; right:20px; top:0px;">
		<?php 
		  if($model == NULL){
        		echo Html::a('<i class="ti-files" data-bs-toggle="tooltip" aria-label="ti-files" data-bs-original-title="ti-files"></i>',
        		    ['/kholuutru/ho-so-kho/create',
        		        'doiTuong'=>$doiTuong,
        		        'idDoiTuong'=>$idDoiTuong
        		    ],
        		    [
        		        'class'=>'btn ripple btn-secondary btn-sm',
        		        'role'=>'modal-remote-2'
        		    ],
        		    );
		  } else {
		      echo Html::a('<i class="ti-files" data-bs-toggle="tooltip" aria-label="ti-files" data-bs-original-title="ti-files"></i>',
		          ['/kholuutru/ho-so-kho/update',
		              'id'=>$model->id,
		          ],
		          [
		              'class'=>'btn ripple btn-secondary btn-sm',
		              'role'=>'modal-remote-2'
		          ],
		          );
		  }
		?>

       </div>
	</div>
</div>