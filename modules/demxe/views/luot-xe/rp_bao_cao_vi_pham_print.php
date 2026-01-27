<?php
use app\custom\CustomFunc;
use app\modules\user\models\User;

/* foreach ($list as $i=>$item){
    echo '<br/>';
    echo $i;
    $mss = explode(';', $item);
    foreach ($mss as $ms){
        if($ms){
            echo '<br/>' . $ms;
        }
    }
} */
?>

<link href="/css/print-display.css" rel="stylesheet">

<div class="row text-center" style="width: 100%">
<div class="col-md-12" style="width: 100%">
<table id="table-top" style="width: 100%">
<tr>
<td style="font-weight: bold; text-align: center;font-size: 13pt;width: 40%">TRUNG TÂM GDNN & SHLX NGUYỄN TRÌNH</td>
<td></td>
</tr>
<tr>
<td style="font-weight: bold; text-align: center;font-size: 13pt;width: 40%">***</td>
<td></td>
</tr>
</table>
<!-- <table id="table-top" style="width: 100%">
<tr>
<td>
<img src="/libs/images/logo.png" width="175px" />
</td>
<td>
<span style="font-weight: bold; font-size:14pt;color:red">TRUNG TÂM GDNN & SHLX NGUYỄN TRÌNH</span>
<br/>
<span style="font-size:10pt"><i class="fas fa-map-marker-alt" style="color:red;margin-right:2px"></i> Địa chỉ đăng ký: Nguyễn Đáng, Khóm 10, Phường 9, TP Trà Vinh</span>
<br/>
<span style="font-size:10pt"><i class="fas fa-home" style="color:red"></i> Địa chỉ TT: Ấp Giồng Trôm, X. Mỹ Chánh, H. Châu Thành, T. Trà Vinh</span>
<br/>
<span style="font-size:10pt"><i class="fas fa-globe" style="color:red"></i> Website: nguyentrinh.com.vn</span> - <span style="font-size:10pt"><i class="fas fa-phone" style="color:red"></i> ĐT: 0903 336 470</span>
<br/>
<span style="font-size:10pt"><i class="fas fa-envelope" style="color:red"></i> Email: nguyentrinh@nguyentrinhtravinh.com.vn</span>
</td>

</tr>
</table> -->

<table id="table-tieu-de-1" style="width: 100%">
<tr>
<td colspan="2">
<span class="phieu-h1">BÁO CÁO DANH SÁCH XE VI PHẠM</span>
<br/>
(Xuất tự động từ phần mềm Quản lý xe ra vào, cho các xe thuộc Phòng đào tạo quản lý)
</td>
</tr>
<tr>
<td colspan="2" style="text-align: center;width: 50%;padding-top:10px"><span>Thời gian từ <?= CustomFunc::convertYMDHISToDMYHI($start) ?> đến <?= CustomFunc::convertYMDHISToDMYHI($end) ?></span></td>
</tr>
<tr><td></td></tr>
    	</table>
    	
    	<table class="table-content" style="width: 100%; margin-top:5px;">
        	<thead>
        		<tr>
        			<th width="40">STT</th>
        			<th width="100">Biển số xe</th>
        			<th width="300">Lỗi vi phạm</th>
        			<th width="100">Ghi chú</th>
        		</tr> 
        		  
        	</thead> 
        	<tbody>
        		<?php 
        		$stt=0;
            	foreach ($list as $i=>$item){
            	    $stt++;
                ?>
                <tr>
                	<td align="center"><?= $stt ?></td>
                	<td align="center"><?= $i ?></td>
                	<td><?php 
                    	$mss = explode(';', $item);
                    	$iMs = 0;
                    	foreach ($mss as $ms){
                    	    $iMs++;
                    	    if($ms){
                    	        echo ($iMs==1?'':'<br/>') . $ms;
                    	    }
                    	}
                	?></td>
                	<td></td>
                </tr>
                
              
                <?php 
                }
                ?>
        	</tbody>
       	</table>
       	
       	<table id="table-ky-ten" style="width: 100%; margin-top:5px;">
        	<tr>
        		<td></td>
        		<td style="text-align: center;font-weight:300;font-style: italic;">Vĩnh Long, ngày <?= date('d') ?> tháng <?= date('m') ?> năm <?= date('Y') ?></td>
        	</tr>
    		<tr>
    			<td></td>
    			<td style="text-align: center;font-weight: bold;font-style: normal;">NGƯỜI LẬP</td>
    		</tr>
    		<tr>
    			<td></td>
    			<td><span class="text-13">(Ký, Họ tên)</span></td>
    		</tr>
    		<tr>
        		<td></td>
    			<td style="padding-top:40px;font-size:13pt;font-weight: bold"><?= User::getCurrentUser()->getHoTen() ?></td>
    		</tr>
    	</table>
    	
    	
	</div>
</div>