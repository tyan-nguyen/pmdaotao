<?php
use yii\bootstrap5\Html;

?>
<p> Phiếu đã được kiểm duyệt ! </p>
            <div class="row">
                 <div class="col-md-3">
                       
                        <?= Html::a('<i class="fas fa-eye icon-white"></i>', 
                            ['/thuexe/phieu-thue-xe/xem-thong-tin-duyet-phieu','id' => $model->id, 'modalType' => 'modal-remote-2'], 
                            ['class' => 'btn btn-sm btn-success', 'title' => 'Xem thông tin kiểm duyệt', 'role' => 'modal-remote-2']
                        ); ?>   
                 </div>
            </div>