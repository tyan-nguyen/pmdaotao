<?php
 use yii\bootstrap5\Html;
?>
<div style="overflow-x: auto; width: 100%;" id="#lhContent">
    <table class="table table-bordered text-center" style="table-layout: fixed; width: 100%;" id="schedule-table">
        <thead>
            <tr class="header-cell">
                <th style="position: sticky; left: 0; background-color: #f8f9fa; z-index: 1;">Tiết</th>
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
                <td class="header-cell" style="position: sticky; left: 0; background-color: #f8f9fa;">Tiết <?= $slot ?></td>
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
                                                    background-color: #f0f8ff; 
                                                    height: <?= ($colspan * 30) ?>px;">
                                            <strong><?= $row->khoaHoc->ten_khoa_hoc ?? '(Không có dữ liệu)' ?></strong><br>
                                            <b>Nhóm:</b> <?= $row->nhomHoc->ten_nhom ?? '(Học chung)' ?><br>
                                            <b>Phòng:</b> <?= $row->phong->ten_phong ?? '(Không có dữ liệu)' ?><br>
                                            <b>GV:</b> <?= $row->giaoVien->ho_ten ?? '(Không có dữ liệu)' ?><br>
                                            <div class="course-details" style="text-align:left;">
                                                <p><strong>Khóa học:</strong> <?= $row->khoaHoc->ten_khoa_hoc ?? '(Không có dữ liệu)'?></p>
                                                <p><strong>Nhóm học:</strong> <?= $row->nhomHoc->ten_nhom ?? '(Không có dữ liệu)'?></p>
                                                <p><strong>GVGD:</strong> <?= $row->giaoVien->ho_ten ?? '(Không có dữ liệu)' ?></p>
                                                <p><strong>Phòng học:</strong> <?= $row->phong->ten_phong ?? '(Không có dữ liệu)'?></p>
                                                <p><strong>Ngày học:</strong> <?= Yii::$app->formatter->asDate($row->ngay, 'php:d-m-Y') ?? '(Không có dữ liệu)' ?></p>
                                                <p><strong>Học phần:</strong> <?= $row->hoc_phan ?? '(Không có dữ liệu)' ?></p>
                                                <p><strong>Tiết bắt đầu:</strong> <?= $row->tiet_bat_dau ?? '(Không có dữ liệu)' ?></p>
                                                <p><strong>Tiết kết thúc:</strong> <?= $row->tiet_ket_thuc ?? '(Không có dữ liệu)' ?></p>
                                            </div>
                                        </div>
                                      
                                        <?= Html::a('<i class="fa fa-exchange"> </i>', 
                                             ['/hocvien/hoc-vien/update-lich-hoc','id' => $row->id,'id_khoa_hoc'=>$row->id_khoa_hoc,'idHV'=>$idHV,'week_string'=>$week_string],
                                                [
                                                   'class' => 'btn ripple btn-success btn-sm',
                                                   'title' => 'Cập nhật',
                                                   'style' => 'color: white;',
                                                   'role' => 'modal-remote-2',
                                                ]
                                        ) ?>
                                     
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
