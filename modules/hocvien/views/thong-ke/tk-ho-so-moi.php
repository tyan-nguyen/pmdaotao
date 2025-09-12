<?php 
use app\widgets\CardWidget;
use app\modules\hocvien\models\DangKyHv;
use app\custom\CustomFunc;
?>

<?php CardWidget::begin(['title'=>'Học viên đăng ký mới' ]) ?>

<div class="table-responsive border p-0 pt-3">
    <table class="table table-bordered mg-b-0">
        <thead>
            <tr style="font-weight:bold">
                <td width="50px" rowspan="2" align="center">STT</td>
                <td align="center" rowspan="2">Ngày</td>
                <td align="center" colspan="8">Tổng học viên mới</td>
                <td align="center" colspan="2">Hạng B tự động</td>
                <td align="center" colspan="2">Hạng B cơ khí</td>
                <td align="center" colspan="2">Hạng C1</td>
                <td align="center" colspan="2">Hạng A1</td>
                <td align="center" colspan="2">Hạng A</td>     
                <!-- <td align="center" colspan="2">Nâng hạng (C, D, D2, CE)</td>   -->
                <td align="center" colspan="2">Nâng hạng C</td> 
                <td align="center" colspan="2">Nâng hạng D</td>          
                <td align="center" colspan="2">Nâng hạng D2</td>   
                <td align="center" colspan="2">Nâng hạng CE</td>
            </tr>
            <tr style="font-weight:bold">
               
                
                <td align="center">Tổng</td>
                <td align="center">CS1</td>
                <td align="center">CS2</td>
                <td align="center"><?= DangKyHv::getLabelNoiDangKyOther(DangKyHv::NOIDANGKY_CS3) ?></td>
                <td align="center"><?= DangKyHv::getLabelNoiDangKyOther(DangKyHv::NOIDANGKY_CS4) ?></td>
                <td align="center"><?= DangKyHv::getLabelNoiDangKyOther(DangKyHv::NOIDANGKY_CS5) ?></td>
                <td align="center"><?= DangKyHv::getLabelNoiDangKyOther(DangKyHv::NOIDANGKY_CS6) ?></td>
                <td align="center"><?= DangKyHv::getLabelNoiDangKyOther(DangKyHv::NOIDANGKY_CS7) ?></td>
                <!-- <td align="center">Tổng</td>-->
                <!-- Hạng B tự động -->
                <td align="center">CS1</td>
                <td align="center">CS2</td>
                <!-- <td align="center">Tổng</td> -->
                <!-- Hạng B cơ khí -->
                <td align="center">CS1</td>
                <td align="center">CS2</td>
                <!-- <td align="center">Tổng</td>-->
                <!-- Hạng C1 -->
                <td align="center">CS1</td>
                <td align="center">CS2</td>
                <!-- <td align="center">Tổng</td>-->
                <!-- Hạng A1 -->
                <td align="center">CS1</td>
                <td align="center">CS2</td>
                <!-- td align="center">Tổng</td>-->
                <!-- Hạng A -->
                <td align="center">CS1</td>
                <td align="center">CS2</td>   
                 <!-- Nâng hạng -->
                <!-- <td align="center">CS1</td>
                <td align="center">CS2</td>  -->      
                 <!-- Nâng hạng C -->
                <td align="center">CS1</td>
                <td align="center">CS2</td>     
                 <!-- Nâng hạng D -->
                <td align="center">CS1</td>
                <td align="center">CS2</td>   
                 <!-- Nâng hạngD2 -->
                <td align="center">CS1</td>
                <td align="center">CS2</td>    
                 <!-- Nâng hạng CE -->
                <td align="center">CS1</td>
                <td align="center">CS2</td>        
            </tr>
        </thead>
        <tbody>
