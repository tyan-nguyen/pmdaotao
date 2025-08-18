<?php
use yii\helpers\Html;
use app\custom\CustomFunc;
?>
<link href="/css/print-display.css" rel="stylesheet">

<div class="row text-center" style="width: 100%">
    <div class="col-md-12" style="width: 100%"> 
    	<table id="table-top" style="width: 100%">
    		<tr>
    			<td>
    				<img src="/libs/images/logo.png" width="150px" />
    			</td>
    			<td>
    				<span style="font-weight: bold; font-size:14pt;color:red">TRUNG TÂM GDNN & SHLX NGUYỄN TRÌNH</span>
    				<br/>
    				<span style="font-size:10pt"><i class="fas fa-map-marker-alt" style="color:red;margin-right:2px"></i>  Địa chỉ đăng ký: Nguyễn Đáng, Khóm 10, Phường Trà Vinh, Vĩnh Long</span>
    				<br/>
    				<span style="font-size:10pt"><i class="fas fa-home" style="color:red"></i> Địa chỉ TT: Ấp Giồng Trôm, Xã Châu Thành, Tỉnh Vĩnh Long</span>
    				<br/>
    				<span style="font-size:10pt"><i class="fas fa-globe" style="color:red"></i> Website: nguyentrinh.com.vn</span> - <span style="font-size:10pt"><i class="fas fa-phone" style="color:red"></i> ĐT: 0903 336 470</span>
    				<!-- <br/>
    				<span style="font-size:10pt"><i class="fas fa-envelope" style="color:red"></i> Email: nguyentrinh@nguyentrinh.com.vn</span> -->
    						
    				<?= $nhap ? '<span class="span-status">Bản nháp</span>' : '' ?>
    			</td>
    			
    		</tr>
    	</table>
    	
    	<table id="table-tieu-de" style="width: 100%">
    		<tr>
    			<td></td>
    			<td>
    				<span class="phieu-h1">PHIẾU THU TIỀN</span>
    				<br/><span>Ngày <?= date('d') ?> tháng <?= date('m') ?> năm <?= date('Y') ?></span>
    			</td>
    			<td>Số: <?= ($nhap && $model->ma_so_phieu==null) ? '' : CustomFunc::fillNumber($model->ma_so_phieu) ?></td>
    		</tr>
    	</table>
    	
    	<table id="table-noi-dung" style="width: 100%">
        	
    		<tr>
    			<td>Họ tên người thuê: <?= $model->lichThue->khachHang?$model->lichThue->khachHang->ho_ten:'' ?></td>
    			<td>Mã KH: <?= $model->lichThue->khachHang?$model->lichThue->khachHang->so_cccd:'' ?></td>
    		</tr>
    		<tr>
    			<td>Địa chỉ: <?= $model->lichThue->khachHang?$model->lichThue->khachHang->dia_chi:'' ?></td>
    			<td>SĐT: <?= $model->lichThue->khachHang?$model->lichThue->khachHang->so_dien_thoai:'' ?></td>
    		</tr>
    		<tr>
        			<td colspan="2">Họ tên người hướng dẫn: <?= $model->lichThue->giaoVien?$model->lichThue->giaoVien->ho_ten:'' ?> (<?= $model->lichThue->giaoVien?$model->lichThue->giaoVien->so_dien_thoai:'' ?>)</td>
        	</tr>
    		<!-- <tr>
    			<td colspan="2">Nội dung:</td>
    		</tr>-->
    		

    	</table>
    	
    	<table id="table-content" style="width: 100%; margin-top:5px;font-size:12pt;">
    		<thead>
    			<tr style="font-weight:bold">
        			<td style="width:5%">TT</td>
        			<td style="width:48%">Tên hàng</td>        			
        			<td style="width:10%">ĐVT</td>
        			<td style="width:10%">SL</td>
        			<td style="width:12%">Đơn giá</td>
        			<td style="width:15%">Thành tiền</td>
    			</tr>
    		</thead>
    		<tbody>
    			<tr>
        			<td style="text-align:center">1</td>
        			<td>
        			Thuê xe tập lái <?= $model->lichThue->xe?$model->lichThue->xe->tenXeShort:'' ?>
        			<br/>
        			(<span style="font-size:10pt;font-style:italic;">từ <?= $model->lichThue?CustomFunc::convertYMDHISToDMYHI($model->lichThue->thoi_gian_bat_dau):'' ?>
        			đến <?= $model->lichThue?CustomFunc::convertYMDHISToDMYHI($model->lichThue->thoi_gian_ket_thuc):'' ?></span>)
        			</td>        			
        			<td style="text-align:center">Giờ</td>
        			<td style="text-align:right"><?= $model->lichThue?$model->lichThue->so_gio:'' ?></td>
        			<td style="text-align:right"><?= $model->lichThue?number_format($model->lichThue->don_gia):'' ?></td>
        			<td style="text-align:right;font-weight: bold"><?= $model->lichThue?number_format($model->lichThue->tongTien):'' ?></td>
    			</tr>
    			
    			<!-- <tr style="text-align:right;font-weight: bold">
        			<td colspan="5">Tổng cộng:</td>
        			<td></td>
    			</tr>-->
    			
    		</tbody>
    	</table>
    	
    	<table id="table-noi-dung" style="width: 100%; margin-top:5px;">
    	<tr>
    			<td colspan="2">
        			<span><strong>Nội dung:</strong> Đã nộp số tiền: <?= number_format($model->so_tien, 0, ',', '.') ?> đồng (<?= $model->hinh_thuc_thanh_toan ?>)</span>
        			<span style="padding-left:10px;"></span>
        			<span>Chiết khấu: <?= number_format($model->chiet_khau, 0, ',', '.') ?> đồng </span> 
        			 			
    			<span style="padding-left:10px;"></span> 
    			<span>Còn lại: <?= number_format($model->so_tien_con_lai, 0, ',', '.') ?> đồng</span>
    			<?= $model->ghi_chu ? ('<span style="padding-left:40px;"></span>
    			Ghi chú:' . $model->ghi_chu) : '' ?> 
    			</td>
    		</tr>
    	</table>
    	
    	
    	<table id="table-ky-ten" style="width: 100%; margin-top:5px;">
    		<tr>
    			<td>NGƯỜI NỘP TIỀN</td>
    			<td></td>
    			<td>NGƯỜI THU TIỀN</td>
    		</tr>
    		<tr>
    			<td><span class="text-13">(Ký, Họ tên)</span></td>
    			<td></td>
    			<td></td>
    		</tr>
    		<tr>
        		<td></td>
        		<td></td>
    			<td style="padding-top:20px;font-size:13pt"><?= $model->nguoiTao->hoTen ?></td>
    		</tr>
    	</table>
    	
    	<table id="table-footer" style="width: 100%; margin-top:5px;">
    		<tr>
    			<td><strong>*CHÚ Ý: VUI LÒNG GIỮ LẠI PHIẾU NÀY ĐỂ ĐỐI CHIẾU VỀ SAU</strong></td>
    			<td>Ngày in: <?= date('d/m/Y H:i') ?></td>
    		</tr>
    	</table>
    	
	</div>
</div> <!-- row -->