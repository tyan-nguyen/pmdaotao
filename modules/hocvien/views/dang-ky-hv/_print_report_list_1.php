<?php
use app\modules\user\models\User;
use app\custom\CustomFunc;
use app\modules\hocvien\models\NopHocPhi;
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
        			<span style="font-size:10pt"><i class="fas fa-map-marker-alt" style="color:red;margin-right:2px"></i>  Địa chỉ đăng ký: Nguyễn Đáng, Khóm 10, Phường Trà Vinh, Vĩnh Long</span>
        			<br/>
        			<span style="font-size:10pt"><i class="fas fa-home" style="color:red"></i> Địa chỉ TT: Ấp Giồng Trôm, Xã Châu Thành, Tỉnh Vĩnh Long</span>
        			<br/>
        			<span style="font-size:10pt"><i class="fas fa-globe" style="color:red"></i> Website: nguyentrinh.com.vn</span> - <span style="font-size:10pt"><i class="fas fa-phone" style="color:red"></i> ĐT: 0903 336 470</span>
        			<br/>
        			<span style="font-size:10pt"><i class="fas fa-envelope" style="color:red"></i> Email: nguyentrinh@nguyentrinh.com.vn</span>
        		</td>
        		
        	</tr>
        </table>
        
        <table id="table-tieu-de-1" style="width: 100%">
    		<tr>
    		
    			<td>
    				<span class="phieu-h1">BÁO CÁO TIẾP NHẬN HỒ SƠ</span>
    				<br/><span>Thời gian từ <?= CustomFunc::convertYMDHISToDMYHI($start) ?> đến <?= CustomFunc::convertYMDHISToDMYHI($end) ?></span>
    				<br/><span>Nhân viên lập báo cáo: <?= User::getCurrentUser()->getHoTen() ?></span>
    				<br/><span>Nhân viên nhận hồ sơ: <?= $byuser ? User::findOne($byuser)->getHoTen(): 'Tất cả' ?></span>
    			</td>
    			
    		</tr>
    		
    	</table>
        
        <div class="row">
        	<div class="col-md-12" style="text-align: right">TỔNG NỢ CÒN LẠI (tính đến <?= CustomFunc::convertYMDHISToDMYHI($end) ?>): <strong><?= ($byuser && User::findOne($byuser)!=null) ? number_format(User::getNoConLaiCuaNhanVien($byuser,$end)) : number_format(User::getNoConLaiCuaTatCaHocVien($end)) ?></strong></div>
        </div>
        
        <table class="table-content" style="width: 100%; margin-top:5px;">
        	<thead>
        		<tr>
        			<th rowspan="3">STT</th>
        			<th rowspan="3">Số phiếu</th>
        			<th rowspan="3">Họ và tên</th>
        			<th rowspan="3">Mã KH</th>
        			<th rowspan="3">Hạng đào tạo</th>
        			
        			<!-- <th colspan="9">Lịch sử TT</th> -->
        			<th colspan="6">Lần thanh toán</th>
        			
        			<th colspan="6">Kỳ thu hiện tại</th>
        			
        			<!-- <th rowspan="3">Loại TT</th>
        			
        			<th colspan="2">Số tiền</th>
        			
        			<th rowspan="3">Chiết khấu</th>
        			<th rowspan="3">Còn lại</th>
        			<th rowspan="3">Nhân viên</th> -->
        		</tr> 
        		<tr>
        		
        			<th colspan="3">Lần 1</th>
        			<th colspan="3">Lần 2</th>
        			<!-- <th colspan="3">Lần 3</th> -->
        			
        			<th rowspan="2">Diễn giải</th>
        			
        			<th colspan="2">Số tiền</th>
        			
        			<th rowspan="2">Chiết khấu</th>
        			<th rowspan="2">Còn lại</th>
        			<th rowspan="2">Thu hộ</th>
        			<th rowspan="2">Nhân viên</th>
        			
        			<!-- <th rowspan="2">Tiền mặt</th>
        			<th rowspan="2">Chuyển khoản</th> -->
        		</tr>  
        		
        		<tr>
        		
        			<th>TM</th>
        			<th>TTTK</th>
        			<th>CK <br/>(Giảm)</th>
        			
        			<th>TM</th>
        			<th>TTTK</th>
        			<th>CK <br/>(Giảm)</th>
        			
        			<!-- <th>TM</th>
        			<th>TTTK</th>
        			<th>CK</th> -->
        			
        			<th>Tiền mặt</th>
        			<th>Chuyển khoản</th>
        			
        			
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
        	        
        	        $numHis = NopHocPhi::find()->where(['id_hoc_vien'=>$item->id_hoc_vien])
                    	        ->andWhere('id < ' . $item->id)
                    	        ->orderBy(['id'=>SORT_ASC])->count();
        	        $itemHis = NopHocPhi::find()->where(['id_hoc_vien'=>$item->id_hoc_vien])
        	                   ->andWhere('id < ' . $item->id)
        	                   ->orderBy(['id'=>SORT_ASC])->all();
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
            	
            	<?php 
            	//lich su thanh toan
            	if($numHis == 0){
            	    //echo '<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>';
            	    echo '<td></td><td></td><td></td><td></td><td></td><td></td>';
            	} else {
            	    if($numHis == 1){
                    	foreach ($itemHis as $indexHis=>$iHis){
                    	    $ckHtml = '<td></td>';
                    	    if($iHis->chiet_khau > 0){
                    	        $ckHtml = '<td>'.number_format($iHis->chiet_khau).'</td>';
                    	    }
                    	    if($iHis->hinh_thuc_thanh_toan == 'TM'){
                    	        echo '<td>'.number_format($iHis->so_tien_nop).'</td><td></td>'.$ckHtml;
                    	    } else if($iHis->hinh_thuc_thanh_toan == 'CK'){
                    	        echo '<td></td><td>'.number_format($iHis->so_tien_nop).'</td>'.$ckHtml;
                    	    }
                    	    
                    	   // echo '<td></td><td></td><td></td><td></td><td></td><td></td>';
                    	    echo '<td></td><td></td><td></td>';
                    	}                	
            	    } else if($numHis == 2){
            	        foreach ($itemHis as $indexHis=>$iHis){
            	            $ckHtml = '<td></td>';
            	            if($iHis->chiet_khau > 0){
            	                $ckHtml = '<td>'.number_format($iHis->chiet_khau).'</td>';
            	            }
            	            if($iHis->hinh_thuc_thanh_toan == 'TM'){
            	                echo '<td>'.number_format($iHis->so_tien_nop).'</td><td></td>'.$ckHtml;
            	            } else if($iHis->hinh_thuc_thanh_toan == 'CK'){
            	                echo '<td></td><td>'.number_format($iHis->so_tien_nop).'</td>'.$ckHtml;
            	            }            	            
            	        }    
            	        //echo '<td></td><td></td><td></td>';
            	    }
            	}
            	    
            	?>
            
            	
            	<td style="text-align:center"><?= $item->loaiNop ?></td>
            	<td style="text-align:right"><?= $item->hinh_thuc_thanh_toan=='TM' ? number_format($item->so_tien_nop) : '' ?></td>
            	<td style="text-align:right"><?= $item->hinh_thuc_thanh_toan=='CK' ? number_format($item->so_tien_nop) : '' ?></td>
            	<td style="text-align:right"><?= number_format($item->chiet_khau) ?></td>
            	<td style="text-align:right"><?= number_format($item->so_tien_con_lai) ?></td>
            	<td style="text-align:right"><?= number_format($item->so_tien_thu_ho) ?></td>
            	<td style="text-align:center"><?= User::findOne($item->nguoi_tao)->ho_ten ?></td>
            </tr>
            <?php }} ?>	
            <tr style="font-weight: bold">
            	<td colspan="12" align="right">TỔNG CỘNG</td>
            	<td align="right"><?= number_format($modelSoTienNopTM) ?></td>
            	<td align="right"><?= number_format($modelSoTienNopCK) ?></td>
            	<td align="right"><?= number_format($modelSoTienChietKhau) ?></td>
            	<td align="right"><?php /*number_format($tongTienConLai)*/ ?></td>
            	<td align="right"><?= number_format($modelSoTienThuHo) ?></td>
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