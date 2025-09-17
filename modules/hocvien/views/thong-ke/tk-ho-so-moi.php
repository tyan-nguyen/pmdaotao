<?php 
use app\widgets\CardWidget;
use app\modules\hocvien\models\DangKyHv;
use app\custom\CustomFunc;

$listCN = DangKyHv::getDmNoiDangKyShort();
?>

<?php CardWidget::begin(['title'=>'Học viên đăng ký mới' ]) ?>
<div class="table-responsive border p-0 pt-3">
	<table class="table table-bordered mg-b-0">
		 <thead>
            <tr style="font-weight:bold">
                <td width="50px" rowspan="2" align="center">STT</td>
                <td align="center" rowspan="2">Ngày</td>
                <td align="center" colspan="<?= (count($listCN) + 1) ?>">Tổng học viên mới</td>
                <td align="center" colspan="<?= count($listCN) ?>">Hạng B tự động</td>
                <td align="center" colspan="<?= count($listCN) ?>">Hạng B cơ khí</td>
                <td align="center" colspan="<?= count($listCN) ?>">Hạng C1</td>
                <td align="center" colspan="<?= count($listCN) ?>">Hạng A1</td>
                <td align="center" colspan="<?= count($listCN) ?>">Hạng A</td>     
                <!-- <td align="center" colspan="2">Nâng hạng (C, D, D2, CE)</td>   -->
                <td align="center" colspan="<?= count($listCN) ?>">Nâng hạng C</td> 
                <td align="center" colspan="<?= count($listCN) ?>">Nâng hạng D</td>          
                <td align="center" colspan="<?= count($listCN) ?>">Nâng hạng D2</td>   
                <td align="center" colspan="<?= count($listCN) ?>">Nâng hạng CE</td>
            </tr>
            <tr style="font-weight:bold">
               
                
                <td align="center">Tổng</td>
                
                <?php foreach ($listCN as $iList=>$list){ ?>
                <td align="center"><?= $list ?></td> 
                <?php } ?>
                <!-- <td align="center">Tổng</td>-->
                <!-- Hạng B tự động -->
                <?php foreach ($listCN as $iList=>$list){ ?>
                <td align="center"><?= $list ?></td> 
                <?php } ?>                
                <!-- Hạng B cơ khí -->
                <?php foreach ($listCN as $iList=>$list){ ?>
                <td align="center"><?= $list ?></td> 
                <?php } ?>
                <!-- Hạng C1 -->
                <?php foreach ($listCN as $iList=>$list){ ?>
                <td align="center"><?= $list ?></td> 
                <?php } ?>
                <!-- Hạng A1 -->
                <?php foreach ($listCN as $iList=>$list){ ?>
                <td align="center"><?= $list ?></td> 
                <?php } ?>
                <!-- Hạng A -->
                <?php foreach ($listCN as $iList=>$list){ ?>
                <td align="center"><?= $list ?></td> 
                <?php } ?>
                 <!-- Nâng hạng -->
                <!-- <td align="center">CS1</td>
                <td align="center">CS2</td>  -->      
                 <!-- Nâng hạng C -->
                <?php foreach ($listCN as $iList=>$list){ ?>
                <td align="center"><?= $list ?></td> 
                <?php } ?>    
                 <!-- Nâng hạng D -->
                <?php foreach ($listCN as $iList=>$list){ ?>
                <td align="center"><?= $list ?></td> 
                <?php } ?>   
                 <!-- Nâng hạngD2 -->
                <?php foreach ($listCN as $iList=>$list){ ?>
                <td align="center"><?= $list ?></td> 
                <?php } ?>   
                 <!-- Nâng hạng CE -->
                <?php foreach ($listCN as $iList=>$list){ ?>
                <td align="center"><?= $list ?></td> 
                <?php } ?>        
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
            ?>
             <tr style="<?= $iDate==0?'color:red;font-weight:bold':'' ?>">
             	<td><?= ($iDate+1) ?></td>
				<td align="center"><strong><?= CustomFunc::convertYMDToDMY($date) ?></strong></td>
             	<td><?php 
             	  $soLuongHV = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere("DATE(thoi_gian_tao) = '$date'")->count();
             	  echo $soLuongHV;
             	?></td>
             	<?php 
             	foreach ($listCN as $iList=>$list){
             	    $soLuongHV = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere("DATE(thoi_gian_tao) = '$date'")->andFilterWhere(['noi_dang_ky'=>$iList])->count();
             	?>
             	<td align="center"><?= $soLuongHV>0?$soLuongHV:'-' ?></td>
             	<?php } ?>
             	
             	
             	<?php 
             	foreach ($listCN as $iList=>$list){
             	    $soLuong = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere("DATE(thoi_gian_tao) = '$date'")->andWhere('id_hang IN (1,2)')->andFilterWhere(['noi_dang_ky'=>$iList])->count();
             	?>
             	<td align="center"><?= $soLuong>0?$soLuong:'-' ?></td>
             	<?php } ?>
             	
             	<?php 
             	foreach ($listCN as $iList=>$list){
             	    $soLuong = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere("DATE(thoi_gian_tao) = '$date'")->andWhere('id_hang IN (3,4)')->andFilterWhere(['noi_dang_ky'=>$iList])->count();
             	?>
             	<td align="center"><?= $soLuong>0?$soLuong:'-' ?></td>
             	<?php } ?>
             	
             	<?php 
             	foreach ($listCN as $iList=>$list){
             	    $soLuong = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere("DATE(thoi_gian_tao) = '$date'")->andWhere('id_hang IN (5,6)')->andFilterWhere(['noi_dang_ky'=>$iList])->count();
             	?>
             	<td align="center"><?= $soLuong>0?$soLuong:'-' ?></td>
             	<?php } ?>
             	
             	<?php 
             	foreach ($listCN as $iList=>$list){
             	    $soLuong = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere("DATE(thoi_gian_tao) = '$date'")->andWhere('id_hang IN (7,8)')->andFilterWhere(['noi_dang_ky'=>$iList])->count();
             	?>
             	<td align="center"><?= $soLuong>0?$soLuong:'-' ?></td>
             	<?php } ?>
             	
             	<?php 
             	foreach ($listCN as $iList=>$list){
             	    $soLuong = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere("DATE(thoi_gian_tao) = '$date'")->andWhere('id_hang IN (9,10)')->andFilterWhere(['noi_dang_ky'=>$iList])->count();
             	?>
             	<td align="center"><?= $soLuong>0?$soLuong:'-' ?></td>
             	<?php } ?>
             	
             	<?php 
             	foreach ($listCN as $iList=>$list){
             	    $soLuong = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere("DATE(thoi_gian_tao) = '$date'")->andWhere('id_hang IN (11,12,15,16)')->andFilterWhere(['noi_dang_ky'=>$iList])->count();
             	?>
             	<td align="center"><?= $soLuong>0?$soLuong:'-' ?></td>
             	<?php } ?>
             	
             	<?php 
             	foreach ($listCN as $iList=>$list){
             	    $soLuong = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere("DATE(thoi_gian_tao) = '$date'")->andWhere('id_hang IN (21,22,25,26)')->andFilterWhere(['noi_dang_ky'=>$iList])->count();
             	?>
             	<td align="center"><?= $soLuong>0?$soLuong:'-' ?></td>
             	<?php } ?>
             	
             	<?php 
             	foreach ($listCN as $iList=>$list){
             	    $soLuong = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere("DATE(thoi_gian_tao) = '$date'")->andWhere('id_hang IN (13,14,17,18,19,20)')->andFilterWhere(['noi_dang_ky'=>$iList])->count();
             	?>
             	<td align="center"><?= $soLuong>0?$soLuong:'-' ?></td>
             	<?php } ?>
             	
             	<?php 
             	foreach ($listCN as $iList=>$list){
             	    $soLuong = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere("DATE(thoi_gian_tao) = '$date'")->andWhere('id_hang IN (23,24)')->andFilterWhere(['noi_dang_ky'=>$iList])->count();
             	?>
             	<td align="center"><?= $soLuong>0?$soLuong:'-' ?></td>
             	<?php } ?>
             	
             </tr>
            <?php } ?>	
            
            <tr>
            	<td width="50px" align="center">..</td>
                <td align="center">...</td>
                <td align="center">...</td>
                <?php 
                for($iCN=1;$iCN<=10;$iCN++){
             	  foreach ($listCN as $iList=>$list){
             	?>
             		<td align="center">...</td>
             	<?php } } ?>
            </tr>
            
             <tr style="font-weight:bold">
                <td width="50px" align="center"></td>
                <td align="center">TỔNG CỘNG <br/>(Tất cả thời gian)</td>
                <?php 
                $soLuongHV = DangKyHv::find()->where(['huy_ho_so'=>0])->count();
                ?>
                <td align="center"><?= number_format($soLuongHV) ?></td>
                <?php 
             	foreach ($listCN as $iList=>$list){
             	    $soLuongHV = DangKyHv::find()->where(['huy_ho_so'=>0])->andFilterWhere(['noi_dang_ky'=>$iList])->count();
             	?>
             	<td align="center"><?= number_format($soLuongHV) ?></td>
             	<?php } ?>
             	
             	<!-- B tự động -->
             	 <?php 
             	foreach ($listCN as $iList=>$list){
             	    $soLuongHV = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere('id_hang IN (1,2)')->andFilterWhere(['noi_dang_ky'=>$iList])->count();
             	?>
             	<td align="center"><?= number_format($soLuongHV) ?></td>
             	<?php } ?>
             	
             	<!-- B cơ khí -->
             	<?php 
             	foreach ($listCN as $iList=>$list){
             	    $soLuongHV = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere('id_hang IN (3,4)')->andFilterWhere(['noi_dang_ky'=>$iList])->count();
             	?>
             	<td align="center"><?= number_format($soLuongHV) ?></td>
             	<?php } ?>
             	<!-- C1 -->
             	<?php 
             	foreach ($listCN as $iList=>$list){
             	    $soLuongHV = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere('id_hang IN (5,6)')->andFilterWhere(['noi_dang_ky'=>$iList])->count();
             	?>
             	<td align="center"><?= number_format($soLuongHV) ?></td>
             	<?php } ?>
             	<!-- A1 -->
             	<?php 
             	foreach ($listCN as $iList=>$list){
             	    $soLuongHV = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere('id_hang IN (7,8)')->andFilterWhere(['noi_dang_ky'=>$iList])->count();
             	?>
             	<td align="center"><?= number_format($soLuongHV) ?></td>
             	<?php } ?>
             	
             	<!-- A -->
             	<?php 
             	foreach ($listCN as $iList=>$list){
             	    $soLuongHV = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere('id_hang IN (9,10)')->andFilterWhere(['noi_dang_ky'=>$iList])->count();
             	?>
             	<td align="center"><?= number_format($soLuongHV) ?></td>
             	<?php } ?>
             	
             	<!-- NHC1 -->
             	<?php 
             	foreach ($listCN as $iList=>$list){
             	    $soLuongHV = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere('id_hang IN (11,12,15,16)')->andFilterWhere(['noi_dang_ky'=>$iList])->count();
             	?>
             	<td align="center"><?= number_format($soLuongHV) ?></td>
             	<?php } ?>
             	
             	<!-- NHD1 -->
             	<?php 
             	foreach ($listCN as $iList=>$list){
             	    $soLuongHV = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere('id_hang IN (21,22,25,26)')->andFilterWhere(['noi_dang_ky'=>$iList])->count();
             	?>
             	<td align="center"><?= number_format($soLuongHV) ?></td>
             	<?php } ?>
             	
             	<!-- NHD2 -->
             	<?php 
             	foreach ($listCN as $iList=>$list){
             	    $soLuongHV = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere('id_hang IN (13,14,17,18,19,20)')->andFilterWhere(['noi_dang_ky'=>$iList])->count();
             	?>
             	<td align="center"><?= number_format($soLuongHV) ?></td>
             	<?php } ?>
             	
             	<!-- NHE1 -->
             	<?php 
             	foreach ($listCN as $iList=>$list){
             	    $soLuongHV = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere('id_hang IN (23,24)')->andFilterWhere(['noi_dang_ky'=>$iList])->count();
             	?>
             	<td align="center"><?= number_format($soLuongHV) ?></td>
             	<?php } ?>
             	
             	
             </tr>
            
            
            <!-- footer -->
            
            	    
        </tbody>
        
	</table>
</div>
<?php CardWidget::end()?>