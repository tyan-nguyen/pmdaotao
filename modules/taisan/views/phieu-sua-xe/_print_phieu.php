<?php

use yii\helpers\Html;
use app\custom\CustomFunc;
use app\modules\taisan\models\PhieuDeNghi;

$custom = new CustomFunc();
//sét tên phiếu
if ($model->loai_phieu == PhieuDeNghi::LOAIPHIEU_MUASAM) {
	$tenPhieu = 'PHIẾU ĐỀ NGHỊ CẤP VẬT TƯ';
} elseif ($model->loai_phieu == PhieuDeNghi::LOAIPHIEU_SUACHUA) {
	$tenPhieu = 'PHIẾU ĐỀ NGHỊ SỬA CHỮA';
	if ($model->loai_tai_san == PhieuDeNghi::LOAITAISAN_XE) {
		$tenPhieu = 'PHIẾU ĐỀ NGHỊ SỬA CHỮA/BẢO DƯỠNG XE';
	}
}
?>
<!-- <link href="/css/print-hoa-don.css" rel="stylesheet"> -->
<div class="row text-center" style="width: 100%">
	<div class="col-md-12" style="width: 100%">
		<table id="table-top" style="width: 100%">
			<tr>
				<!-- <td>
					<img src="/libs/images/logo.png" width="100px" />
				</td> -->
				<td width="30%" style="text-align: center;">
					<span style="font-weight: bold; font-size:12pt">DNTN SX-TM<br />NGUYỄN TRÌNH</span>
					<hr style="width:35%;margin: auto" />
				</td>
				<td width="70%" style="text-align: center;">
					<span style="font-weight: bold; font-size:12pt">CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</span><br />
					<span style="font-weight: bold; font-size:12pt">Độc lập – Tự do – Hạnh phúc</span>
					<hr style="width:55%;margin: auto" />
				</td>
				<!-- <td width="50%">
					<div><span style="font-size:10pt"><?= $model->soVaoSo ?></span></div>
					<div style="margin-top: 5px;">
						<span class="span-status" style="font-size:9pt"><?= $model->getTrangThaiList()[$model->trang_thai] ?></span>
					</div>
				</td> -->
				<!-- <td>
					<span style="font-weight: bold; font-size:10pt;color:red">TRUNG TÂM GDNN & SHLX NGUYỄN TRÌNH</span>
					<br />
					<span style="font-size:9pt"><i class="fas fa-map-marker-alt" style="color:red;margin-right:2px"></i> Địa chỉ đăng ký: Nguyễn Đáng, Khóm 10, Phường Trà Vinh, Vĩnh Long</span>
					<br />
					<span style="font-size:9pt"><i class="fas fa-home" style="color:red"></i> Địa chỉ TT: Ấp Giồng Trôm, Xã Châu Thành, Tỉnh Vĩnh Long</span>
					<br />
					<span style="font-size:9pt"><i class="fas fa-globe" style="color:red"></i> Website: nguyentrinh.com.vn</span> - <span style="font-size:9pt"><i class="fas fa-phone" style="color:red"></i> ĐT: 0903 336 470</span>
					<br/>
    				<span style="font-size:9pt"><i class="fas fa-envelope" style="color:red"></i> Email: nguyentrinh@nguyentrinhtravinh.com.vn</span>
				</td> -->
			</tr>
		</table>

		<table style="width: 100%; margin-top:10px;margin-bottom:10px;">
			<tr>
				<td style="text-align: center"><span style="font-size:20pt;font-weight:bold"><?= $tenPhieu ?></span></td>
			</tr>
		</table>

		<table id="table-info" style="width: 100%; margin-top:0px;font-size: 14pt">
			<tr>
				<td width="90%">
					Bộ phận: Trung tâm GDNN & SHLX Nguyễn Trình
				</td>
				<td width="10%">
					Số phiếu: <?= 'P' . str_pad($model->so_phieu, 6, '0', STR_PAD_LEFT); ?>
				</td>
			</tr>
			<tr>
				<td width="90%">
					Hạng mục: <?= $model->getLoaiSuaXeList()[$model->loai_yeu_cau] ?? '' ?>
				</td>
				<td width="10%">
					Trạng thái: <?= $model->getTrangThaiList()[$model->trang_thai] ?>
				</td>
			</tr>
			<tr>
				<td width="90%">
					Địa điểm thực hiện: <?= $model->donViThucHien ? $model->donViThucHien->ten : '' ?>
				</td>
				<td width="10%">
					Ngày duyệt: <?= CustomFunc::convertYMDHISToDMY($model->ngay_duyet) ?>
				</td>
			</tr>
			<tr>
				<td width="100%" colspan="2">
					Xe/Thiết bị: <?= $model->tenThamChieu ?>
				</td>
			</tr>
			<tr>
				<td width="100%" colspan="2">
					Nội dung đề nghị: <?= $model->noi_dung_de_nghi ?>
				</td>

			</tr>
		</table>

		<?php if ($model->chiTiets != null) { ?>
			<table id="table-content" style="width: 100%; margin-top:5px;font-size: 12pt">
				<thead>
					<tr style="font-weight:bold">
						<td style="width:3%">STT</td>
						<td style="width:12%">Loại hạng mục</td>
						<td style="width:12%">Tên hạng mục</td>
						<td style="width:10%">ĐVT</td>
						<td style="width:10%">Số lượng</td>
						<td style="width:12%">Sử dụng cho</td>
						<td style="width:15%">Ghi chú</td>
					</tr>
				</thead>
				<tbody>
					<?php
					$stt = 0;
					foreach ($model->chiTiets as $iVT => $vt) {
						$stt++;
					?>
						<tr>
							<td style="text-align:center"><?= $stt ?></td>
							<td style="text-align:center"><?= $vt->hangMuc->loaiHangMuc->ten ?></td>
							<td><?= $vt->hangMuc->ten ?></td>
							<td style="text-align:center"><?= $vt->hangMuc->dvt ?></td>
							<td style="text-align:right"><?= $vt->so_luong ?></td>
							<td style="text-align:center"><?= $vt->phieuDeNghi->tenThamChieu ?? '' ?></td>
							<td style="text-align:center">
								<?= $vt->ghi_chu ?>
							</td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		<?php } ?>

		<table id="table-ky-ten" style="width: 100%; margin-top:5px;font-size: 11pt">
			<tr>
				<td style="text-align:right;font-weight:normal;font-style:italic;">Vĩnh Long, ngày <?= date('d') ?> tháng <?= date('m') ?> năm <?= date('Y') ?></td>
			</tr>
		</table>

		<table id="table-ky-ten" style="width: 100%; margin-top:5px;font-size: 11pt">
			<tr>
				<td style="width:25%;text-align:center;"><span style="font-weight:bold">Xét duyệt lãnh đạo</span><br /><span style="font-style:italic;font-weight: normal;">(Nếu có)</span></td>
				<td style="width:25%;text-align:center;"><span style="font-weight:bold">Bộ phận kiểm tra</span><br /><span style="font-style:italic;font-weight: normal;">(Ký, ghi rõ họ tên)</span></td>
				<td style="width:25%;text-align:center;"><span style="font-weight:bold">Quản lý bộ phận</span><br /><span style="font-style:italic;font-weight: normal;">(Ký, ghi rõ họ tên)</span></td>
				<td style="width:25%;text-align:center;"><span style="font-weight:bold">Người đề nghị</span><br /><span style="font-style:italic;font-weight: normal;">(Ký, ghi rõ họ tên)</span></td>
			</tr>
			<tr>
				<td style="padding-top:50px;">..........</td>
				<td style="padding-top:50px;">..........</td>
				<td style="padding-top:50px;">..........</td>
				<td style="padding-top:50px;">..........</td>
			</tr>
		</table>

		<table id="table-footer" style="width: 100%; margin-top:10px;">
			<tr>
				<td style="font-size: 8pt"></td>
				<td style="font-size: 8pt">Ngày in: <?= date('d/m/Y H:i') ?></td>
			</tr>
		</table>






	</div>
</div> <!-- row -->