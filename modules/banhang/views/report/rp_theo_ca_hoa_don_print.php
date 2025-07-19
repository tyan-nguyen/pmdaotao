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
    				<span class="phieu-h1">DOANH THU BÁN HÀNG</span>
    			</td>    			
    		</tr>
    		<tr>
    			<td style="text-align: left;width: 50%;padding-top:10px"><span>Thời gian từ <?= CustomFunc::convertYMDHISToDMYHI($start) ?> đến <?= CustomFunc::convertYMDHISToDMYHI($end) ?></span></td>
    			<td style="text-align: left;width: 50%;padding-top:10px"><span>Nhân viên xuất báo cáo: <?= User::getCurrentUser()->getHoTen() ?></span></td>
    		</tr>
    		<tr>    			
    			<td style="text-align: left;width: 50%"><span>Nhân viên nhận hồ sơ: <?= $byuser ? User::findOne($byuser)->ho_ten : 'Tất cả' ?></span></td>
    			<td style="text-align: left;width: 50%;"><span>Sắp xếp: </span>
    				<?= $sortby=='hang'? 'Theo hạng đào tạo' : 'Theo ngày nhận hồ sơ'  ?>
    			</td>
    		</tr> 		
    	</table>
        
        
        <table class="table-content" style="width: 100%; margin-top:5px;">
        	<thead>
        		<tr>
        			<th width="40" rowspan="2">STT</th>
        			<th width="120" rowspan="2">Số hóa đơn</th>
        			<th width="120" rowspan="2">Thời gian xuất</th>
        			<th width="150" rowspan="2">Tên KH</th>
        			<th width="70" rowspan="2">Số điện thoại</th>
        			<th width="150" colspan="2" >Số tiền</th>
        			<th width="70" rowspan="2">Ghi chú</th>
        		</tr> 
        		<tr>
        			<th width="75" >Tiền mặt</th>
        			<th width="75" >Chuyển khoản</th>
        		</tr>
        		  
        	</thead> 
        	<tbody>
        
        	<?php 
        	$tongTM = 0;
        	$tongCK =0;
        	if($model==null){
        	?>
        	<tr>
            	<td colspan="7" style="text-align:center">Không có</td>
            </tr>
        	<?php 
        	} else {
        	    foreach ($model as $indexCt => $item){
        	        if($item->hinh_thuc_thanh_toan == 'TM')
        	            $tongTM += $item->tongTien;
    	            if($item->hinh_thuc_thanh_toan == 'CK')
    	                $tongCK += $item->tongTien;
            ?>
            <tr>
            	<td style="text-align:center"><?= ($indexCt+1) ?></td>
            	<td style="text-align:center"><?= $item->soHoaDon ?></td>
            	<td style="text-align:center"><?= CustomFunc::convertYMDHISToDMYHI($item->ngay_xuat) ?></td>
            	<td style="text-align:left"><?= $item->khachHang->ho_ten ?></td>
            	<td style="text-align:left"><?= $item->khachHang->so_dien_thoai ?></td>
            	<td style="text-align:right"><?= $item->hinh_thuc_thanh_toan == 'TM'?number_format($item->tongTien):'' ?></td>
            	<td style="text-align:right"><?= $item->hinh_thuc_thanh_toan == 'CK'?number_format($item->tongTien):'' ?></td>
            	<td style="text-align:left"><?= $item->ghi_chu ?></td>
            </tr>
            <?php }} ?>	
            <tr style="font-weight: bold">
            	<td colspan="5" align="right">TỔNG CỘNG</td>
            	<td align="right"><?= number_format($tongTM) ?></td>
            	<td align="right"><?= number_format($tongCK) ?></td>
            	<td></td>
            </tr>
            </tbody>
        </table>
        
        <table id="table-ky-ten" style="width: 100%; margin-top:5px;">
    		<tr>
    			<td>KẾ TOÁN</td>
    			<td></td>
    			<td>NGƯỜI NỘP</td>
    		</tr>
    		<tr>
    			<td><span class="text-13">(Ký, Họ tên)</span></td>
    			<td></td>
    			<td><span class="text-13">(Ký, Họ tên)</span></td>
    		</tr>
    		<tr>
        		<td></td>
        		<td></td>
    			<td style="padding-top:40px;font-size:13pt"><?= $byuser ? User::findOne($byuser)->ho_ten : '' ?></td>
    		</tr>
    	</table>
    	
    </div>
</div>