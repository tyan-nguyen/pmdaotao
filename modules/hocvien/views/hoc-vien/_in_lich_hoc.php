
<p style="text-align:right;"> Ngày in: <span><?= date('d/m/Y') ?></span></p>
<h3 style="text-align:center;">THỜI KHÓA BIỂU HỌC VIÊN</h3>
<p style="text-align:center;" > <span> <?=$tenKH?></span></p>
<p style="text-align:center;">
    Thời gian: <span><?= $startFormatted ?> - <?= $endFormatted ?></span>
</p>
<p style="text-align:center;">Họ tên học viên: <span><?= $tenHV?></span></p>


<div style="overflow-x: auto; width: 100%;">
    <table class="table table-bordered text-center" style="table-layout: fixed; width: 100%;" id="schedule-table">
        <thead>
            <tr class="header-cell">
                <th style="left: 0; z-index: 1;">Tiết</th>
                <th>Thứ 2</th>
                <th>Thứ 3</th>
                <th>Thứ 4</th>
                <th>Thứ 5</th>
                <th>Thứ 6</th>
                <th>Thứ 7</th>
                <th>Chủ Nhật</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $rendered = [];
        for ($slot = 1; $slot <= 13; $slot++): ?>
            <tr>
                <td class="header-cell" style="left: 0; ">Tiết <?= $slot ?></td>
                <?php for ($day = 2; $day <= 8; $day++): ?>
                    <?php
                    $hasData = false; 
                    if (!empty($data) && is_array($data)) {
                        foreach ($data as $index => $row): 
                            if ($row['tiet_bat_dau'] == $slot && $row['thu'] == $day && !in_array($index, $rendered)): 
                                $colspan = $row['tiet_ket_thuc'] - $row['tiet_bat_dau'] + 1; 
                                $hasData = true; 
                                ?>
                               <td rowspan="<?= $colspan ?>" style="vertical-align: top; text-align: left; padding: 5px; background-color: #f0f8ff; border: 1px solid #ddd;">
                                        <div class="course-box" 
                                             style="grid-row: <?= $row['tiet_bat_dau'] ?> / span <?= $colspan ?>; 
                                                    text-align:left; 
                                                    padding: 5px; 
                                                    background-color: #C0C0C0; 
                                                    height: <?= ($colspan * 25) ?>px;">
                                            <strong><?= $row->khoaHoc->ten_khoa_hoc ?? '(Không có dữ liệu)' ?></strong><br>
                                            <b>Nhóm:</b> <?= $row->nhomHoc->ten_nhom ?? '(Học chung)' ?><br>
                                            <b>Phòng:</b> <?= $row->phong->ten_phong ?? '(Không có dữ liệu)' ?><br>
                                            <b>GV:</b> <?= $row->giaoVien->ho_ten ?? '(Không có dữ liệu)' ?><br>
                                        </div>
                                </td>
                                <?php
                                for ($i = $row['tiet_bat_dau']; $i <= $row['tiet_ket_thuc']; $i++) {
                                    $rendered[] = $index;
                                }
                                break; 
                            endif;
                        endforeach;
                    }
                    if (!$hasData): ?>
                        <td></td>
                    <?php endif; ?>
                <?php endfor; ?>
            </tr>
        <?php endfor; ?>
        </tbody>
    </table>
</div>
<style>
table {
    border-collapse: collapse;
    border: 1px solid black; 
    width: 100%;
}

table th, table td {
    border: 1px solid black; 
    padding: 5px;
}
@media print {
    table {
        border-collapse: collapse;
        border: 1px solid black;
    }

    table th, table td {
        border: 1px solid black;
    }
}
table, table th, table td {
    border: 2px solid black; 
}

table {
    font-size: 12px; /* Kích cỡ chữ nhỏ lại */
    width: 100%; /* Chiếm đủ chiều rộng */
    table-layout: fixed; 
    border-collapse: collapse; 
}

th, td {
    border: 1px solid #000;
    padding: 4px; 
    text-align: center;
    word-wrap: break-word; 
}
th:first-child, td:first-child {
    width: 60px;
    min-width: 60px; 
    text-align: center; 
    background-color: #f9f9f9; 
}
.table td {
height: 30px; 
text-overflow: ellipsis; 
white-space: nowrap; 
}

</style>

