<?php
use app\modules\daotao\models\HangMonHoc;
use app\modules\daotao\models\TietHoc;

$dsMonHoc = HangMonHoc::find()->where(['id_hang' => $model->id_hang])->all();
?>
<table class="table table-bordered">
    <thead>
        <tr>
        	<th>STT</th>
            <th>Mã Module</th>
            <th>Tên Module</th>
            <th>Số giờ theo QĐ</th>
            <th>Số giờ TT</th>
            <th>Đã học</th>
            <th>Đã hoàn thành</th>
            <th>Học viên hủy</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        foreach ($dsMonHoc as $iM=>$m){
            $tietHocOk = TietHoc::find()->where(['id_hoc_vien'=>$model->id, 'id_mon_hoc'=>$m->id_mon, 'trang_thai'=>TietHoc::TT_DAHOANTHANH])->sum('so_gio');
            $tietHocHocVienHuy = TietHoc::find()->where(['id_hoc_vien'=>$model->id, 'id_mon_hoc'=>$m->id_mon, 'trang_thai'=>TietHoc::TT_HOCVIENHUY])->count();
        ?>
        <tr>
        	<td><?= ($iM+1) ?></td>
        	<td><?= $m->mon->ma_mon ?></td>
        	<td><?= $m->mon->tenMon ?></td>
        	<td><?= $m->mon->so_gio_qd ?></td>
        	<td><?= $m->mon->so_gio_tt ?></td>
        	<td><?= ($tietHocOk+$tietHocHocVienHuy) ?>/<?= $m->mon->so_gio_tt ?></td>
        	<td><?= $tietHocOk ?>/<?= $m->mon->so_gio_tt ?></td>
        	<td><?= $tietHocHocVienHuy ?></td>
        </tr>
        <?php } ?>
	</tbody>
</table>
