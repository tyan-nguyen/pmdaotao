<?php
use app\widgets\CardWidget;
use app\modules\hocvien\models\DangKyHv;
use app\custom\CustomFunc;
use app\modules\hocvien\models\NopHocPhi;
use app\modules\banhang\models\HoaDon;
use app\modules\banhang\models\HoaDonChiTiet;
use yii\db\Expression;
?>

<?php CardWidget::begin(['title'=>'Thu tiền mặt - Chuyển khoản của bán hàng (Tính đến ' .date('d/m/Y H:i:s') . ')' ]) ?>
<ul>
	<li>Vé thuê xe A, A1</li>
	<li>Thuê xe thô</li>
	<li>Đồng phục</li>
	<li>Tài liệu</li>
</ul>

<div class="table-responsive border p-0 pt-3">
    <table class="table table-bordered mg-b-0">
        <thead>
            <tr style="font-weight:bold">
                <td rowspan="2" width="50px" align="center">STT</td>
                <td rowspan="2" align="center">Ngày</td>
                <td rowspan="2" align="center">Tổng cộng</td>  
                <td colspan="2" align="center">Cơ sở 1</td>
                <td colspan="2" align="center">Cơ sở 2</td>
                
                             
            </tr>
            <tr>
            	<td align="center">Tiền mặt</td>
                <td align="center">Chuyển khoản</td>
                <td align="center">Tiền mặt</td>
                <td align="center">Chuyển khoản</td>
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
        $sumCS1TM = HoaDon::tongTienNgayTM($date, false);        
        $sumCS1CK = HoaDon::tongTienNgayCK($date, false);
        $sumCS2TM = HoaDon::tongTienNgayTM($date, false);
        $sumCS2CK = HoaDon::tongTienNgayCK($date, false);
        $sumTong = HoaDon::tongTienNgay($date, false);
        
    ?>
    <tr style="<?= $iDate==0?'color:red;font-weight:bold':'' ?>">
    	<td><?= ($iDate+1) ?></td>
    	<td align="center"><strong><?= CustomFunc::convertYMDToDMY($date) ?></strong></td>
    	<td align="right"><?= $sumTong?number_format($sumTong):0 ?></td>
    	<td align="right"><?= $sumCS1TM?number_format($sumCS1TM):0 ?></td>
    	<td align="right"><?= $sumCS1CK?number_format($sumCS1CK):0 ?></td>
    	<td align="right"><?= $sumCS2TM?number_format($sumCS2TM):0 ?></td>
    	<td align="right"><?= $sumCS2CK?number_format($sumCS2CK):0 ?></td>    	
    </tr>
    
    <?php 
        /* $query = HoaDonChiTiet::find()->alias('t');
        //$query->joinWith(['donHang as dh']);
        $query->select([
            't.*',
            'SUM(t.so_luong) AS tongSoLuongSanPham',
            'SUM(t.so_luong * t.don_gia) AS tongTienSanPham',
            'SUM(t.chiet_khau) as tongChietKhauSanPham'
        ]);
        $query->innerJoinWith(['donHang as dh']);
        $query->andFilterWhere(['>=', 'DATE(dh.ngay_xuat)', $date]);
        $query->andFilterWhere(['t.nguoi_tao' => $byuser]);
        
        $query->groupBy(['t.id_hang_hoa']);
        $sumCS1VeA = (float) $query->sum(new Expression('COALESCE(COALESCE(ct.so_luong,0) * COALESCE(ct.don_gia,0) - COALESCE(ct.chiet_khau,0),0)')); */
    ?>
    
    
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
            </tr>
            <?php 
            $sumCS1TM = HoaDon::tongTienNgayTM($date, true);
            $sumCS1CK = HoaDon::tongTienNgayCK($date, true);
            $sumCS2TM = HoaDon::tongTienNgayTM($date, true);
            $sumCS2CK = HoaDon::tongTienNgayCK($date, true);
            $sumTong = HoaDon::tongTienNgay($date, true);
            ?>
            <tr style="font-weight:bold;">
                <td width="50px" align="center"></td>
                <td align="center">TỔNG CỘNG <br/>(Tất cả thời gian)</td>
                <td align="right"><?= $sumTong?number_format($sumTong):0 ?></td>
                <td align="right"><?= $sumCS1TM?number_format($sumCS1TM):0 ?></td>
                <td align="right"><?= $sumCS1CK?number_format($sumCS1CK):0 ?></td>
                <td align="right"><?= $sumCS2TM?number_format($sumCS2TM):0 ?></td>
                <td align="right"><?= $sumCS2CK?number_format($sumCS2CK):0 ?></td>
                                
            </tr>
        </tbody>
    </table>
</div>
<?php CardWidget::end()?>