<?php
use yii\helpers\Html;
use app\custom\CustomFunc;
use app\modules\daotao\models\TietHoc;
use app\modules\daotao\models\DmThoiGian;
use app\modules\daotao\models\KeHoach;
?>
<table class="table table-bordered">
    <thead>
        <tr>
        	<th>STT</th>
            <!-- <th>Giờ dạy</th>-->
            <th>Từ giờ</th>
            <th>Đến giờ</th>
            <th>Học viên</th>
            <th>Module</th>
            <th>Xe</th>
            <th>Trạng thái</th>
            <th>Ghi chú</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
     <?php 
        $dmThoiGian = DmThoiGian::find()->where(['active'=>1])->orderBy(['stt'=>SORT_ASC])->all();
        foreach ($dmThoiGian as $iT=>$time){
        //check
        $gioIsExist = false;
        $tietHoc = TietHoc::find()->where([
            'id_ke_hoach' => $model->id,
            'id_thoi_gian_hoc' => $time->id,
        ])->one();
        if($tietHoc!=null){
            $gioIsExist = true;
        }
     ?>
     <tr>
     	<td><?= ($iT+1) ?></td>
     	<!-- <td><?= $time->ten_thoi_gian ?></td>-->
     	<td><?= CustomFunc::convertHIStoHI($time->thoi_gian_bd) ?></td>
     	<td><?= CustomFunc::convertHIStoHI($time->thoi_gian_kt) ?></td>
     	<?php if($gioIsExist == false):?>
     	<td></td>
     	<td></td>
     	<td></td>
     	<td></td>
     	<td></td>
     	<td><?= $model->trang_thai_duyet==KeHoach::TT_NHAP ? ( Html::a( '<i class="fa fa-plus"> </i> ',
            ['/daotao/tiet-hoc/create-from-ke-hoach', 
                'idkh' => $model->id,
                'idtime'=>$time->id
            ],
            [
                'class'=>'btn btn-primary',
                'title' => 'Thêm giờ học',
                'style' => 'color: white;',
                'role'=>'modal-remote-2'
            ]
        )):'' ?></td>
     	<?php endif;?>
     	<?php if($gioIsExist == true):?>
     	<td><?= $tietHoc->hocVien->ho_ten ?></td>
     	<td><?= $tietHoc->monHoc->ten_mon . ($tietHoc->monHoc->ten_mon_sub?(' ('.$tietHoc->monHoc->ten_mon_sub.')'):'') ?></td>
     	<td><?= $tietHoc->xe->bien_so_xe ?></td>
     	<td><?= TietHoc::getLabelTinhTrangXeBadge($tietHoc->trang_thai) ?></td>
     	<td><?= $tietHoc->ghi_chu ?></td>
     	<td><?= ($model->trang_thai_duyet==KeHoach::TT_NHAP || $model->trang_thai_duyet==KeHoach::TT_DADUYET ) ? ( Html::a( '<i class="fa fa-pencil"> </i> ',
            ['/daotao/tiet-hoc/update-from-ke-hoach', 
               'id' => $tietHoc->id
            ],
            [
                'class'=>'btn btn-warning',
                'title' => 'Sửa',
                'style' => 'color: white;',
                'role'=>'modal-remote-2'
            ]
        )):'' ?></td>
     	<?php endif;?>
     </tr>
     
     <?php } ?>
     </tbody>
</table>