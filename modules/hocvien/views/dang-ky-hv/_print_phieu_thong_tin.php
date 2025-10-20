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
    						
    				<?= $nhap ? '<span class="span-status">Bản nháp</span>' : '' ?>
    			</td>
    			
    		</tr>
    	</table>
    	
    	<table id="table-tieu-de" style="width: 100%">
    		<tr>
    			<td></td>
    			<td>
    				<span class="phieu-h1">BIÊN LAI THU TIỀN</span>
    				<br/><span>Ngày <?= date('d') ?> tháng <?= date('m') ?> năm <?= date('Y') ?></span>
    			</td>
    			<td>Số: <?= ( ($nhap && $model->ma_so_phieu==null) ? '' : CustomFunc::fillNumber($model->ma_so_phieu) ) ?> <br/><span style="font-size:9pt">(<?= ($model->hocVien&&$model->nguoiTao)?$model->hocVien->getLabelNoiDangKy($model->nguoiTao->noi_dang_ky):'' ?>)</span> </td>
    		</tr>
    	</table>
    	
    	<table id="table-noi-dung" style="width: 100%">
    		<tr>
    			<td>Họ tên học viên: <?= $model->hocVien->ho_ten ?></td>
    			<td>Mã KH: <?= CustomFunc::fillNumber($model->hocVien->so_cccd) ?></td>
    		</tr>
    		<tr>
    			<td>Địa chỉ: <?= $model->hocVien->dia_chi ?></td>
    			<td>SĐT: <?= $model->hocVien->so_dien_thoai ?></td>
    		</tr>
    		<tr>
    			<td colspan="2">Nội dung: Thu <?= $phanTram ?> học phí đăng ký học <?= $model->hocVien->hangDaoTao ? $model->hocVien->hangDaoTao->ten_hang : '-' ?></td>
    		</tr>
    		<tr>
    			<td colspan="2">
        			<span>Số tiền: <?= number_format($model->so_tien_nop, 0, ',', '.') ?> đồng </span>
        			<span style="padding-left:40px;"></span>
        			<span>Chiết khấu: <?= number_format($model->chiet_khau, 0, ',', '.') ?> đồng </span> 
        			<span style="padding-left:40px;"></span><span>Hình thức TT: <?= $model->getHinhThucThanhToan() ?></span>    			
    			 </td>
    		</tr>
    		<tr>
    			<td colspan="2">
    			Còn lại: <?= number_format($model->so_tien_con_lai, 0, ',', '.') ?> đồng
    			<?= $model->ghi_chu ? ('<span style="padding-left:40px;"></span>
    			Ghi chú:' . $model->ghi_chu) : '' ?>
    			</td>
    		</tr>
    		<?php if(!in_array($model->hocVien->id_hang, array(7,8,9,10) )):?>
    		<tr>
    			<td colspan="2">Kèm theo: 01 đồng phục, 01 thẻ học viên</td>
    		</tr>
    		<?php endif;?>
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
    			<td><span class="text-13">(Ký, Họ tên)</span></td>
    		</tr>
    		<tr>
        		<td></td>
        		<td></td>
    			<td style="padding-top:40px;font-size:13pt"><?= $model->nguoiTao->hoTen ?></td>
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