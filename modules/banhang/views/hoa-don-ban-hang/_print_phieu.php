<?php
use yii\helpers\Html;
use app\custom\CustomFunc;
$custom = new CustomFunc();
?>
<!-- <link href="/css/print-hoa-don.css" rel="stylesheet"> -->
<div class="row text-center" style="width: 100%">
    <div class="col-md-12" style="width: 100%"> 
    	<table id="table-top" style="width: 100%">
    		<tr>
    			<td>
    				<img src="/libs/images/logo.png" width="100px" />
    			</td>
    			<!--<td>
    				<span style="font-weight: bold; font-size:10pt">DNTN SX-TM NGUYỄN TRÌNH</span>
    				<br/>
    				<span style="font-size:9pt">ĐC: Nguyễn Đáng, Khóm 10, P.9, TP.TV</span>
    				<br/>
    				<span style="font-size:9pt">ĐT: 0903.794.530 - 0903.794.531 - 0903.794.532</span>
    				
    			</td>
    			<td width="100px">
    				<div><span style="font-size:10pt"><?= $model->soHoaDon ?></span></div>
    				<div style="margin-top: 5px;">
    					<span class="span-status" style="font-size:9pt"><?= $model->getDmTrangThaiLabel($model->trang_thai) ?></span> 					</div>
    			</td>-->
    			<td>
    				<span style="font-weight: bold; font-size:10pt;color:red">TRUNG TÂM GDNN & SHLX NGUYỄN TRÌNH</span>
    				<br/>
    				<span style="font-size:9pt"><i class="fas fa-map-marker-alt" style="color:red;margin-right:2px"></i>  Địa chỉ đăng ký: Nguyễn Đáng, Khóm 10, Phường Trà Vinh, Vĩnh Long</span>
    				<br/>
    				<span style="font-size:9pt"><i class="fas fa-home" style="color:red"></i> Địa chỉ TT: Ấp Giồng Trôm, Xã Châu Thành, Tỉnh Vĩnh Long</span>
    				<br/>
    				<span style="font-size:9pt"><i class="fas fa-globe" style="color:red"></i> Website: nguyentrinh.com.vn</span> - <span style="font-size:9pt"><i class="fas fa-phone" style="color:red"></i> ĐT: 0903 336 470</span>
    				<!-- <br/>
    				<span style="font-size:9pt"><i class="fas fa-envelope" style="color:red"></i> Email: nguyentrinh@nguyentrinhtravinh.com.vn</span> -->
    						
    				
    			</td>
    			<td>
    				<span style="font-size:9pt">Số HĐ: <?= $model->soHoaDon ?></span><br/>
    				<span class="span-status" style="font-size:9pt"><?= $model->getDmTrangThaiLabel($model->trang_thai) ?></span>
    			</td>
    		</tr>
    	</table>
    	
    	<table style="width: 100%; margin-top:5px;">
    		<tr>
    			<td style="text-align: center"><span style="font-size:20pt;font-weight:bold">PHIẾU THU</span></td>
    		</tr>
    	</table>
    	
    	<table id="table-info" style="width: 100%; margin-top:0px;">
    		<tr>
    			<td>
    				Khách hàng: <?= $model->khachHang?$model->khachHang->ho_ten:'' ?>			
    			</td>
    			<td align="right">
    				SĐT: <?= $model->khachHang?$model->khachHang->so_dien_thoai:'' ?>	
    			</td>
    		</tr>
    		<tr>
    			<td colspan="2">
    				Địa chỉ: <?= $model->khachHang?$model->khachHang->diaChi:'' ?>	
    			</td>
    			<!-- <td>
    				Email: <?php // $model->khachHang?$model->khachHang->email:'' ?>
    			</td>-->
    		</tr>
    		
    	</table>
    	
    	<table id="table-content" style="width: 100%; margin-top:5px;">
    		<thead>
    			<tr style="font-weight:bold">
        			<td style="width:3%">Số TT</td>
        			<td style="width:12%">Mã số</td>
        			<td style="width:30%">Tên hàng</td>        			
        			<td style="width:10%">ĐVT</td>
        			<td style="width:10%">Số lượng</td>
        			<td style="width:10%">Đơn giá<br/>(VND)</td>
        			<td style="width:10%">CK<br/>(VND)</td>
        			<td style="width:15%">Thành tiền<br/>(VND)</td>
    			</tr>
    		</thead>
    		<tbody>
    			<?php 
    			$stt = 0;
    			foreach ($model->hoaDonChiTiets as $iVT=>$vt){
    			    $stt++;
    			?>
    			<tr>
        			<td style="text-align:center"><?= $stt ?></td>
        			<td style="text-align:center"><?= $vt->hangHoa->ma_hang_hoa ?></td>
        			<td><?= $vt->hangHoa->ten_hang_hoa ?></td>        			
        			<td style="text-align:center"><?= $vt->hangHoa->donViTinh->ten_dvt ?></td>
        			<td style="text-align:right"><?= $vt->soLuong ?></td>
        			<td style="text-align:right"><?= number_format($vt->donGia) ?></td>
        			<td style="text-align:right"><?= number_format($vt->chietKhau) ?></td>
        			<td style="text-align:right;font-weight: bold"><?= number_format($vt->thanhTien) ?></td>
        			<!-- <td style="text-align:center"><?= $vt->ghi_chu ?></td>-->
    			</tr>
    			<?php 
    			}
    			?>
    			
    			<tr style="text-align:right;font-weight: bold">
        			<td colspan="7">Tổng cộng:</td>
        			<td><?= number_format($model->tongTien) ?></td>
    			</tr>
    			
    		</tbody>
    	</table>
    	
    	<p style="margin-top:6pt;font-size:11pt;font-style: italic;">Tổng số tiền bằng chữ: <strong><?= $custom->chuyenSoTienThanhChu($model->tongTien) ?> đồng</strong> - HTTT: <strong><?= $model->getDmHinhThucThanhToanLabel($model->hinh_thuc_thanh_toan) ?></strong></p>
    	
    	<table id="table-ky-ten" style="width: 100%; margin-top:5px;">
    		<tr>
    			<td style="text-align:right;font-weight:normal;font-style:italic;font-size:11pt">Vĩnh Long, ngày <?= date('d') ?> tháng <?= date('m') ?> năm <?= date('Y') ?></td>
    		</tr>
    	</table>
    	
    	<table id="table-ky-ten" style="width: 100%; margin-top:5px;">
    		<tr>
    			<td style="font-size: 10pt">NGƯỜI NỘP TIỀN</td>
    			<td></td>
    			<td style="font-size: 10pt">NGƯỜI THU TIỀN</td>
    		</tr>
    		<!-- <tr>
    			<td><span style="font-size: 8pt">(Ký, Họ tên)</span></td>
    			<td></td>
    			<td><span style="font-size: 8pt">(Ký, Họ tên)</span></td>
    		</tr> -->
    		<tr>
        		<td></td>
        		<td></td>
    			<td style="padding-top:35px;font-size:10pt"><?= $model->nguoiTao->hoTen ?></td>
    		</tr>
    	</table>
    	
    	<table id="table-footer" style="width: 100%; margin-top:0px;">
    		<tr>
    			<td style="font-size: 8pt"><strong>*CHÚ Ý: VUI LÒNG GIỮ LẠI PHIẾU NÀY ĐỂ ĐỐI CHIẾU VỀ SAU</strong></td>
    			<td style="font-size: 8pt">Ngày in: <?= date('d/m/Y H:i') ?></td>
    		</tr>
    	</table>
    	
    	
    	
    	
    	
    	   
    </div>
</div> <!-- row -->