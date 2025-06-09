<?php
use app\modules\daotao\models\HangMonHoc;
use app\modules\daotao\models\TietHoc;

$dsMonHoc = HangMonHoc::find()->where(['id_hang' => $model->id_hang])->all();
?>
<h4>Tổng thời gian học</h4>
<table class="table table-bordered table-responsive" style="max-width:100%">
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
            <th>Số km</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        foreach ($dsMonHoc as $iM=>$m){
            $tietHocOk = TietHoc::find()->where(['id_hoc_vien'=>$model->id, 'id_mon_hoc'=>$m->id_mon, 'trang_thai'=>TietHoc::TT_DAHOANTHANH])->sum('so_gio');
            $tietHocHocVienHuy = TietHoc::find()->where(['id_hoc_vien'=>$model->id, 'id_mon_hoc'=>$m->id_mon, 'trang_thai'=>TietHoc::TT_HOCVIENHUY])->sum('so_gio');
            $tongKm = TietHoc::find()->where(['id_hoc_vien'=>$model->id, 'id_mon_hoc'=>$m->id_mon, 'trang_thai'=>TietHoc::TT_DAHOANTHANH])->sum('so_km');
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
        	<td><?= $tongKm ?></td>
        </tr>
        <?php } ?>
	</tbody>
</table>

<h4>Theo giáo viên</h4>
<table class="table table-bordered table-responsive">
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
            <th>Số Km</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        foreach ($model->giaoVienDay as $gvd){
            echo '<tr><td colspan="9"><strong>'.$gvd->giaoVien->ho_ten.'</strong></td></tr>';
        foreach ($dsMonHoc as $iM=>$m){
            $tietHocOk = TietHoc::find()->where(['id_hoc_vien'=>$model->id, 'id_mon_hoc'=>$m->id_mon, 'trang_thai'=>TietHoc::TT_DAHOANTHANH, 'id_giao_vien'=>$gvd->id_giao_vien])->sum('so_gio');
            $tietHocHocVienHuy = TietHoc::find()->where(['id_hoc_vien'=>$model->id, 'id_mon_hoc'=>$m->id_mon, 'trang_thai'=>TietHoc::TT_HOCVIENHUY, 'id_giao_vien'=>$gvd->id_giao_vien])->count();
            $tongKm = TietHoc::find()->where(['id_hoc_vien'=>$model->id, 'id_mon_hoc'=>$m->id_mon, 'trang_thai'=>TietHoc::TT_DAHOANTHANH, 'id_giao_vien'=>$gvd->id_giao_vien])->sum('so_km');
        ?>
        <tr>
        	<td><?= ($iM+1) ?></td>
        	<td><?= $m->mon->ma_mon ?></td>
        	<td><?= $m->mon->tenMon ?></td>
        	<td><?= $m->mon->so_gio_qd ?></td>
        	<td><?= $m->mon->so_gio_tt ?></td>
        	<td><?= ($tietHocOk+$tietHocHocVienHuy) ?>/<?= $m->mon->so_gio_tt ?></td>
        	<td><?= $tietHocOk?$tietHocOk:0 ?>/<?= $m->mon->so_gio_tt ?></td>
        	<td><?= $tietHocHocVienHuy ?></td>
        	<td><?= $tongKm ?></td>
        </tr>
        <?php } ?>
        <?php } ?>
	</tbody>
</table>
