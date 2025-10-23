<?php
use app\modules\user\models\User;
use app\custom\CustomFunc;
?>

<link href="/css/print-display.css" rel="stylesheet">

<div class="row text-center" style="width: 100%">
	<div class="col-md-12" style="width: 100%;text-align: center"> 
		<span style="font-weight:bold;font-size:13pt;">CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</span>
        <br/>
        <span style="text-decoration: underline;font-weight:bold;font-size:13pt;">Độc lập - Tự do - Hạnh phúc</span>
	</div>
    <div class="col-md-12" style="width: 100%; text-align: justify;"> 
        
        <table id="table-tieu-de-1" style="width: 100%;margin:20px 0px">
    		<tr>
    		
    			<td>
    				<span style="font-size: 18pt;font-weight: bold">ĐƠN XIN RÚT HỒ SƠ</span>
    			</td>
    			
    		</tr>
    		
    	</table>
    	
    	
    	<p style="font-size: 14pt;margin:20px 0px;font-weight:bold;text-align: center">Kính gửi: Trung tâm Giáo dục nghề nghiệp và Sát hạch lái xe Nguyễn Trình</p>    	
    	<p style="font-size: 14pt;margin:7px 0px;">Tôi tên là: <?= $model->ho_ten ?> <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>   Ngày sinh: <?= $model->getNgaySinh() ?> </p>
    	<p style="font-size: 14pt;margin:7px 0px;">Số điện thoại: <?= $model->so_dien_thoai ?></p>
    	<p style="font-size: 14pt;;margin:7px 0px;">Địa chỉ: <?= $model->diaChi ?>.</p>
    	<p style="font-size: 14pt;;margin:7px 0px;">Số CCCD: <?= $model->so_cccd ?>  <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Ngày cấp:.........................    <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Nơi cấp:......................... </p>
    	
    	<p style="font-size: 14pt;margin:7px 0px;">Tôi đã đăng ký học tại Trung tâm Đào tạo và Sát hạch Lái xe Nguyễn Trình vào
ngày <?= CustomFunc::convertYMDHISToDMY($model->thoi_gian_tao) ?>. Loại bằng đăng ký: <?= $model->hangDaoTao ? $model->hangDaoTao->ten_hang : '' ?>.</p>
		<p style="font-size: 14pt;margin:7px 0px;">Nay tôi làm đơn này kính đề nghị Trung tâm cho phép tôi rút hồ sơ học lái xe vì lý do: <?= $model->ly_do_huy_ho_so ?>.</p>
    	
    	<p style="font-size: 14pt;margin:7px 0px;">Tôi cam kết mọi thông tin trên là đúng sự thật và hoàn toàn chịu trách nhiệm.</p>    	
    	
    	<table style="width: 100%; margin-top:5px;">
    		<tr>
    			<td colspan="3" align="right" style="font-style: italic;font-size:14pt">Vĩnh Long, ngày <?= date("d", strtotime($model->thoi_gian_huy_ho_so))?> tháng <?= date("m", strtotime($model->thoi_gian_huy_ho_so))?> năm <?= date("Y", strtotime($model->thoi_gian_huy_ho_so))?></td>
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
    			<td  align="center" style="padding-top:60px"><span style="font-weight: bold;font-size:14pt""><?= $model->ho_ten ?></span></td>
    		</tr>
    	</table>
   	</div>
</div>