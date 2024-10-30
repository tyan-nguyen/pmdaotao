<?php
    use yii\bootstrap5\Html;
?>

<p> Người thuê đã trả xe ! </p>
            <div class="row">
                 <div class="col-md-3">
                       
                        <?= Html::a('<i class="fas fa-eye icon-white"></i>', 
                            ['/thuexe/phieu-thue-xe/tra-xe','id' => $model->id, 'modalType' => 'modal-remote-2'], 
                            ['class' => 'btn btn-sm btn-success', 'title' => 'Xem thông tin trả xe', 'role' => 'modal-remote-2']
                        ); ?>   
                 </div>
            </div>