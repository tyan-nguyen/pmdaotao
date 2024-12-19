<?php 
    use yii\bootstrap5\Html;
    use app\modules\hocvien\models\HocVien;
    use app\modules\khoahoc\models\NhomHoc;
    $this->registerCssFile('@web/css/xem_hv.css', [
        'depends' => [\yii\bootstrap5\BootstrapAsset::className()],
    ]);
    $datas = HocVien::find()->where(['id_khoa_hoc' => $modelKH->id])->all();
    $nhomHocs = NhomHoc::find()->where(['id_khoa_hoc' => $modelKH->id])->all();
    $hasNhomHoc = !empty($nhomHocs); 
?>



<?php if (empty($datas)) : ?>
    <p style="color:chartreuse">Không tìm thấy Học viên</p>
<?php else : ?>
    <table class="table" id="hocVienTable">
        <thead>
            <tr>
                <th>STT</th>
                <th>Họ tên</th>
                <th>Số CCCD</th>
                <?php if ($hasNhomHoc): ?>
                    <th>Nhóm học</th>
                <?php endif; ?>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($datas as $iHv => $hv): ?>
                <tr>
                    <td><?= $iHv + 1 ?></td>
                    <td><?= $hv->ho_ten ?></td>
                    <td><?= $hv->so_cccd ?></td>
                    <?php if ($hasNhomHoc): ?>
                        <td>
                            <?php if ($hv->nhomHoc): ?>
                                <span class="badge bg-warning"><b><?= $hv->nhomHoc->ten_nhom ?></b></span>
                            <?php else: ?>
                                <span class="badge bg-danger"><b> Chưa sắp Nhóm </b></span>
                            <?php endif; ?>
                        </td>
                    <?php endif; ?>
                    <td>
                        <?= Html::a('<i class="fas fa-eye icon-white"></i>', 
                            ['/hocvien/hoc-vien/view', 'id' => $hv->id, 'modalType' => 'modal-remote-2'], 
                            ['class' => 'btn btn-sm btn-primary', 'title' => 'Xem', 'role' => 'modal-remote-2']
                        ); ?>

                        <?= Html::a('<i class="fa fa-remove"></i>', 
                            ['/hocvien/hoc-vien/delete-from-khoa-hoc', 'id' => $hv->id], 
                            ['class' => 'btn ripple btn-info btn-sm delete-hv-btn', 'title' => 'Xóa học viên', 'style' => 'color: white;', 'data-id' => $hv->id]
                        ); ?>

                        <?php if ($hasNhomHoc && $hv->id_nhom != null): ?>
                            <?= Html::a('<i class="fa fa-exchange"> </i>', 
                                ['/khoahoc/khoa-hoc/update-nhom', 'id' => $hv->id],
                                [
                                    'class' => 'btn ripple btn-success btn-sm',
                                    'title' => 'Đổi nhóm',
                                    'style' => 'color: white;',
                                    'role' => 'modal-remote-2',
                                ]
                            ) ?>
                        <?php endif; ?>

                        <?php if ($hasNhomHoc && $hv->id_nhom  == null): ?>
                            <?= Html::a('<i class="fa fa-plus"> </i>', 
                                    ['/khoahoc/khoa-hoc/add-nhom', 'id' => $hv->id],
                                    [
                                        'class' => 'btn ripple btn-warning btn-sm',
                                        'title' => 'Thêm nhóm',
                                        'style' => 'color: white;',
                                        'role' => 'modal-remote-2',
                                    ]
                        ) ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

