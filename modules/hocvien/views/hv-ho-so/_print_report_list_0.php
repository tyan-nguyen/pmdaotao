<?php
use app\modules\user\models\User;
use app\custom\CustomFunc;
?>

<link href="/css/print-display.css" rel="stylesheet">

<div class="row text-center" style="width: 100%">
    <div class="col-md-12" style="width: 100%"> 
        <table id="table-top" style="width: 100%">
        	<tr>
        		<td>
        			<img src="/libs/images/logo.png" width="175px" />
        		</td>
        		<td>
        			<span style="font-weight: bold; font-size:14pt;color:red">TRUNG TÂM GDNN & SHLX NGUYỄN TRÌNH</span>
        			<br/>
        			<span style="font-size:10pt"><i class="fas fa-map-marker-alt" style="color:red;margin-right:2px"></i>  Địa chỉ đăng ký: Nguyễn Đáng, Khóm 10, Phường 9, TP Trà Vinh</span>
        			<br/>
        			<span style="font-size:10pt"><i class="fas fa-home" style="color:red"></i> Địa chỉ TT: Ấp Giồng Trôm, X. Mỹ Chánh, H. Châu Thành, T. Trà Vinh</span>
        			<br/>
        			<span style="font-size:10pt"><i class="fas fa-globe" style="color:red"></i> Website: nguyentrinh.com.vn</span> - <span style="font-size:10pt"><i class="fas fa-phone" style="color:red"></i> ĐT: 0903 336 470</span>
        			<br/>
        			<span style="font-size:10pt"><i class="fas fa-envelope" style="color:red"></i> Email: nguyentrinh@nguyentrinhtravinh.com.vn</span>
        		</td>
        		
        	</tr>
        </table>
        
        <table id="table-tieu-de-1" style="width: 100%">
    		<tr>
    		
    			<td>
    				<span class="phieu-h1">BÁO CÁO TIẾP NHẬN HỒ SƠ</span>
    				<br/><span>Thời gian từ <?= CustomFunc::convertYMDHISToDMYHI($start) ?> đến <?= CustomFunc::convertYMDHISToDMYHI($end) ?></span>
    				<br/><span>Nhân viên: <?= User::getCurrentUser()->getHoTen() ?></span>
    			</td>
    			
    		</tr>
    		
    	</table>
        
        
        <table class="table-content" style="width: 100%; margin-top:5px;">
        	<thead>
        		<tr>
        			<th width="40" rowspan="2">STT</th>
        			<th width="70" rowspan="2">Số phiếu</th>
        			<th width="120" rowspan="2">Họ và tên</th>
        			<th width="70" rowspan="2">Mã KH</th>
        			<th width="100" rowspan="2">Hạng đào tạo</th>
        			<th width="70" rowspan="2">Loại TT</th>
        			<th width="70" colspan="2">Số tiền</th>
        			<th width="70" rowspan="2">Chiết khấu</th>
        			<th width="70"  rowspan="2">Còn lại</th>
        			<th width="70"  rowspan="2">Nhân viên</th>
        		</tr> 
        		<tr>
        			<th width="70">Tiền mặt</th>
        			<th width="70">Chuyển khoản</th>
        		</tr>   
        	</thead> 
        	<tbody>
        
        	<?php 
        	$tongTienConLai = 0;
        	if($model==null){
        	?>
        	<tr>
            	<td colspan="7" style="text-align:center">Không có</td>
            </tr>
        	<?php 
        	} else {
        	    foreach ($model as $indexCt => $item){
        	        //$tongConLai = $item->hocVien->getHocPhi()->hoc_phi - $item->so_tien_nop;
        	        //$tongTienConLai += $tongConLai;
        	        $tongTienConLai += $item->so_tien_con_lai;
            ?>
            <tr>
            	<td style="text-align:center"><?= ($indexCt+1) ?></td>
            	<td style="text-align:center"><?= $item->ma_so_phieu==null ? '' : CustomFunc::fillNumber($item->ma_so_phieu) ?></td>
            	<td style="text-align:left"><?= $item->hocVien?$item->hocVien->ho_ten:'' ?></td>
            	<td style="text-align:left"><?= $item->hocVien?$item->hocVien->so_cccd:'' ?></td>
            	<td style="text-align:left"><?= $item->hocVien?$item->hocVien->hang->ten_hang:'' ?></td>
            	<td style="text-align:center"><?= $item->loaiNop ?></td>
            	<td style="text-align:right"><?= $item->hinh_thuc_thanh_toan=='TM' ? number_format($item->so_tien_nop) : '' ?></td>
            	<td style="text-align:right"><?= $item->hinh_thuc_thanh_toan=='CK' ? number_format($item->so_tien_nop) : '' ?></td>
            	<td style="text-align:right"><?= number_format($item->chiet_khau) ?></td>
            	<td style="text-align:right"><?= number_format($item->so_tien_con_lai) ?></td>
            	<td style="text-align:center"><?= User::findOne($item->nguoi_tao)->ho_ten ?></td>
            </tr>
            <?php }} ?>	
            <tr style="font-weight: bold">
            	<td colspan="6" align="right">TỔNG CỘNG</td>
            	<td align="right"><?= number_format($modelSoTienNopTM) ?></td>
            	<td align="right"><?= number_format($modelSoTienNopCK) ?></td>
            	<td align="right"><?= number_format($modelSoTienChietKhau) ?></td>
            	<td align="right"><?= number_format($tongTienConLai) ?></td>
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