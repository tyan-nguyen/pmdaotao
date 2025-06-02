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
                <td align="center" colspan="3">Tổng học viên mới</td>
                <td align="center" colspan="2">Hạng B tự động</td>
                <td align="center" colspan="2">Hạng B cơ khí</td>
                <td align="center" colspan="2">Hạng C1</td>
                <td align="center" colspan="2">Hạng A1</td>
                <td align="center" colspan="2">Hạng A</td>                
            </tr>
            <tr style="font-weight:bold">
               
                
                <!-- <td align="center">Tổng</td> -->
                <td align="center">CS1</td>
                <td align="center">CS2</td>
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
        
    ?>
    <tr style="<?= $iDate==0?'color:red;font-weight:bold':'' ?>">
    	<td><?= ($iDate+1) ?></td>
    	<td align="center"><strong><?= CustomFunc::convertYMDToDMY($date) ?></strong></td>
    	<td align="center"><strong><?= $soLuongHV ?></strong></td>
    	<td align="center"><?= $soLuongHV1 ?></td>
    	<td align="center"><?= $soLuongHV2 ?></td>
    	
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
            </tr>
            <?php 
            $soLuongHV = DangKyHv::find()->where(['huy_ho_so'=>0])->count();
            $soLuongHV1 = DangKyHv::find()->where(['huy_ho_so'=>0])->andFilterWhere(['noi_dang_ky'=>'CS1'])->count();
            $soLuongHV2 = DangKyHv::find()->where(['huy_ho_so'=>0])->andFilterWhere(['noi_dang_ky'=>'CS2'])->count();
            
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
            ?>
            <tr style="font-weight:bold">
                <td width="50px" align="center"></td>
                <td align="center">TỔNG CỘNG <br/>(Tất cả thời gian)</td>
                <td align="center"><?= $soLuongHV ?></td>
                <td align="center"><?= $soLuongHV1 ?></td>
                <td align="center"><?= $soLuongHV2 ?></td>
                
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
            </tr>
        </tbody>
    </table>
</div>
<?php CardWidget::end()?>