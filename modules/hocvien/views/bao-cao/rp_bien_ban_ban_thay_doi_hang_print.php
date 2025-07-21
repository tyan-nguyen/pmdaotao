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
        
        <table id="table-tieu-de-1" style="width: 100%;margin:20px 0px">
    		<tr>
    		
    			<td>
    				<span style="font-size: 18pt;font-weight: bold">PHIẾU ĐỀ NGHỊ THAY ĐỔI HẠNG ĐĂNG KÝ HỌC LÁI XE</span>
    			</td>
    			
    		</tr>
    		
    	</table>
    	
    	
    	<p style="font-size: 14pt;margin:20px 0px;font-weight:bold;text-align: center">Kính gửi: Trung tâm Giáo dục nghề nghiệp và Sát hạch lái xe Nguyễn Trình</p>    	
    	<p style="font-size: 14pt;margin:7px 0px;">Tôi tên: <?= $model->hocVien->ho_ten ?> <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>   Sinh ngày: <?= $model->hocVien->getNgaySinh() ?>  <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>  Nam/Nữ: <?= $model->hocVien->gioi_tinh == 1 ? 'Nam' : 'Nữ' ?></p>
    	<p style="font-size: 14pt;margin:7px 0px;">Địa chỉ: <?= $model->hocVien->dia_chi ?></p>
    	<p style="font-size: 14pt;margin:7px 0px;">Số CCCD: <?= $model->hocVien->so_cccd ?>  <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Ngày cấp:....................    <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Nơi cấp:.................. </p>
    	
    	<p style="font-size: 14pt;margin:7px 0px;">Đề nghị cho tôi thay đổi hạng đăng ký học lái xe ban đầu như sau: <?= $model->ly_do ?>.</p>
    	<p style="font-size: 14pt;;margin:7px 0px;">Tôi cam kết sẽ thực hiện theo sự sắp xếp của Trung tâm và nộp thêm học phí (nếu có phát sinh).</p>
    	
    	
    	<table style="width: 100%; margin-top:5px;">
    		<tr>
    			<td colspan="3" align="right" style="font-style: italic;font-size:14pt">Vĩnh Long, ngày <?= date("d", strtotime($model->thoi_gian_thay_doi))?> tháng <?= date("m", strtotime($model->thoi_gian_thay_doi))?> năm <?= date("Y", strtotime($model->thoi_gian_thay_doi))?></td>
    		</tr>
    		<tr>
    			<td width="30%"></td>
    			<td width="30%"></td>
    			<td align="center"><span style="font-weight: bold;font-size:14pt">NGƯỜI LÀM ĐƠN</span></td>
    		</tr>
    		<tr>
    			<td></td>
    			<td></td>
    			<td align="center"><span style="font-size:14pt">(Ký, Họ tên)</span></td>
    		</tr>
    		<tr>
        		<td></td>
        		<td></td>
    			<td  align="center" style="padding-top:60px"><span style="font-weight: bold;font-size:14pt""><?= $model->hocVien->ho_ten ?></span></td>
    		</tr>
    	</table>
   	</div>
</div>