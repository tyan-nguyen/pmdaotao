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
    				<span style="font-size: 18pt;font-weight: bold">ĐƠN XIN DỜI LỊCH SÁT HẠCH BẰNG LÁI XE</span>
    			</td>
    		</tr>
    	</table>
    	
    	
    	<p style="font-size: 14pt;margin:20px 0px;font-weight:bold;text-align: center">Kính gửi: Trung tâm Giáo dục nghề nghiệp và Sát hạch lái xe Nguyễn Trình</p>    	
    	<p style="font-size: 14pt;margin:7px 0px;">Tôi tên: <?= $model->hocVien->ho_ten ?></p>
    	<p style="font-size: 14pt;margin:7px 0px;">Ngày sinh: <?= $model->hocVien->getNgaySinh() ?> <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>  Số điện thoại: <?= $model->hocVien->so_dien_thoai ?> </p>
    	<p style="font-size: 14pt;margin:7px 0px;">Số CCCD: <?= $model->hocVien->so_cccd ?><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>  Ngày cấp:...........................</p>    	
    	<p style="font-size: 14pt;margin:7px 0px;">Hạng bằng lái: <?= $model->hang ? $model->hang->ten_hang : '' ?>. </p>   	
		<p style="font-size: 14pt;margin:7px 0px;">Nay tôi làm đơn này kính xin Quý Trung tâm xem xét và cho phép <strong>dời lịch thi sát hạch lái xe</strong> đã được sắp xếp vào ngày <?= CustomFunc::convertYMDToDMY($model->ngay_thi_cu) ?> sang một ngày khác.</p>
    	<p style="font-size: 14pt;margin:7px 0px;"><strong>Lý do dời lịch: </strong><?= $model->ly_do_doi_lich ?>.</p> 
    	<p style="font-size: 14pt;margin:7px 0px;">Tôi cam kết sẽ tuân thủ quy định của Trung tâm và tham gia kỳ thi theo lịch mới được sắp xếp.</p>   	
    	
    	<table style="width: 100%; margin-top:5px;">
    		<tr>
    			<td colspan="3" align="right" style="font-style: italic;font-size:14pt">Vĩnh Long, ngày <?= date("d", strtotime($model->thoi_gian_tao))?> tháng <?= date("m", strtotime($model->thoi_gian_tao))?> năm <?= date("Y", strtotime($model->thoi_gian_tao))?></td>
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