<?php 
    // Lấy danh sách 7 ngày gần nhất, tính cả hôm nay
    $dates = [];
    for ($i = 0; $i < 7; $i++) {
        $dates[] = date('Y-m-d', strtotime("-$i days"));
    }
    // Duyệt qua danh sách 7 ngày
    foreach ($dates as $iDate => $date) {
        $soLuongHV = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere("DATE(thoi_gian_tao) = '$date'")->count();
        $soLuongHV1 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere("DATE(thoi_gian_tao) = '$date'")->andFilterWhere(['noi_dang_ky'=>'CS1'])->count();
        $soLuongHV2 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere("DATE(thoi_gian_tao) = '$date'")->andFilterWhere(['noi_dang_ky'=>'CS2'])->count();
        $soLuongHV3 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere("DATE(thoi_gian_tao) = '$date'")->andFilterWhere(['noi_dang_ky'=>DangKyHv::NOIDANGKY_CS3])->count();
        $soLuongHV4 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere("DATE(thoi_gian_tao) = '$date'")->andFilterWhere(['noi_dang_ky'=>DangKyHv::NOIDANGKY_CS4])->count();
        $soLuongHV5 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere("DATE(thoi_gian_tao) = '$date'")->andFilterWhere(['noi_dang_ky'=>DangKyHv::NOIDANGKY_CS5])->count();
        $soLuongHV6 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere("DATE(thoi_gian_tao) = '$date'")->andFilterWhere(['noi_dang_ky'=>DangKyHv::NOIDANGKY_CS6])->count();
        $soLuongHV7 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere("DATE(thoi_gian_tao) = '$date'")->andFilterWhere(['noi_dang_ky'=>DangKyHv::NOIDANGKY_CS7])->count();
        
        /* $soLuongBTD = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere("DATE(thoi_gian_tao) = '$date'")->andWhere('id_hang IN (1,2)')->count(); */
        $soLuongBTD1 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere("DATE(thoi_gian_tao) = '$date'")->andWhere('id_hang IN (1,2)')->andFilterWhere(['noi_dang_ky'=>'CS1'])->count();
        $soLuongBTD2 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere("DATE(thoi_gian_tao) = '$date'")->andWhere('id_hang IN (1,2)')->andFilterWhere(['noi_dang_ky'=>'CS2'])->count();
        
        /* $soLuongBCK = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere("DATE(thoi_gian_tao) = '$date'")->andWhere('id_hang IN (3,4)')->count(); */
        $soLuongBCK1 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere("DATE(thoi_gian_tao) = '$date'")->andWhere('id_hang IN (3,4)')->andFilterWhere(['noi_dang_ky'=>'CS1'])->count();
        $soLuongBCK2 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere("DATE(thoi_gian_tao) = '$date'")->andWhere('id_hang IN (3,4)')->andFilterWhere(['noi_dang_ky'=>'CS2'])->count();
        
        /* $soLuongC1 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere("DATE(thoi_gian_tao) = '$date'")->andWhere('id_hang IN (5,6)')->count(); */
        $soLuongC11 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere("DATE(thoi_gian_tao) = '$date'")->andWhere('id_hang IN (5,6)')->andFilterWhere(['noi_dang_ky'=>'CS1'])->count();
        $soLuongC12 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere("DATE(thoi_gian_tao) = '$date'")->andWhere('id_hang IN (5,6)')->andFilterWhere(['noi_dang_ky'=>'CS2'])->count();
        
        /* $soLuongA01 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere("DATE(thoi_gian_tao) = '$date'")->andWhere('id_hang IN (7,8)')->count(); */
        $soLuongA011 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere("DATE(thoi_gian_tao) = '$date'")->andWhere('id_hang IN (7,8)')->andFilterWhere(['noi_dang_ky'=>'CS1'])->count();
        $soLuongA012 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere("DATE(thoi_gian_tao) = '$date'")->andWhere('id_hang IN (7,8)')->andFilterWhere(['noi_dang_ky'=>'CS2'])->count();
        
       /*  $soLuongA = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere("DATE(thoi_gian_tao) = '$date'")->andWhere('id_hang IN (9,10)')->count(); */
        $soLuongA1 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere("DATE(thoi_gian_tao) = '$date'")->andWhere('id_hang IN (9,10)')->andFilterWhere(['noi_dang_ky'=>'CS1'])->count();
        $soLuongA2 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere("DATE(thoi_gian_tao) = '$date'")->andWhere('id_hang IN (9,10)')->andFilterWhere(['noi_dang_ky'=>'CS2'])->count();
        
        //$soLuongNH1 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere("DATE(thoi_gian_tao) = '$date'")->andWhere('id_hang IN (11,12,13,14,15,16,17,18,19,20,21,22,23,24,25)')->andFilterWhere(['noi_dang_ky'=>'CS1'])->count();
        //$soLuongNH2 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere("DATE(thoi_gian_tao) = '$date'")->andWhere('id_hang IN (11,12,13,14,15,16,17,18,19,20,21,22,23,24,25)')->andFilterWhere(['noi_dang_ky'=>'CS2'])->count();
        $soLuongNHC1 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere("DATE(thoi_gian_tao) = '$date'")->andWhere('id_hang IN (11,12,15,16)')->andFilterWhere(['noi_dang_ky'=>'CS1'])->count();
        $soLuongNHC2 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere("DATE(thoi_gian_tao) = '$date'")->andWhere('id_hang IN (11,12,15,16)')->andFilterWhere(['noi_dang_ky'=>'CS2'])->count();
        
        $soLuongNHD1 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere("DATE(thoi_gian_tao) = '$date'")->andWhere('id_hang IN (21,22,25,26)')->andFilterWhere(['noi_dang_ky'=>'CS1'])->count();
        $soLuongNHD2 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere("DATE(thoi_gian_tao) = '$date'")->andWhere('id_hang IN (21,22,25,26)')->andFilterWhere(['noi_dang_ky'=>'CS2'])->count();
        
        $soLuongNHD21 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere("DATE(thoi_gian_tao) = '$date'")->andWhere('id_hang IN (13,14,17,18,19,20)')->andFilterWhere(['noi_dang_ky'=>'CS1'])->count();
        $soLuongNHD22 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere("DATE(thoi_gian_tao) = '$date'")->andWhere('id_hang IN (13,14,17,18,19,20)')->andFilterWhere(['noi_dang_ky'=>'CS2'])->count();
        
        $soLuongNHCE1 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere("DATE(thoi_gian_tao) = '$date'")->andWhere('id_hang IN (23,24)')->andFilterWhere(['noi_dang_ky'=>'CS1'])->count();
        $soLuongNHCE2 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere("DATE(thoi_gian_tao) = '$date'")->andWhere('id_hang IN (23,24)')->andFilterWhere(['noi_dang_ky'=>'CS2'])->count();
        
    ?>
    <tr style="<?= $iDate==0?'color:red;font-weight:bold':'' ?>">
    	<td><?= ($iDate+1) ?></td>
    	<td align="center"><strong><?= CustomFunc::convertYMDToDMY($date) ?></strong></td>
    	<td align="center"><strong><?= $soLuongHV ?></strong></td>
    	<td align="center"><?= $soLuongHV1 ?></td>
    	<td align="center"><?= $soLuongHV2 ?></td>
    	<td align="center"><?= $soLuongHV3 ?></td>
    	<td align="center"><?= $soLuongHV4 ?></td>
    	<td align="center"><?= $soLuongHV5 ?></td>
    	<td align="center"><?= $soLuongHV6 ?></td>
    	<td align="center"><?= $soLuongHV7 ?></td>
    	
        <td align="center"><?= $soLuongBTD1 ?></td>
        <td align="center"><?= $soLuongBTD2 ?></td>
        
        <td align="center"><?= $soLuongBCK1 ?></td>
        <td align="center"><?= $soLuongBCK2 ?></td>
        
        <td align="center"><?= $soLuongC11 ?></td>
        <td align="center"><?= $soLuongC12 ?></td>
        
        <td align="center"><?= $soLuongA011 ?></td>
        <td align="center"><?= $soLuongA012 ?></td>
        
        <td align="center"><?= $soLuongA1 ?></td>
        <td align="center"><?= $soLuongA2 ?></td>    
        
        <?php /*?><td align="center"><?= $soLuongNH1 ?></td>
        <td align="center"><?= $soLuongNH2 ?></td>    <?php */ ?>
        
        <td align="center"><?= $soLuongNHC1 ?></td>
        <td align="center"><?= $soLuongNHC2 ?></td>
        
        <td align="center"><?= $soLuongNHD1 ?></td>
        <td align="center"><?= $soLuongNHD2 ?></td>
        
        <td align="center"><?= $soLuongNHD21 ?></td>
        <td align="center"><?= $soLuongNHD22 ?></td>
        
        <td align="center"><?= $soLuongNHCE1 ?></td>
        <td align="center"><?= $soLuongNHCE2 ?></td>
    </tr>
    <?php 
    }
