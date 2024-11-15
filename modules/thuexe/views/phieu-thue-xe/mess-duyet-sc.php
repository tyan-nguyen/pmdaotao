<?php
    use yii\bootstrap5\Html;
    use kartik\datetime\DateTimePicker;
?>

<p style="color:blue;"> Người thuê đã trả xe ! </p>
<label style="color:blueviolet;"> Xem thông tin trả xe : </label> 
                        <?= Html::a('<i class="fas fa-eye icon-white"></i>', 
                            ['/thuexe/phieu-thue-xe/xem-tra-xe','id' => $model->id, 'modalType' => 'modal-remote-2'], 
                            ['class' => 'btn btn-sm btn-success', 'title' => 'Xem thông tin trả xe', 'role' => 'modal-remote-2']
                        ); ?>   

      