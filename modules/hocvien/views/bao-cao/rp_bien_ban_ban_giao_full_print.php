<?php
use app\modules\user\models\User;
use app\custom\CustomFunc;
use app\modules\hocvien\models\HangDaoTao;
use app\modules\hocvien\models\base\HocVienBase;
use app\modules\khoahoc\models\KhoaHoc;
use app\modules\hocvien\models\HocVien;
use yii\db\Expression;
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
    				<span class="phieu-h1">DANH SÁCH GIAO NHẬN HỒ SƠ HỌC VIÊN ĐĂNG KÝ HỌC LÁI XE</span>
    			</td>    			
    		</tr>
    		<tr>
    			<td style="text-align: left;width: 50%;padding-top:10px"><span>Thời gian từ <?= CustomFunc::convertYMDHISToDMYHI($start) ?> đến <?= CustomFunc::convertYMDHISToDMYHI($end) ?></span></td>
    			<td style="text-align: left;width: 50%;padding-top:10px"><span>Nhân viên xuất báo cáo: <?= User::getCurrentUser()->getHoTen() ?></span></td>
    		</tr>
    		<!--  <tr>
    			<td style="text-align: left;width: 50%"><span>Hạng: <?= $byhangdaotao?HangDaoTao::findOne($byhangdaotao)->ten_hang : 'Tất cả' ?> </span></td>
    			<td style="text-align: left;width: 50%"><span>Nhân viên nhận hồ sơ: <?= $byuser ? User::findOne($byuser)->ho_ten : 'Tất cả' ?></span></td>
    		</tr>-->
    		<tr>
    			<td style="text-align: left;width: 50%;"><span>Nơi nhận hồ sơ: <?= $byaddress ? HocVienBase::getLabelNoiDangKyOther($byaddress) : 'Tất cả' ?></span></td>
    			<td style="text-align: left;width: 50%"><span>Nhân viên nhận hồ sơ: <?= $byuser ? User::findOne($byuser)->ho_ten : 'Tất cả' ?></span></td>
    		</tr>   
    		<tr>
    			<td style="text-align: left;width: 50%;"><span>Sắp xếp: </span>
    				<?= $sortby=='hang'? 'Theo hạng đào tạo' : 'Theo ngày nhận hồ sơ'  ?>
    			</td>
    			<td style="text-align: left;width: 50%;"></td>
    		</tr>  
    		
    		<!-- <tr>
    			<td style="text-align: left;width: 50%;padding-bottom:10px"><span>Khóa học: <?= $bykhoa ? KhoaHoc::getNameById($bykhoa) : 'Tất cả' ?></span></td>
    			<td style="text-align: left;width: 50%;padding-bottom:10px"><span></span>
    				
    			</td>
    		</tr>  --> 		
    	</table>
    	
        <!-- duyệt khóa học -->
        <?php 
            $khoaHocs = KhoaHoc::find()->all();
            foreach ($khoaHocs as $indexKh => $khoaHoc){
                //$queryNew = null;
                //$modelNew = null;
                $queryNew = HocVien::find()->alias('t');
                $queryNew = $queryNew->andFilterWhere(['t.id_khoa_hoc' => $khoaHoc->id]);
                $queryNew=$queryNew->andFilterWhere(['>=', 't.thoi_gian_hoan_thanh_ho_so', new Expression("STR_TO_DATE('".$start."','%Y-%m-%d %H:%i:%s')")]);
                $queryNew=$queryNew->andFilterWhere(['<=', 't.thoi_gian_hoan_thanh_ho_so', new Expression("STR_TO_DATE('".$end."','%Y-%m-%d %H:%i:%s')")]);
                if($byuser>0){
                    $queryNew = $queryNew->andFilterWhere(['t.nguoi_tao' => $byuser]);
                }
                
                /* if($byhangdaotao!=NULL){
                 $query = $query->andFilterWhere(['t.id_hang' => $byhangdaotao]);
                 } */
                
                if($byaddress!=NULL){
                    //$byaddress = strtoupper($byaddress);
                    $queryNew = $queryNew->andFilterWhere(['t.noi_dang_ky' => $byaddress]);
                }
                //$modelNew=$queryNew->all();
                //$modelNewCount=$queryNew->count();                
                if($sortby==null)
                    $sortby = 'ngay';
                if($sortby == 'hang'){
                    $modelNew=$queryNew->orderBy(['t.id_hang'=>SORT_ASC, 't.thoi_gian_hoan_thanh_ho_so'=>SORT_ASC])->all();
                } else if($sortby == 'ngay'){
                    $modelNew=$queryNew->orderBy(['t.thoi_gian_hoan_thanh_ho_so'=>SORT_ASC])->all();
                }
        ?>        
        <?php if($modelNew != null){?>
        <h3 style="margin:5px 0px">Khóa <?= $khoaHoc->ten_khoa_hoc ?></h3>
        <table class="table-content" style="width: 100%; margin-top:5px;">
        	<thead>
        		<tr>
        			<th width="40">STT</th>
        			<th width="120">Họ và tên</th>
        			<!-- <th width="40">Giới tính</th> -->
        			<th width="100">Ngày sinh</th>
        			<th width="100">Số CMND/CCCD</th>
        			<!-- <th width="70">Số điện thoại</th> -->
        			<th width="180">Địa chỉ thường trú</th>
        			<th width="180">Hạng đào tạo</th>
        			<th width="100">Ngày nhận hồ sơ</th>
        			<th width="80">Ghi chú</th>
        		</tr> 
        		  
        	</thead> 
        	<tbody>
        	<?php 
        	    foreach ($modelNew as $indexCt => $item){
            ?>
            <tr>
            	<td style="text-align:center"><?= ($indexCt+1) ?></td>
            	<td style="text-align:left"><?= $item->ho_ten ?></td>
            	<!-- <td style="text-align:center"><?= $item->gioi_tinh == 1 ? 'Nam' : 'Nữ' ?></td> -->
            	<td style="text-align:center"><?= $item->getNgaySinh() ?></td>
            	<td style="text-align:center"><?= $item->so_cccd ?></td>
            	<!-- <td style="text-align:center"><?= $item->so_dien_thoai ?></td>-->
            	<td style="text-align:left"><?= $item->dia_chi ?></td>
            	<td style="text-align:left"><?= $item->hangDaoTao->ten_hang ?></td>
            	<td style="text-align:center"><?= CustomFunc::convertYMDHISToDMY($item->thoi_gian_hoan_thanh_ho_so) ?></td>
            	<td style="text-align:left"><?= $item->ghi_chu ?></td>
            </tr>
            <?php } ?>	
            </tbody>
        </table>
        <?php }//end if modelNew?>
        
        <?php }//end if khoaHoc ?>
        <!-- end duyệt khóa học -->
        
        
        <table id="table-ky-ten" style="width: 100%; margin-top:5px;">
        	<tr>
        		<td colspan="3" style="text-align: right;font-style: italic;">Trà Vinh, ngày <?= date('d') ?> tháng <?= date('m') ?> năm <?= date('Y') ?></td>
        	</tr>
    		<tr>
    			<td style="text-align: center;font-weight: bold;font-style: normal;">BÊN GIAO</td>
    			<td></td>
    			<td style="text-align: center;font-weight: bold;font-style: normal;">BÊN NHẬN</td>
    		</tr>
    		<tr>
    			<td><span class="text-13">(Ký, Họ tên)</span></td>
    			<td></td>
    			<td><span class="text-13">(Ký, Họ tên)</span></td>
    		</tr>
    		<tr>
        		<td style="padding-top:40px;font-size:13pt"><?= User::getCurrentUser()->getHoTen() ?></td>
        		<td></td>
    			<td style="padding-top:40px;font-size:13pt"><?php /* $byuser ? User::findOne($byuser)->ho_ten : ''*/ ?></td>
    		</tr>
    	</table>
    	
    </div>
</div>