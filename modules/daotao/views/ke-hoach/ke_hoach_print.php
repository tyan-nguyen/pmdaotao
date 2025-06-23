<?php
use app\modules\user\models\User;
use app\custom\CustomFunc;
use app\modules\hocvien\models\HangDaoTao;
use app\modules\hocvien\models\base\HocVienBase;
use app\modules\daotao\models\DmThoiGian;
use app\modules\daotao\models\TietHoc;
use app\modules\daotao\models\KeHoach;
use yii\helpers\Html;
?>

<link href="/css/print-display.css" rel="stylesheet">

<div class="row text-center" style="width: 100%">
    <div class="col-md-12" style="width: 100%"> 
    	<table id="table-top" style="width: 100%">
        	<tr>
        		<td style="font-weight: bold; text-align: center;font-size: 13pt;width: 40%">TRUNG TÂM GDNN & SHLX NGUYỄN TRÌNH</td>
        		<td></td>
        	</tr>
        	<tr>
        		<td style="font-weight: bold; text-align: center;font-size: 13pt;width: 40%">***</td>
        		<td></td>
        	</tr>
       	</table>
        <!-- <table id="table-top" style="width: 100%">
        	<tr>
        		<td>
        			<img src="/libs/images/logo.png" width="175px" />
        		</td>
        		<td>
        			<span style="font-weight: bold; font-size:14pt;color:red">TRUNG TÂM GDNN & SHLX NGUYỄN TRÌNH</span>
        			<br/>
        			<span style="font-size:10pt"><i class="fas fa-map-marker-alt" style="color:red;margin-right:2px"></i> Địa chỉ đăng ký: Nguyễn Đáng, Khóm 10, Phường 9, TP Trà Vinh</span>
        			<br/>
        			<span style="font-size:10pt"><i class="fas fa-home" style="color:red"></i> Địa chỉ TT: Ấp Giồng Trôm, X. Mỹ Chánh, H. Châu Thành, T. Trà Vinh</span>
        			<br/>
        			<span style="font-size:10pt"><i class="fas fa-globe" style="color:red"></i> Website: nguyentrinh.com.vn</span> - <span style="font-size:10pt"><i class="fas fa-phone" style="color:red"></i> ĐT: 0903 336 470</span>
        			<br/>
        			<span style="font-size:10pt"><i class="fas fa-envelope" style="color:red"></i> Email: nguyentrinh@nguyentrinhtravinh.com.vn</span>
        		</td>
        		
        	</tr>
        </table> -->
        
        <!-- <table id="table-tieu-de-1" style="width: 100%">
    		<tr>    		
    			<td colspan="2">
    				<span class="phieu-h1">KẾ HOẠCH GIẢNG DẠY VÀ SỬ DỤNG XE</span>
    			</td>    			
    		</tr>
    		<tr>
    			<td style="text-align: left;width: 50%;padding-top:10px">
    				<span>Ngày <?= CustomFunc::convertYMDToDMY($model->ngay_thuc_hien)?></span>
    			</td>
    			<td style="text-align: left;width: 50%;padding-top:10px"><span>Giáo viên: <?= $model->giaoVien?$model->giaoVien->ho_ten:''?></span></td>
    		</tr>
    		 		
    	</table>-->
    	
    	<!-- <table id="table-tieu-de-1" style="width: 100%">
    		<tr>    		
    			<td>
    				<span class="phieu-h1">KẾ HOẠCH GIẢNG DẠY VÀ SỬ DỤNG XE</span>
    			</td>    			
    		</tr>
    		<tr>
    			<td>Giáo viên: <?= $model->giaoVien?$model->giaoVien->ho_ten:''?></td>
    		</tr>
    		<tr>
    			<td>Ngày thực hiện: <?= CustomFunc::convertYMDToDMY($model->ngay_thuc_hien)?></td>
    		</tr>
    		<tr>
    			<td>Trạng thái: <?= KeHoach::getLabelTrangThaiOther($model->trang_thai_duyet)?></td>
    		</tr>		
    	</table>-->
    	
    	<table id="table-tieu-de-1" style="width: 100%">
    		<tr>    		
    			<td>
    				<span class="phieu-h1">KẾ HOẠCH GIẢNG DẠY VÀ SỬ DỤNG XE</span>
    			</td>    			
    		</tr>
    		<tr>
    			<td>
    				Giáo viên: <?= $model->giaoVien?$model->giaoVien->ho_ten:''?> 
    				<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Ngày thực hiện: <?= CustomFunc::convertYMDToDMY($model->ngay_thuc_hien)?>
    				<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Trạng thái: <?= KeHoach::getLabelTrangThaiOther($model->trang_thai_duyet)?>
    			</td>
    		</tr>
    			
    	</table>
        
        
        <table class="table-content" style="width: 100%; margin-top:5px;">
        	<thead>
        		<tr>
                	<th align="center">STT</th>
                    <!-- <th>Giờ dạy</th>-->
                    <th align="center">Từ giờ</th>
                    <th align="center">Đến giờ</th>
                    <th align="center">Học viên</th>
                    <th align="center">Module</th>
                    <th align="center">Xe</th>
                    <th align="center">Trạng thái</th>
                    <th align="center">Km</th>
                    <th align="center">Ghi chú</th>
                </tr>
        		  
        	</thead> 
        	<tbody>
        
        	<?php 
        	if($model==null){
        	?>
        	<tr>
            	<td colspan="7" style="text-align:center">Không có</td>
            </tr>
        	<?php 
        	} else {
            ?>
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
             	<td align="center"><?= CustomFunc::convertHIStoHI($time->thoi_gian_bd) ?></td>
             	<td align="center"><?= CustomFunc::convertHIStoHI($time->thoi_gian_kt) ?></td>
             	<?php if($gioIsExist == false):?>
             	<td></td>
             	<td></td>
             	<td align="center"></td>
             	<td></td>
             	<td align="center"></td>
             	<td></td>
             	<?php endif;?>
             	<?php if($gioIsExist == true):?>
             	<td><?= $tietHoc->hocVien->ho_ten ?></td>
             	<td><?= $tietHoc->monHoc->ten_mon . ($tietHoc->monHoc->ten_mon_sub?(' ('.$tietHoc->monHoc->ten_mon_sub.')'):'') ?></td>
             	<td align="center"><?= $tietHoc->xe->bien_so_xe ?></td>
             	<td><?= TietHoc::getLabelTinhTrangXeBadge($tietHoc->trang_thai) ?></td>
             	<td align="center"><?= $tietHoc->so_km  ?></td>
             	<td><?= $tietHoc->ghi_chu ?></td>
             	<?php endif;?>
             </tr>
             
             <?php } ?>
            <?php } ?>	
            </tbody>
        </table>
        
        <table id="table-ky-ten" style="width: 100%; margin-top:5px;">
        	<!-- <tr>
        		<td colspan="3" style="text-align: right;font-style: italic;">Trà Vinh, ngày <?= date('d') ?> tháng <?= date('m') ?> năm <?= date('Y') ?></td>
        	</tr>-->
    		<tr>
    			<td style="text-align: center;font-weight: bold;font-style: normal;"></td>
    			<td></td>
    			<td style="text-align: center;font-weight: bold;font-style: normal;">NGƯỜI LẬP</td>
    		</tr>
    		<tr>
    			<td><span class="text-13"></span></td>
    			<td></td>
    			<td><span class="text-13">(Ký, Họ tên)</span></td>
    		</tr>
    		<tr>
        		<td style="padding-top:40px;font-size:13pt"></td>
        		<td></td>
    			<td style="padding-top:40px;font-size:13pt"><?php /* $byuser ? User::findOne($byuser)->ho_ten : ''*/ ?><strong><?= $model->giaoVien?$model->giaoVien->ho_ten:''?></strong></td>
    		</tr>
    	</table>
    	
    </div>
</div>