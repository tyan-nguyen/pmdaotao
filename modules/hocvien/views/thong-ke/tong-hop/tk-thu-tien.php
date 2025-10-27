<?php
use app\widgets\CardWidget;
use app\modules\hocvien\models\DangKyHv;
use app\custom\CustomFunc;
use app\modules\hocvien\models\NopHocPhi;
?>

<?php CardWidget::begin(['title'=>'Thu tiền mặt - Chuyển khoản (Tính đến ' .date('d/m/Y H:i:s') . ')' ]) ?>

<div class="table-responsive border p-0 pt-3">
    <table class="table table-bordered mg-b-0">
        <thead>
            <tr style="font-weight:bold">
                <td rowspan="2" width="50px" align="center">STT</td>
                <td rowspan="2" align="center">Ngày</td>
                <td rowspan="2" align="center">Tổng cộng</td>  
                <td colspan="2" align="center"><?= DangKyHv::getLabelNoiDangKyOther(DangKyHv::NOIDANGKY_CS1) ?></td>
                <td colspan="2" align="center"><?= DangKyHv::getLabelNoiDangKyOther(DangKyHv::NOIDANGKY_CS2) ?></td>
                <td colspan="2" align="center"><?= DangKyHv::getLabelNoiDangKyOther(DangKyHv::NOIDANGKY_CS3) ?></td>
                <td colspan="2" align="center"><?= DangKyHv::getLabelNoiDangKyOther(DangKyHv::NOIDANGKY_CS4) ?></td>
                <td colspan="2" align="center"><?= DangKyHv::getLabelNoiDangKyOther(DangKyHv::NOIDANGKY_CS5) ?></td>                
      			<td colspan="2" align="center"><?= DangKyHv::getLabelNoiDangKyOther(DangKyHv::NOIDANGKY_CS6) ?></td>
      			<td colspan="2" align="center"><?= DangKyHv::getLabelNoiDangKyOther(DangKyHv::NOIDANGKY_CS7) ?></td>  
      			<td colspan="2" align="center"><?= DangKyHv::getLabelNoiDangKyOther(DangKyHv::NOIDANGKY_CS8) ?></td>
      			<td colspan="2" align="center"><?= DangKyHv::getLabelNoiDangKyOther(DangKyHv::NOIDANGKY_CS9) ?></td> 
      			<td colspan="2" align="center"><?= DangKyHv::getLabelNoiDangKyOther(DangKyHv::NOIDANGKY_CS10) ?></td>                       
            </tr>
            <tr>
            	<td align="center">Tiền mặt</td>
                <td align="center">Chuyển khoản</td>
                <td align="center">Tiền mặt</td>
                <td align="center">Chuyển khoản</td>
                
                <td align="center">Tiền mặt</td>
                <td align="center">Chuyển khoản</td>
                <td align="center">Tiền mặt</td>
                <td align="center">Chuyển khoản</td>
                <td align="center">Tiền mặt</td>
                <td align="center">Chuyển khoản</td>
                <td align="center">Tiền mặt</td>
                <td align="center">Chuyển khoản</td>
                <td align="center">Tiền mặt</td>
                <td align="center">Chuyển khoản</td>
                <td align="center">Tiền mặt</td>
                <td align="center">Chuyển khoản</td>
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
        $sumCS1TM = NopHocPhi::find()->alias('t')->joinWith(['nguoiTao as nt', 'hocVien as hv'])
        ->where([
            'hv.huy_ho_so' => 0,
            'nt.noi_dang_ky'=>'CS1', 
            'hinh_thuc_thanh_toan'=>'TM'
        ]) ->andWhere("DATE(t.thoi_gian_tao) = '$date'")->sum('so_tien_nop');
        $sumCS1CK = NopHocPhi::find()->alias('t')->joinWith(['nguoiTao as nt', 'hocVien as hv'])
        ->where([
            'hv.huy_ho_so' => 0,
            'nt.noi_dang_ky'=>'CS1',
            'hinh_thuc_thanh_toan'=>'CK'
        ]) ->andWhere("DATE(t.thoi_gian_tao) = '$date'")->sum('so_tien_nop');
        $sumCS2TM = NopHocPhi::find()->alias('t')->joinWith(['nguoiTao as nt', 'hocVien as hv'])
        ->where([
            'hv.huy_ho_so' => 0,
            'nt.noi_dang_ky'=>'CS2',
            'hinh_thuc_thanh_toan'=>'TM'
        ]) ->andWhere("DATE(t.thoi_gian_tao) = '$date'")->sum('so_tien_nop');
        $sumCS2CK = NopHocPhi::find()->alias('t')->joinWith(['nguoiTao as nt', 'hocVien as hv'])
        ->where([
            'hv.huy_ho_so' => 0,
            'nt.noi_dang_ky'=>'CS2',
            'hinh_thuc_thanh_toan'=>'CK'
        ])->andWhere("DATE(t.thoi_gian_tao) = '$date'")->sum('so_tien_nop');
        
        $sumCS3TM = NopHocPhi::find()->alias('t')->joinWith(['nguoiTao as nt', 'hocVien as hv'])
        ->where([
            'hv.huy_ho_so' => 0,
            'nt.noi_dang_ky'=>DangKyHv::NOIDANGKY_CS3,
            'hinh_thuc_thanh_toan'=>'TM'
        ]) ->andWhere("DATE(t.thoi_gian_tao) = '$date'")->sum('so_tien_nop');
        $sumCS3CK = NopHocPhi::find()->alias('t')->joinWith(['nguoiTao as nt', 'hocVien as hv'])
        ->where([
            'hv.huy_ho_so' => 0,
            'nt.noi_dang_ky'=>DangKyHv::NOIDANGKY_CS3,
            'hinh_thuc_thanh_toan'=>'CK'
        ])->andWhere("DATE(t.thoi_gian_tao) = '$date'")->sum('so_tien_nop');
        
        $sumCS4TM = NopHocPhi::find()->alias('t')->joinWith(['nguoiTao as nt', 'hocVien as hv'])
        ->where([
            'hv.huy_ho_so' => 0,
            'nt.noi_dang_ky'=>DangKyHv::NOIDANGKY_CS4,
            'hinh_thuc_thanh_toan'=>'TM'
        ]) ->andWhere("DATE(t.thoi_gian_tao) = '$date'")->sum('so_tien_nop');
        $sumCS4CK = NopHocPhi::find()->alias('t')->joinWith(['nguoiTao as nt', 'hocVien as hv'])
        ->where([
            'hv.huy_ho_so' => 0,
            'nt.noi_dang_ky'=>DangKyHv::NOIDANGKY_CS4,
            'hinh_thuc_thanh_toan'=>'CK'
        ])->andWhere("DATE(t.thoi_gian_tao) = '$date'")->sum('so_tien_nop');
        
        $sumCS5TM = NopHocPhi::find()->alias('t')->joinWith(['nguoiTao as nt', 'hocVien as hv'])
        ->where([
            'hv.huy_ho_so' => 0,
            'nt.noi_dang_ky'=>DangKyHv::NOIDANGKY_CS5,
            'hinh_thuc_thanh_toan'=>'TM'
        ]) ->andWhere("DATE(t.thoi_gian_tao) = '$date'")->sum('so_tien_nop');
        $sumCS5CK = NopHocPhi::find()->alias('t')->joinWith(['nguoiTao as nt', 'hocVien as hv'])
        ->where([
            'hv.huy_ho_so' => 0,
            'nt.noi_dang_ky'=>DangKyHv::NOIDANGKY_CS5,
            'hinh_thuc_thanh_toan'=>'CK'
        ])->andWhere("DATE(t.thoi_gian_tao) = '$date'")->sum('so_tien_nop');
        
        $sumCS6TM = NopHocPhi::find()->alias('t')->joinWith(['nguoiTao as nt', 'hocVien as hv'])
        ->where([
            'hv.huy_ho_so' => 0,
            'nt.noi_dang_ky'=>DangKyHv::NOIDANGKY_CS6,
            'hinh_thuc_thanh_toan'=>'TM'
        ]) ->andWhere("DATE(t.thoi_gian_tao) = '$date'")->sum('so_tien_nop');
        $sumCS6CK = NopHocPhi::find()->alias('t')->joinWith(['nguoiTao as nt', 'hocVien as hv'])
        ->where([
            'hv.huy_ho_so' => 0,
            'nt.noi_dang_ky'=>DangKyHv::NOIDANGKY_CS6,
            'hinh_thuc_thanh_toan'=>'CK'
        ])->andWhere("DATE(t.thoi_gian_tao) = '$date'")->sum('so_tien_nop');
        
        $sumCS7TM = NopHocPhi::find()->alias('t')->joinWith(['nguoiTao as nt', 'hocVien as hv'])
        ->where([
            'hv.huy_ho_so' => 0,
            'nt.noi_dang_ky'=>DangKyHv::NOIDANGKY_CS7,
            'hinh_thuc_thanh_toan'=>'TM'
        ]) ->andWhere("DATE(t.thoi_gian_tao) = '$date'")->sum('so_tien_nop');
        $sumCS7CK = NopHocPhi::find()->alias('t')->joinWith(['nguoiTao as nt', 'hocVien as hv'])
        ->where([
            'hv.huy_ho_so' => 0,
            'nt.noi_dang_ky'=>DangKyHv::NOIDANGKY_CS7,
            'hinh_thuc_thanh_toan'=>'CK'
        ])->andWhere("DATE(t.thoi_gian_tao) = '$date'")->sum('so_tien_nop');
        
        $sumCS8TM = NopHocPhi::find()->alias('t')->joinWith(['nguoiTao as nt', 'hocVien as hv'])
        ->where([
            'hv.huy_ho_so' => 0,
            'nt.noi_dang_ky'=>DangKyHv::NOIDANGKY_CS8,
            'hinh_thuc_thanh_toan'=>'TM'
        ]) ->andWhere("DATE(t.thoi_gian_tao) = '$date'")->sum('so_tien_nop');
        $sumCS8CK = NopHocPhi::find()->alias('t')->joinWith(['nguoiTao as nt', 'hocVien as hv'])
        ->where([
            'hv.huy_ho_so' => 0,
            'nt.noi_dang_ky'=>DangKyHv::NOIDANGKY_CS8,
            'hinh_thuc_thanh_toan'=>'CK'
        ])->andWhere("DATE(t.thoi_gian_tao) = '$date'")->sum('so_tien_nop');
        
        $sumCS9TM = NopHocPhi::find()->alias('t')->joinWith(['nguoiTao as nt', 'hocVien as hv'])
        ->where([
            'hv.huy_ho_so' => 0,
            'nt.noi_dang_ky'=>DangKyHv::NOIDANGKY_CS9,
            'hinh_thuc_thanh_toan'=>'TM'
        ]) ->andWhere("DATE(t.thoi_gian_tao) = '$date'")->sum('so_tien_nop');
        $sumCS9CK = NopHocPhi::find()->alias('t')->joinWith(['nguoiTao as nt', 'hocVien as hv'])
        ->where([
            'hv.huy_ho_so' => 0,
            'nt.noi_dang_ky'=>DangKyHv::NOIDANGKY_CS9,
            'hinh_thuc_thanh_toan'=>'CK'
        ])->andWhere("DATE(t.thoi_gian_tao) = '$date'")->sum('so_tien_nop');
        
        $sumCS10TM = NopHocPhi::find()->alias('t')->joinWith(['nguoiTao as nt', 'hocVien as hv'])
        ->where([
            'hv.huy_ho_so' => 0,
            'nt.noi_dang_ky'=>DangKyHv::NOIDANGKY_CS10,
            'hinh_thuc_thanh_toan'=>'TM'
        ]) ->andWhere("DATE(t.thoi_gian_tao) = '$date'")->sum('so_tien_nop');
        $sumCS10CK = NopHocPhi::find()->alias('t')->joinWith(['nguoiTao as nt', 'hocVien as hv'])
        ->where([
            'hv.huy_ho_so' => 0,
            'nt.noi_dang_ky'=>DangKyHv::NOIDANGKY_CS10,
            'hinh_thuc_thanh_toan'=>'CK'
        ])->andWhere("DATE(t.thoi_gian_tao) = '$date'")->sum('so_tien_nop');
        
        $sumTong = NopHocPhi::find()->alias('t')->joinWith(['nguoiTao as nt', 'hocVien as hv'])
            ->where([
                'hv.huy_ho_so' => 0,
            ])
            ->andWhere("DATE(t.thoi_gian_tao) = '$date'")->sum('so_tien_nop');
        
    ?>
    <tr style="<?= $iDate==0?'color:red;font-weight:bold':'' ?>">
    	<td><?= ($iDate+1) ?></td>
    	<td align="center"><strong><?= CustomFunc::convertYMDToDMY($date) ?></strong></td>
    	<td align="right"><?= $sumTong?number_format($sumTong):0 ?></td>
    	<td align="right"><?= $sumCS1TM?number_format($sumCS1TM):0 ?></td>
    	<td align="right"><?= $sumCS1CK?number_format($sumCS1CK):0 ?></td>
    	<td align="right"><?= $sumCS2TM?number_format($sumCS2TM):0 ?></td>
    	<td align="right"><?= $sumCS2CK?number_format($sumCS2CK):0 ?></td>
    	
    	<td align="right"><?= $sumCS3TM?number_format($sumCS3TM):0 ?></td>
    	<td align="right"><?= $sumCS3CK?number_format($sumCS3CK):0 ?></td>
    	<td align="right"><?= $sumCS4TM?number_format($sumCS4TM):0 ?></td>
    	<td align="right"><?= $sumCS4CK?number_format($sumCS4CK):0 ?></td>
    	<td align="right"><?= $sumCS5TM?number_format($sumCS5TM):0 ?></td>
    	<td align="right"><?= $sumCS5CK?number_format($sumCS5CK):0 ?></td>
    	<td align="right"><?= $sumCS6TM?number_format($sumCS6TM):0 ?></td>
    	<td align="right"><?= $sumCS6CK?number_format($sumCS6CK):0 ?></td>
    	<td align="right"><?= $sumCS7TM?number_format($sumCS7TM):0 ?></td>
    	<td align="right"><?= $sumCS7CK?number_format($sumCS7CK):0 ?></td>
    	<td align="right"><?= $sumCS8TM?number_format($sumCS8TM):0 ?></td>
    	<td align="right"><?= $sumCS8CK?number_format($sumCS8CK):0 ?></td>
    	<td align="right"><?= $sumCS9TM?number_format($sumCS9TM):0 ?></td>
    	<td align="right"><?= $sumCS9CK?number_format($sumCS9CK):0 ?></td>
    	<td align="right"><?= $sumCS10TM?number_format($sumCS10TM):0 ?></td>
    	<td align="right"><?= $sumCS10CK?number_format($sumCS10CK):0 ?></td>
    	
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
                <td align="center">...</td>
                <td align="center">...</td>
                <td align="center">...</td>  
            </tr>
            <?php 
            $sumCS1TM = NopHocPhi::find()->alias('t')->joinWith(['nguoiTao as nt', 'hocVien as hv'])
            ->where([
                'hv.huy_ho_so' => 0,
                'nt.noi_dang_ky'=>'CS1',
                'hinh_thuc_thanh_toan'=>'TM'
            ])->sum('so_tien_nop');
            $sumCS1CK = NopHocPhi::find()->alias('t')->joinWith(['nguoiTao as nt', 'hocVien as hv'])
            ->where([
                'hv.huy_ho_so' => 0,
                'nt.noi_dang_ky'=>'CS1',
                'hinh_thuc_thanh_toan'=>'CK'
            ])->sum('so_tien_nop');
            $sumCS2TM = NopHocPhi::find()->alias('t')->joinWith(['nguoiTao as nt', 'hocVien as hv'])
            ->where([
                'hv.huy_ho_so' => 0,
                'nt.noi_dang_ky'=>'CS2',
                'hinh_thuc_thanh_toan'=>'TM'
            ])->sum('so_tien_nop');
            $sumCS2CK = NopHocPhi::find()->alias('t')->joinWith(['nguoiTao as nt', 'hocVien as hv'])
            ->where([
                'hv.huy_ho_so' => 0,
                'nt.noi_dang_ky'=>'CS2',
                'hinh_thuc_thanh_toan'=>'CK'
            ])->sum('so_tien_nop');
            
            $sumCS3TM = NopHocPhi::find()->alias('t')->joinWith(['nguoiTao as nt', 'hocVien as hv'])
            ->where([
                'hv.huy_ho_so' => 0,
                'nt.noi_dang_ky'=>DangKyHv::NOIDANGKY_CS3,
                'hinh_thuc_thanh_toan'=>'TM'
            ])->sum('so_tien_nop');
            $sumCS3CK = NopHocPhi::find()->alias('t')->joinWith(['nguoiTao as nt', 'hocVien as hv'])
            ->where([
                'hv.huy_ho_so' => 0,
                'nt.noi_dang_ky'=>DangKyHv::NOIDANGKY_CS3,
                'hinh_thuc_thanh_toan'=>'CK'
            ])->sum('so_tien_nop');
            
            $sumCS4TM = NopHocPhi::find()->alias('t')->joinWith(['nguoiTao as nt', 'hocVien as hv'])
            ->where([
                'hv.huy_ho_so' => 0,
                'nt.noi_dang_ky'=>DangKyHv::NOIDANGKY_CS4,
                'hinh_thuc_thanh_toan'=>'TM'
            ])->sum('so_tien_nop');
            $sumCS4CK = NopHocPhi::find()->alias('t')->joinWith(['nguoiTao as nt', 'hocVien as hv'])
            ->where([
                'hv.huy_ho_so' => 0,
                'nt.noi_dang_ky'=>DangKyHv::NOIDANGKY_CS4,
                'hinh_thuc_thanh_toan'=>'CK'
            ])->sum('so_tien_nop');
            
            $sumCS5TM = NopHocPhi::find()->alias('t')->joinWith(['nguoiTao as nt', 'hocVien as hv'])
            ->where([
                'hv.huy_ho_so' => 0,
                'nt.noi_dang_ky'=>DangKyHv::NOIDANGKY_CS5,
                'hinh_thuc_thanh_toan'=>'TM'
            ])->sum('so_tien_nop');
            $sumCS5CK = NopHocPhi::find()->alias('t')->joinWith(['nguoiTao as nt', 'hocVien as hv'])
            ->where([
                'hv.huy_ho_so' => 0,
                'nt.noi_dang_ky'=>DangKyHv::NOIDANGKY_CS5,
                'hinh_thuc_thanh_toan'=>'CK'
            ])->sum('so_tien_nop');
            
            $sumCS6TM = NopHocPhi::find()->alias('t')->joinWith(['nguoiTao as nt', 'hocVien as hv'])
            ->where([
                'hv.huy_ho_so' => 0,
                'nt.noi_dang_ky'=>DangKyHv::NOIDANGKY_CS6,
                'hinh_thuc_thanh_toan'=>'TM'
            ])->sum('so_tien_nop');
            $sumCS6CK = NopHocPhi::find()->alias('t')->joinWith(['nguoiTao as nt', 'hocVien as hv'])
            ->where([
                'hv.huy_ho_so' => 0,
                'nt.noi_dang_ky'=>DangKyHv::NOIDANGKY_CS6,
                'hinh_thuc_thanh_toan'=>'CK'
            ])->sum('so_tien_nop');
            
            $sumCS7TM = NopHocPhi::find()->alias('t')->joinWith(['nguoiTao as nt', 'hocVien as hv'])
            ->where([
                'hv.huy_ho_so' => 0,
                'nt.noi_dang_ky'=>DangKyHv::NOIDANGKY_CS7,
                'hinh_thuc_thanh_toan'=>'TM'
            ])->sum('so_tien_nop');
            $sumCS7CK = NopHocPhi::find()->alias('t')->joinWith(['nguoiTao as nt', 'hocVien as hv'])
            ->where([
                'hv.huy_ho_so' => 0,
                'nt.noi_dang_ky'=>DangKyHv::NOIDANGKY_CS7,
                'hinh_thuc_thanh_toan'=>'CK'
            ])->sum('so_tien_nop');
            
            $sumCS8TM = NopHocPhi::find()->alias('t')->joinWith(['nguoiTao as nt', 'hocVien as hv'])
            ->where([
                'hv.huy_ho_so' => 0,
                'nt.noi_dang_ky'=>DangKyHv::NOIDANGKY_CS8,
                'hinh_thuc_thanh_toan'=>'TM'
            ])->sum('so_tien_nop');
            $sumCS8CK = NopHocPhi::find()->alias('t')->joinWith(['nguoiTao as nt', 'hocVien as hv'])
            ->where([
                'hv.huy_ho_so' => 0,
                'nt.noi_dang_ky'=>DangKyHv::NOIDANGKY_CS8,
                'hinh_thuc_thanh_toan'=>'CK'
            ])->sum('so_tien_nop');
            
            $sumCS9TM = NopHocPhi::find()->alias('t')->joinWith(['nguoiTao as nt', 'hocVien as hv'])
            ->where([
                'hv.huy_ho_so' => 0,
                'nt.noi_dang_ky'=>DangKyHv::NOIDANGKY_CS9,
                'hinh_thuc_thanh_toan'=>'TM'
            ])->sum('so_tien_nop');
            $sumCS9CK = NopHocPhi::find()->alias('t')->joinWith(['nguoiTao as nt', 'hocVien as hv'])
            ->where([
                'hv.huy_ho_so' => 0,
                'nt.noi_dang_ky'=>DangKyHv::NOIDANGKY_CS9,
                'hinh_thuc_thanh_toan'=>'CK'
            ])->sum('so_tien_nop');
            
            $sumCS10TM = NopHocPhi::find()->alias('t')->joinWith(['nguoiTao as nt', 'hocVien as hv'])
            ->where([
                'hv.huy_ho_so' => 0,
                'nt.noi_dang_ky'=>DangKyHv::NOIDANGKY_CS10,
                'hinh_thuc_thanh_toan'=>'TM'
            ])->sum('so_tien_nop');
            $sumCS10CK = NopHocPhi::find()->alias('t')->joinWith(['nguoiTao as nt', 'hocVien as hv'])
            ->where([
                'hv.huy_ho_so' => 0,
                'nt.noi_dang_ky'=>DangKyHv::NOIDANGKY_CS10,
                'hinh_thuc_thanh_toan'=>'CK'
            ])->sum('so_tien_nop');
            
            $sumTong = NopHocPhi::find()->alias('t')->joinWith(['nguoiTao as nt', 'hocVien as hv'])
            ->where([
                'hv.huy_ho_so' => 0,
            ])->sum('so_tien_nop');
            ?>
            <tr style="font-weight:bold;">
                <td width="50px" align="center"></td>
                <td align="center">TỔNG CỘNG <br/>(Tất cả thời gian)</td>
                <td align="right"><?= $sumTong?number_format($sumTong):0 ?></td>
                <td align="right"><?= $sumCS1TM?number_format($sumCS1TM):0 ?></td>
                <td align="right"><?= $sumCS1CK?number_format($sumCS1CK):0 ?></td>
                <td align="right"><?= $sumCS2TM?number_format($sumCS2TM):0 ?></td>
                <td align="right"><?= $sumCS2CK?number_format($sumCS2CK):0 ?></td>
                <td align="right"><?= $sumCS3TM?number_format($sumCS3TM):0 ?></td>
                <td align="right"><?= $sumCS3CK?number_format($sumCS3CK):0 ?></td>
                <td align="right"><?= $sumCS4TM?number_format($sumCS4TM):0 ?></td>
                <td align="right"><?= $sumCS4CK?number_format($sumCS4CK):0 ?></td>
                <td align="right"><?= $sumCS5TM?number_format($sumCS5TM):0 ?></td>
                <td align="right"><?= $sumCS5CK?number_format($sumCS5CK):0 ?></td>
                <td align="right"><?= $sumCS6TM?number_format($sumCS6TM):0 ?></td>
                <td align="right"><?= $sumCS6CK?number_format($sumCS6CK):0 ?></td>
                <td align="right"><?= $sumCS7TM?number_format($sumCS7TM):0 ?></td>
                <td align="right"><?= $sumCS7CK?number_format($sumCS7CK):0 ?></td>
                <td align="right"><?= $sumCS8TM?number_format($sumCS8TM):0 ?></td>
                <td align="right"><?= $sumCS8CK?number_format($sumCS8CK):0 ?></td>
                <td align="right"><?= $sumCS9TM?number_format($sumCS9TM):0 ?></td>
                <td align="right"><?= $sumCS9CK?number_format($sumCS9CK):0 ?></td>
                <td align="right"><?= $sumCS9TM?number_format($sumCS10TM):0 ?></td>
                <td align="right"><?= $sumCS9CK?number_format($sumCS10CK):0 ?></td>
                                
            </tr>
        </tbody>
    </table>
</div>
<?php CardWidget::end()?>