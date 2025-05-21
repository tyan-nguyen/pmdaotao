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
                <td width="50px" align="center">STT</td>
                <td align="center">Ngày</td>
                <td align="center">Tổng học viên mới</td>
                <td align="center">Hạng B tự động</td>
                <td align="center">Hạng B cơ khí</td>
                <td align="center">Hạng C1</td>
                <td align="center">Hạng A1</td>
                <td align="center">Hạng A</td>                
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
        $soLuongBTD = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere("DATE(thoi_gian_tao) = '$date'")->andWhere('id_hang IN (1,2)')->count();
        $soLuongBCK = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere("DATE(thoi_gian_tao) = '$date'")->andWhere('id_hang IN (3,4)')->count();
        $soLuongC1 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere("DATE(thoi_gian_tao) = '$date'")->andWhere('id_hang IN (5,6)')->count();
        $soLuongA1 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere("DATE(thoi_gian_tao) = '$date'")->andWhere('id_hang IN (7,8)')->count();
        $soLuongA = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere("DATE(thoi_gian_tao) = '$date'")->andWhere('id_hang IN (9,10)')->count();
        
    ?>
    <tr style="<?= $iDate==0?'color:red;font-weight:bold':'' ?>">
    	<td><?= ($iDate+1) ?></td>
    	<td align="center"><strong><?= CustomFunc::convertYMDToDMY($date) ?></strong></td>
    	<td align="center"><strong><?= $soLuongHV ?></strong></td>
    	<td align="center"><?= $soLuongBTD ?></td>
    	<td align="center"><?= $soLuongBCK ?></td>
    	<td align="center"><?= $soLuongC1 ?></td>
    	<td align="center"><?= $soLuongA1 ?></td>
    	<td align="center"><?= $soLuongA ?></td>
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
            </tr>
            <?php 
            $soLuongHV = DangKyHv::find()->where(['huy_ho_so'=>0])->count();
            $soLuongBTD = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere('id_hang IN (1,2)')->count();
            $soLuongBCK = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere('id_hang IN (3,4)')->count();
            $soLuongC1 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere('id_hang IN (5,6)')->count();
            $soLuongA1 = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere('id_hang IN (7,8)')->count();
            $soLuongA = DangKyHv::find()->where(['huy_ho_so'=>0])->andWhere('id_hang IN (9,10)')->count();
            ?>
            <tr style="font-weight:bold">
                <td width="50px" align="center"></td>
                <td align="center">TỔNG CỘNG <br/>(Tất cả thời gian)</td>
                <td align="center"><?= $soLuongHV ?></td>
                <td align="center"><?= $soLuongBTD ?></td>
                <td align="center"><?= $soLuongBCK ?></td>
                <td align="center"><?= $soLuongC1 ?></td>
                <td align="center"><?= $soLuongA1 ?></td>
                <td align="center"><?= $soLuongA ?></td>                
            </tr>
        </tbody>
    </table>
</div>
<?php CardWidget::end()?>