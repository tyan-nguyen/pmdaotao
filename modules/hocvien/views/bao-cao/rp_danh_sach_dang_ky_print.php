<?php
use app\modules\user\models\User;
use app\custom\CustomFunc;
use app\modules\hocvien\models\HangDaoTao;
use app\modules\hocvien\models\base\HocVienBase;
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
    				<span class="phieu-h1">BÁO CÁO DANH SÁCH TIẾP NHẬN HỌC VIÊN</span>
    				<br/><span>Thời gian từ <?= CustomFunc::convertYMDHISToDMYHI($start) ?> đến <?= CustomFunc::convertYMDHISToDMYHI($end) ?></span>
    				<?= $byhangdaotao==null?'':'<br/><span>Hạng: '.HangDaoTao::findOne($byhangdaotao)->ten_hang.'</span>' ?>
    				<br/><span>Nhân viên lập báo cáo: <?= User::getCurrentUser()->getHoTen() ?></span>
    				<br/><span>Nhân viên nhận hồ sơ: <?= $byuser ? User::findOne($byuser)->ho_ten : 'Tất cả' ?></span>
    				<br/><span>Nơi đăng ký: <?= $byaddress ? HocVienBase::getLabelNoiDangKyOther($byaddress) : 'Tất cả' ?></span>
    			</td>
    			
    		</tr>
    		
    	</table>
        
        
        <table class="table-content" style="width: 100%; margin-top:5px;">
        	<thead>
        		<tr>
        			<th width="40">STT</th>
        			<th width="120">Họ và tên</th>
        			<th width="40">Giới tính</th>
        			<th width="100">CCCD</th>
        			<th width="70">Số điện thoại</th>
        			<th width="180">Địa chỉ</th>
        			<th width="180">Hạng đào tạo</th>
        			<th width="100">Ngày tiếp nhận</th>
        			<th width="80">Học phí đã nộp</th>
        			<!-- <th width="100">Nơi đăng ký</th> -->
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
        	    foreach ($model as $indexCt => $item){
            ?>
            <tr>
            	<td style="text-align:center"><?= ($indexCt+1) ?></td>
            	<td style="text-align:left"><?= $item->ho_ten ?></td>
            	<td style="text-align:center"><?= $item->gioi_tinh == 1 ? 'Nam' : 'Nữ' ?></td>
            	<td style="text-align:center"><?= $item->so_cccd ?></td>
            	<td style="text-align:center"><?= $item->so_dien_thoai ?></td>
            	<td style="text-align:left"><?= $item->dia_chi ?></td>
            	<td style="text-align:left"><?= $item->hangDaoTao->ten_hang ?></td>
            	<td style="text-align:left"><?= CustomFunc::convertYMDHISToDMYHI($item->thoi_gian_tao) ?></td>
            	<!-- <td style="text-align:left"><?= $item->noi_dang_ky ?></td>-->
            	<td style="text-align:right"><?= number_format($item->tongtiennop) ?></td>
            </tr>
            <?php }} ?>	
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
    			<td style="padding-top:40px;font-size:13pt"><?= $byuser ? User::findOne($byuser)->ho_ten : '' ?></td>
    		</tr>
    	</table>
    	
    </div>
</div>