?>
			 <tr style="font-weight:bold">
                <td width="50px" align="center">..</td>
                <td align="center">...</td>
                <td align="center">...</td>
                <td align="center">...</td>
                <td align="center">...</td>
                <td align="center">...</td>
                <td align="center">...</td>
                <td align="center">...</td>    
                <td align="center">...</td>
                <td align="center">...</td>
                <td align="center">...</td>
                <td align="center">...</td>
                <td align="center">...</td>
                <td align="center">...</td>
                <td align="center">...</td> 
                <td align="center">...</td> 
                <td align="center">...</td> 
                
                <td align="center">...</td>
                <td align="center">...</td>
                <td align="center">...</td> 
                
                
               <!--   <td align="center">...</td> -->
                <!-- <td align="center">...</td>   -->
                <td align="center">...</td>
                <td align="center">...</td>   
                 <td align="center">...</td>
                <td align="center">...</td>  
                 <td align="center">...</td>
                <td align="center">...</td>  
                 <td align="center">...</td>
                <td align="center">...</td>            
            </tr>
            <?php 
            $soLuongHV = DangKyHv::find()->where(['huy_ho_so'=>0])->count();
            $soLuongHV1 = DangKyHv::find()->where(['huy_ho_so'=>0])->andFilterWhere(['noi_dang_ky'=>'CS1'])->count();
            $soLuongHV2 = DangKyHv::find()->where(['huy_ho_so'=>0])->andFilterWhere(['noi_dang_ky'=>'CS2'])->count();
            $soLuongHV3 = DangKyHv::find()->where(['huy_ho_so'=>0])->andFilterWhere(['noi_dang_ky'=>DangKyHv::NOIDANGKY_CS3])->count();
            $soLuongHV4 = DangKyHv::find()->where(['huy_ho_so'=>0])->andFilterWhere(['noi_dang_ky'=>DangKyHv::NOIDANGKY_CS4])->count();
            $soLuongHV5 = DangKyHv::find()->where(['huy_ho_so'=>0])->andFilterWhere(['noi_dang_ky'=>DangKyHv::NOIDANGKY_CS5])->count();
            $soLuongHV6 = DangKyHv::find()->where(['huy_ho_so'=>0])->andFilterWhere(['noi_dang_ky'=>DangKyHv::NOIDANGKY_CS6])->count();
            $soLuongHV7 = DangKyHv::find()->where(['huy_ho_so'=>0])->andFilterWhere(['noi_dang_ky'=>DangKyHv::NOIDANGKY_CS7])->count();
            
            //$soLuongBTD = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere('id_hang IN (1,2)')->count();
            $soLuongBTD1 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere('id_hang IN (1,2)')->andFilterWhere(['noi_dang_ky'=>'CS1'])->count();
            $soLuongBTD2 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere('id_hang IN (1,2)')->andFilterWhere(['noi_dang_ky'=>'CS2'])->count();
            
            //$soLuongBCK = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere('id_hang IN (3,4)')->count();
            $soLuongBCK1 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere('id_hang IN (3,4)')->andFilterWhere(['noi_dang_ky'=>'CS1'])->count();
            $soLuongBCK2 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere('id_hang IN (3,4)')->andFilterWhere(['noi_dang_ky'=>'CS2'])->count();
            
            //$soLuongC1 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere('id_hang IN (5,6)')->count();
            $soLuongC11 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere('id_hang IN (5,6)')->andFilterWhere(['noi_dang_ky'=>'CS1'])->count();
            $soLuongC12 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere('id_hang IN (5,6)')->andFilterWhere(['noi_dang_ky'=>'CS2'])->count();
            
            //$soLuongA01 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere('id_hang IN (7,8)')->count();
            $soLuongA011 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere('id_hang IN (7,8)')->andFilterWhere(['noi_dang_ky'=>'CS1'])->count();
            $soLuongA012 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere('id_hang IN (7,8)')->andFilterWhere(['noi_dang_ky'=>'CS2'])->count();
            
            //$soLuongA = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere('id_hang IN (9,10)')->count();
            $soLuongA1 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere('id_hang IN (9,10)')->andFilterWhere(['noi_dang_ky'=>'CS1'])->count();
            $soLuongA2 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere('id_hang IN (9,10)')->andFilterWhere(['noi_dang_ky'=>'CS2'])->count();
            
           /*  $soLuongNH1 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere('id_hang IN (11,12,13,14,15,16,17,18,19,20,21,22,23,24,25)')->andFilterWhere(['noi_dang_ky'=>'CS1'])->count();
            $soLuongNH2 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere('id_hang IN (11,12,13,14,15,16,17,18,19,20,21,22,23,24,25)')->andFilterWhere(['noi_dang_ky'=>'CS2'])->count(); */
            
            $soLuongNHC1 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere('id_hang IN (11,12,15,16)')->andFilterWhere(['noi_dang_ky'=>'CS1'])->count();
            $soLuongNHC2 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere('id_hang IN (11,12,15,16)')->andFilterWhere(['noi_dang_ky'=>'CS2'])->count();
            
            $soLuongNHD1 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere('id_hang IN (21,22,25,26)')->andFilterWhere(['noi_dang_ky'=>'CS1'])->count();
            $soLuongNHD2 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere('id_hang IN (21,22,25,26)')->andFilterWhere(['noi_dang_ky'=>'CS2'])->count();
            
            $soLuongNHD21 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere('id_hang IN (13,14,17,18,19,20)')->andFilterWhere(['noi_dang_ky'=>'CS1'])->count();
            $soLuongNHD22 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere('id_hang IN (13,14,17,18,19,20)')->andFilterWhere(['noi_dang_ky'=>'CS2'])->count();
            
            $soLuongNHCE1 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere('id_hang IN (23,24)')->andFilterWhere(['noi_dang_ky'=>'CS1'])->count();
            $soLuongNHCE2 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere('id_hang IN (23,24)')->andFilterWhere(['noi_dang_ky'=>'CS2'])->count();
            
            ?>
            <tr style="font-weight:bold">
                <td width="50px" align="center"></td>
                <td align="center">TỔNG CỘNG <br/>(Tất cả thời gian)</td>
                <td align="center"><?= number_format($soLuongHV) ?></td>
                <td align="center"><?= number_format($soLuongHV1) ?></td>
                <td align="center"><?= number_format($soLuongHV2) ?></td>
                <td align="center"><?= number_format($soLuongHV3) ?></td>
                <td align="center"><?= number_format($soLuongHV4) ?></td>
                <td align="center"><?= number_format($soLuongHV5) ?></td>
                <td align="center"><?= number_format($soLuongHV6) ?></td>
                <td align="center"><?= number_format($soLuongHV7) ?></td>
                
                <td align="center"><?= $soLuongBTD1 ?></td>
                <td align="center"><?= $soLuongBTD2 ?></td>
                
                <td align="center"><?= $soLuongBCK1 ?></td>
                <td align="center"><?= $soLuongBCK2 ?></td>
                
                <td align="center"><?= $soLuongC11 ?></td>
                <td align="center"><?= $soLuongC12 ?></td>
                
                <td align="center"><?= $soLuongA011 ?></td>
                <td align="center"><?= $soLuongA012 ?></td>
                
                <td align="center"><?= $soLuongA1 ?></td>
                <td align="center"><?= $soLuongA2 ?></td>  
                
                <?php /*?><td align="center"><?= $soLuongNH1 ?></td>
                <td align="center"><?= $soLuongNH2 ?></td> <?php */ ?>    
                
                <td align="center"><?= $soLuongNHC1 ?></td>
                <td align="center"><?= $soLuongNHC2 ?></td>
                
                <td align="center"><?= $soLuongNHD1 ?></td>
                <td align="center"><?= $soLuongNHD2 ?></td>
                
                <td align="center"><?= $soLuongNHD21 ?></td>
                <td align="center"><?= $soLuongNHD22 ?></td>
                
                <td align="center"><?= $soLuongNHCE1 ?></td>
                <td align="center"><?= $soLuongNHCE2 ?></td>
            
            </tr>
        </tbody>
    </table>
</div>
<?php CardWidget::end()?>