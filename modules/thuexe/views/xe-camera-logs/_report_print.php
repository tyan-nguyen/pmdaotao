<?php

use yii\helpers\Html;
use app\custom\CustomFunc;
use app\modules\thuexe\models\XeLuotRaVao;
use app\modules\user\models\User;

/* @var $this yii\web\View */
/* @var $groupedData array */
/* @var $loaiBaoCao string */
/* @var $khuVucCong string|null */
/* @var $tenKhuVucDisplay string|null */
/* @var $tuNgay string */
/* @var $denNgay string */
/* @var $tuNgayDisplay string */
/* @var $denNgayDisplay string */
/* @var $titleBaoCao string */

$currentUser = User::getCurrentUser();
$nguoiLap = ($currentUser && method_exists($currentUser, 'getHoTen')) ? ($currentUser->getHoTen() ?: $currentUser->username) : 'Hệ thống';
?>

<div class="camera-print-sheet" style="width: 100%; font-family: 'Times New Roman', Times, serif; font-size: 11pt; color: #000; background: #fff; line-height: 1.3;">
    <!-- Header Cơ Quan & Quốc Hiệu -->
    <table style="width: 100%; border: none; border-collapse: collapse; margin-bottom: 12px;">
        <tr>
            <td style="font-weight: bold; text-align: center; font-size: 11pt; width: 45%; vertical-align: top; border: none; padding: 0;">
                TRUNG TÂM GDNN &amp; SHLX NGUYỄN TRÌNH<br>
                <span style="font-weight: normal; font-size: 9.5pt; text-transform: uppercase;">Bộ phận Quản lý Phương tiện &amp; Đào tạo</span><br>
                <span>***</span>
            </td>
            <td style="text-align: center; font-size: 10.5pt; width: 55%; vertical-align: top; border: none; padding: 0;">
                <strong style="font-size: 11pt;">CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</strong><br>
                <span style="text-decoration: underline; font-style: italic;">Độc lập - Tự do - Hạnh phúc</span>
            </td>
        </tr>
    </table>

    <!-- Tiêu Đề Báo Cáo -->
    <table style="width: 100%; margin-top: 10px; margin-bottom: 14px; border: none; border-collapse: collapse;">
        <tr>
            <td style="text-align: center; border: none; padding: 0;">
                <div style="font-size: 15pt; font-weight: bold; text-transform: uppercase;">
                    <?= Html::encode($titleBaoCao) ?>
                </div>
                <?php if (!empty($tenKhuVucDisplay)): ?>
                    <div style="font-size: 11.5pt; font-weight: bold; color: #1a4f8b; margin-top: 2px; text-transform: uppercase;">
                        [<?= Html::encode($tenKhuVucDisplay) ?>]
                    </div>
                <?php endif; ?>
                <div style="font-style: italic; font-size: 10pt; margin-top: 3px;">
                    (Tổng hợp kết quả vi phạm theo lần - Trích xuất từ Hệ thống Camera giám sát ANPR)
                </div>
                <div style="text-align: center; padding-top: 5px; font-style: italic; font-size: 10.5pt;">
                    Thời gian thống kê: Từ ngày <strong><?= Html::encode($tuNgayDisplay) ?></strong> đến ngày <strong><?= Html::encode($denNgayDisplay) ?></strong>
                </div>
            </td>
        </tr>
    </table>

    <!-- Bảng Tổng Hợp Vi Phạm Theo Lần -->
    <table style="width: 100%; border-collapse: collapse; margin-top: 10px; border: 1px solid #000;">
        <thead>
            <tr style="background-color: #f2f2f2; text-align: center; font-weight: bold;">
                <th style="width: 35px; border: 1px solid #000; padding: 5px 4px; text-align: center;">STT</th>
                <th style="width: 95px; border: 1px solid #000; padding: 5px 4px; text-align: center;">Biển số xe</th>
                <th style="width: 125px; border: 1px solid #000; padding: 5px 6px; text-align: center;">Giáo viên / Phụ trách</th>
                <th style="width: 65px; border: 1px solid #000; padding: 5px 4px; text-align: center;">Tổng lượt</th>
                <th style="border: 1px solid #000; padding: 5px 8px; text-align: left;">Tổng hợp vi phạm theo từng lần (Thời gian đi - về)</th>
                <th style="width: 110px; border: 1px solid #000; padding: 5px 4px; text-align: center;">Đánh giá / Ghi chú</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($groupedData)): ?>
                <tr>
                    <td colspan="6" style="text-align: center; font-style: italic; padding: 18px 0; color: #555; border: 1px solid #000;">
                        Không tìm thấy phương tiện nào vi phạm trong khoảng thời gian đã chọn.
                    </td>
                </tr>
            <?php else: ?>
                <?php
                $stt = 0;
                $grandTotalTrips = 0;
                $grandTotalQuaDem = 0;

                foreach ($groupedData as $bs => $v):
                    $stt++;
                    $tripCount = count($v['trips']);
                    $grandTotalTrips += $tripCount;
                    $grandTotalQuaDem += $v['qua_dem_count'];

                    // Đánh giá mức độ vi phạm
                    if ($loaiBaoCao === 'XE_QUA_DEM') {
                        $danhGia = $v['qua_dem_count'] >= 2 ? 'Lưu đêm ' . $v['qua_dem_count'] . ' lần' : 'Lưu đêm 1 lần';
                    } else {
                        $danhGia = $tripCount >= 3 ? 'Cần nhắc nhở (≥ 3 lần)' : ($tripCount >= 2 ? 'Vi phạm 2 lần' : 'Vi phạm 1 lần');
                    }
                ?>
                <tr>
                    <td style="text-align: center; border: 1px solid #000; padding: 5px 4px; vertical-align: middle;"><?= $stt ?></td>
                    <td style="text-align: center; font-weight: bold; border: 1px solid #000; padding: 5px 4px; vertical-align: middle;">
                        <?= Html::encode($v['bien_so']) ?>
                        <?php if (!empty($v['hieu_xe'])): ?>
                            <div style="font-weight: normal; font-size: 9pt; color: #555;">(<?= Html::encode($v['hieu_xe']) ?>)</div>
                        <?php endif; ?>
                    </td>
                    <td style="text-align: center; border: 1px solid #000; padding: 5px 6px; vertical-align: middle;">
                        <?= Html::encode($v['giao_vien'] ?: 'Chưa phân công') ?>
                    </td>
                    <td style="text-align: center; font-weight: bold; border: 1px solid #000; padding: 5px 4px; vertical-align: middle;">
                        <?= $tripCount ?>
                    </td>
                    <td style="text-align: left; padding: 5px 8px; font-size: 10pt; border: 1px solid #000; vertical-align: middle;">
                        <?php
                        $lanIdx = 0;
                        foreach ($v['trips'] as $trip):
                            $lanIdx++;
                            $tgDiFormatted = $trip->thoi_gian_di ? CustomFunc::convertYMDHISToDMYHI($trip->thoi_gian_di) : 'Chưa ghi nhận';
                            $tgVeFormatted = $trip->thoi_gian_ve ? CustomFunc::convertYMDHISToDMYHI($trip->thoi_gian_ve) : 'Chưa ghi nhận';
                            $tgNgoai = ($trip->so_phut_o_ngoai > 0) ? XeLuotRaVao::formatPhutToLabel($trip->so_phut_o_ngoai) : '';
                            $isQuaDem = ($trip->qua_dem == XeLuotRaVao::QUA_DEM_CO);
                        ?>
                            <div style="margin-bottom: 3px; line-height: 1.35;">
                                <span style="font-weight: bold; color: #1a4f8b;">• Lần <?= $lanIdx ?>:</span>
                                <span><?= $tgDiFormatted ?></span>
                                <span>→</span>
                                <span><?= $tgVeFormatted ?></span>
                                <?php if ($tgNgoai): ?>
                                    <span style="color: #444;">(Thời gian: <?= $tgNgoai ?>)</span>
                                <?php endif; ?>
                                <?php if ($isQuaDem): ?>
                                    <span style="color: #7b1fa2; font-weight: bold;">[Qua đêm]</span>
                                <?php endif; ?>
                                <?php if ($trip->trang_thai_ke_hoach === XeLuotRaVao::KE_HOACH_UNPLANNED && $loaiBaoCao !== 'XE_KHONG_KE_HOACH'): ?>
                                    <span style="color: #c00000; font-weight: bold;">[Không KH]</span>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </td>
                    <td style="text-align: center; font-size: 9.5pt; border: 1px solid #000; padding: 5px 4px; vertical-align: middle;">
                        <?= Html::encode($danhGia) ?>
                    </td>
                </tr>
                <?php endforeach; ?>

                <!-- Dòng Tổng Cộng -->
                <tr style="font-weight: bold; background-color: #f7f7f7;">
                    <td colspan="3" style="text-align: right; padding: 6px 10px; border: 1px solid #000;">
                        TỔNG CỘNG (<?= count($groupedData) ?> xe):
                    </td>
                    <td style="text-align: center; border: 1px solid #000; padding: 6px 4px;"><?= $grandTotalTrips ?></td>
                    <td style="padding: 6px 8px; border: 1px solid #000;">
                        Tổng số lượt vi phạm: <strong><?= $grandTotalTrips ?></strong> lượt
                        <?php if ($grandTotalQuaDem > 0): ?>
                            | Trong đó có <strong><?= $grandTotalQuaDem ?></strong> lượt qua đêm
                        <?php endif; ?>
                    </td>
                    <td style="text-align: center; border: 1px solid #000; padding: 6px 4px;">-</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Ký Tên & Thời Gian Lập -->
    <table style="width: 100%; margin-top: 25px; border: none; border-collapse: collapse;">
        <tr>
            <td style="width: 45%; border: none; padding: 0;"></td>
            <td style="text-align: center; font-style: italic; font-size: 10.5pt; width: 55%; border: none; padding: 0;">
                Vĩnh Long, ngày <?= date('d') ?> tháng <?= date('m') ?> năm <?= date('Y') ?>
            </td>
        </tr>
        <tr>
            <td style="border: none; padding: 0;"></td>
            <td style="text-align: center; font-weight: bold; font-size: 11pt; padding-top: 4px; border: none;">
                NGƯỜI LẬP BÁO CÁO
            </td>
        </tr>
        <tr>
            <td style="border: none; padding: 0;"></td>
            <td style="padding-top: 55px; font-size: 11pt; font-weight: bold; text-align: center; border: none;">
                <?= Html::encode($nguoiLap) ?>
            </td>
        </tr>
    </table>

    <div style="width: 100%; text-align: right; font-style: italic; font-size: 8.5pt; margin-top: 15px; color: #666;">
        Thời gian xuất bản in: <?= date('d/m/Y H:i:s') ?> (Phần mềm Quản lý đào tạo - Module Quản lý lượt xe Camera <?= !empty($tenKhuVucDisplay) ? ' - ' . Html::encode($tenKhuVucDisplay) : '' ?>)
    </div>
</div>
