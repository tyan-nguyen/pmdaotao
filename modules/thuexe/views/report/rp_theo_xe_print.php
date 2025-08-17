<?php
use app\modules\user\models\User;
use app\custom\CustomFunc;
use app\modules\hocvien\models\HangDaoTao;
use app\modules\hocvien\models\base\HocVienBase;
use app\modules\khoahoc\models\KhoaHoc;
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
        
        <table id="table-tieu-de-1" style="width: 100%">
    		<tr>    		
    			<td colspan="2">
    				<span class="phieu-h1">BÁO CÁO DOANH THU THUÊ XE</span>
    			</td>    			
    		</tr>
    		<tr>
    			<td style="text-align: left;width: 50%;padding-top:10px">
    			<?php if($loaibaocao==0){?>
    			<span>- Thời gian từ <?= CustomFunc::convertYMDHISToDMYHI($start) ?> đến <?= CustomFunc::convertYMDHISToDMYHI($end) ?></span>
    			<br/><span>- Nhân viên xuất báo cáo: <?= User::getCurrentUser()->getHoTen() ?></span>
    			<?php } else {?>
    			Thời gian: Tất cả thời gian
    			<?php } ?>
    			</td>
    			<td style="text-align: left;width: 50%;padding-top:10px"></td>
    		</tr>
    			
    	</table>
        
        
        <table class="table-content" style="width: 100%; margin-top:5px;">
        	<thead>
        		<tr>
        			<th width="40">STT</th>
        			<th width="80">Xe số</th>
        			<th width="80">Hạng xe</th>
        			<th width="150">Biển số</th>
        			<th width="80">Số giờ</th>
        			<th width="80">Đơn giá</th>
        			<th width="80">Tổng tiền</th>
        		</tr> 
        		  
        	</thead> 
        	<tbody>
        
        	<?php 
        	$tongGio = 0;
        	$tongTienGio =0;
        	if($model==null){
        	?>
        	<tr>
            	<td colspan="7" style="text-align:center">Không có</td>
            </tr>
        	<?php 
        	} else {
        	    foreach ($model as $indexCt => $item){
        	       $tongGio += $item->tongGio;
        	       $tongTienGio += $item->tongTienGio;
            ?>
            <tr>
            	<td style="text-align:center"><?= ($indexCt+1) ?></td>
            	<td style="text-align:center"><?= $item->xe->ma_so ?></td>
            	<td style="text-align:center"><?= $item->xe->loaiXe->ten_loai_xe ?></td>
            	<td style="text-align:center"><?= $item->xe->bien_so_xe ?></td>
            	<td style="text-align:right"><?= $item->tongGio ?></td>
            	<td style="text-align:right"><?= number_format($item->xe->giaXeThue) ?></td>
            	<td style="text-align:right"><?= number_format($item->tongTienGio) ?></td>
            </tr>
            <?php }} ?>	
            <tr style="font-weight: bold">
            	<td colspan="4" align="right">TỔNG CỘNG</td>
            	<td align="right"><?= $tongGio ?></td>
            	<td></td>
            	<td align="right"><?= number_format($tongTienGio) ?></td>
            </tr>
            </tbody>
        </table>
        
        <table id="table-ky-ten" style="width: 100%; margin-top:5px;">
    		<tr>
    			<td></td>
    			<td></td>
    			<td>NGƯỜI LẬP BÁO CÁO</td>
    		</tr>
    		<tr>
    			<td></td>
    			<td></td>
    			<td><span class="text-13">(Ký, Họ tên)</span></td>
    		</tr>
    		<tr>
        		<td></td>
        		<td></td>
    			<td style="padding-top:40px;font-size:13pt"><?= User::getCurrentUser()->getHoTen() ?></td>
    		</tr>
    	</table>
        
        
    	
    </div>
</div>