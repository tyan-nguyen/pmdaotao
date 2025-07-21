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
    				<span style="font-size: 18pt;font-weight: bold">ĐƠN XIN BẢO LƯU KHÓA HỌC</span>
    			</td>
    		</tr>
    	</table>
    	
    	
    	<p style="font-size: 14pt;margin:20px 0px;font-weight:bold;text-align: center">Kính gửi: - Trung tâm Giáo dục nghề nghiệp và Sát hạch lái xe Nguyễn Trình</p>    	
    	<p style="font-size: 14pt;margin:7px 0px;">Tôi tên: <?= $model->hocVien->ho_ten ?></p>
    	<p style="font-size: 14pt;margin:7px 0px;">Ngày sinh: <?= $model->hocVien->getNgaySinh() ?> <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>  Số CCCD: <?= $model->hocVien->so_cccd ?> </p>
    	<p style="font-size: 14pt;margin:7px 0px;">Số điện thoại: <?= $model->hocVien->so_dien_thoai ?></p>    	
    	<p style="font-size: 14pt;margin:7px 0px;">Hiện tôi đang học khóa học lái xe ô tô hạng: <?= $model->hang ? $model->hang->ten_hang : '' ?>. Khóa: <?= $model->khoa ? $model->khoa->ten_khoa_hoc : '' ?>.</p>
    	<p style="font-size: 14pt;margin:7px 0px;">Khai giảng ngày: <?= CustomFunc::convertYMDToDMY($model->ngay_khai_giang) ?> tại Trung tâm GDNN&SHLX Nguyễn Trình.</p>
    	<p style="font-size: 14pt;margin:7px 0px;">Nay tôi làm đơn này gửi đến Trung tâm GDNN&SHLX Nguyễn Trình cho phép tôi được bảo lưu khóa học kể từ ngày : <?= CustomFunc::convertYMDToDMY($model->ngay_bat_dau) ?> đến ngày <?= CustomFunc::convertYMDToDMY($model->ngay_ket_thuc) ?>.</p>
    	<p style="font-size: 14pt;margin:7px 0px;">Học phí đã đóng: <?= number_format($model->hocVien->tienDaNop) ?> đồng.</p>
    	<p style="font-size: 14pt;margin:7px 0px;">Lý do bảo lưu khóa học: <?= $model->ly_do ?></p>
    	
    	
		<p style="font-size: 14pt;margin:7px 0px;">Nếu hết thời gian bảo lưu (trong vòng 1 năm kể từ ngày khai giảng) tôi không hoàn thành khóa học, tôi xin hoàn toàn chịu trách nhiệm và không có khiếu nại về sau.</p>
    	
    	<p style="font-size: 14pt;margin:7px 0px;">Rất mong nhận được sự chấp thuận của Trung tâm GDNN&SHLX Nguyễn Trình.</p>  
    	<p style="font-size: 14pt;margin:7px 0px;">Xin chân thành cảm ơn!.</p>  	
    	
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
    	<br/><br/><br/><br/><br/><br/>
    	<p style="font-size: 14pt;margin:7px 0px;font-style: italic;color:red">Lưu ý: Áp dụng cho trường hợp đăng ký và đang tham gia học (đã báo cáo). Bảo lưu có giá trị trong vòng 1 năm. Qua thời gian bảo lưu kết quả sẽ bị hủy.</p>
   	</div>
</div>