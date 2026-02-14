<?php
use yii\helpers\Html;
use app\custom\CustomFunc;
use app\modules\daotao\models\TietHoc;
use app\modules\daotao\models\DmThoiGian;
use app\modules\daotao\models\KeHoach;
use app\modules\user\models\User;
?>
<style>
.tbl-time tr td{
    padding: 7px 7px !important;
}
</style>
<table class="table table-bordered tbl-time">
    <thead>
        <tr>
        	<th width="3%" align="center">TT</th>
            <!-- <th>Giờ dạy</th>-->
            <th width="11%" align="center">Giờ</th>
            <!-- <th width="10">Đến giờ</th> -->
            <th width="15%">Học viên</th>
            <th width="10%">Khóa</th>
            <th width="15%">Module</th>
            <th width="10%" align="center">Xe</th>
            <th width="8%">TT</th>
            <th width="7%" align="center">Km</th>
            <th width="7%" align="center">G.Chú</th>
            <th width="19%" align="center"></th>
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
     	<td align="center"><?= ($iT+1) ?></td>
     	<!-- <td><?= $time->ten_thoi_gian ?></td>-->
     	<td align="center"><?= CustomFunc::convertHIStoHI($time->thoi_gian_bd) ?> - <?= CustomFunc::convertHIStoHI($time->thoi_gian_kt) ?></td>
     	<!-- <td><?= CustomFunc::convertHIStoHI($time->thoi_gian_kt) ?></td>-->
     	<?php if($gioIsExist == false):?>
     	<td></td>
     	<td></td>
     	<td></td>
     	<td></td>
     	<td></td>
     	<td></td>
     	<td></td>
     	<td><?= ($model->trang_thai_duyet==KeHoach::TT_NHAP || User::hasRole('Admin') ) ? ( Html::a( '<i class="fa fa-plus"> </i> ',
            ['/daotao/tiet-hoc/create-from-ke-hoach', 
                'idkh' => $model->id,
                'idtime'=>$time->id
            ],
            [
                'class'=>'btn btn-primary',
                'title' => 'Thêm giờ học',
                'style' => 'color: white;font-size:9px',
                'role'=>'modal-remote-2'
            ]
        )):'' ?></td>
     	<?php endif;?>
     	<?php if($gioIsExist == true):?>
     	<td><?php 
     	if($model->trang_thai_duyet == KeHoach::TT_NHAP || $model->trang_thai_duyet == KeHoach::TT_CHODUYET ){
     	    echo '<span style="color:blue;cursor:pointer;" data-bs-placement="top" data-bs-toggle="tooltip" title="'.$tietHoc->hocVien->viewSoGioHocHtml().'">' . $tietHoc->hocVien->ho_ten . '</span>';
     	}else{
     	     echo $tietHoc->hocVien->ho_ten;
     	}
     	?></td>
     	<td><?= $tietHoc->hocVien->khoaHoc->ten_khoa_hoc ?></td>
     	<td><?= $tietHoc->monHoc->ten_mon /*. ($tietHoc->monHoc->ten_mon_sub?(' ('.$tietHoc->monHoc->ten_mon_sub.')'):'')*/ ?></td>
     	<td align="center">
     		<?php 
         		if(User::hasPermission('qQuanLySuKienDemXe')){
         		    echo Html::a($tietHoc->xe->bien_so_xe, 
         		        '/thuexe/lich-xe/lich-xe-gv-so-sanh?idxe='.$tietHoc->id_xe.'&menu=dt3',[
         		            'data-pjax'=>0,
         		            'target'=>'_blank',
         		            'class'=>'aBienSo'
         		        ]);
         		} else {
         		     echo $tietHoc->xe->bien_so_xe;
         		}
         		?>
     	</td>
     	<td align="center"><?= TietHoc::getLabelTinhTrangXeBadge($tietHoc->trang_thai) ?></td>
     	<td align="center"><?= $tietHoc->so_km  ?></td>
     	<td><?= $tietHoc->ghi_chu ?></td>
     	<td width="75px"><?= ($model->trang_thai_duyet==KeHoach::TT_NHAP || $model->trang_thai_duyet==KeHoach::TT_DADUYET || User::hasRole('Admin')) ? ( Html::a( '<i class="fa fa-pencil"></i> ',
            ['/daotao/tiet-hoc/update-from-ke-hoach', 
               'id' => $tietHoc->id
            ],
            [
                'class'=>'btn btn-warning',
                'title' => 'Sửa',
                'style' => 'color: white;font-size:9px',
                'role'=>'modal-remote-2'
            ]
        )):'' ?>
        <?= /**********************************/($model->trang_thai_duyet==KeHoach::TT_NHAP || $model->trang_thai_duyet==KeHoach::TT_KHONGDUYET || User::hasRole('Admin') ) ? ( Html::a( '<i class="ion-close"> </i> ',
            ['/daotao/tiet-hoc/delete-from-ke-hoach', 
               'id' => $tietHoc->id
            ],
            [
                'class'=>'btn btn-danger',
                'title' => 'Xóa giờ học',
                'style' => 'color: white;font-size:9px',
                'role'=>'modal-remote-2',
                'data-confirm-title'=>'Xác nhận xóa giờ?',
                'data-confirm-message'=>'Giờ dạy sẽ được xóa và không thể phục hồi, bạn có chắc chắn muốn tiếp tục?'
            ]
        )):'' ?>
        <?= /**********************************/($model->trang_thai_duyet==KeHoach::TT_NHAP || $model->trang_thai_duyet==KeHoach::TT_KHONGDUYET || User::hasRole('Admin') ) ? ( Html::a( '<i class="fa fa-clone"> </i> ',
            ['/daotao/tiet-hoc/copy-from-ke-hoach', 
               'id' => $tietHoc->id
            ],
            [
                'class'=>'btn btn-primary',
                'title' => 'Sao chép giờ học xuống giờ tiếp theo',
                'style' => 'color: white;font-size:9px',
                'role'=>'modal-remote-2'
            ]
        )):'' ?>
        </td>
     	<?php endif;?>
     </tr>
     
     <?php } ?>
     </tbody>
</table>