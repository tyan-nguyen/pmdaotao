<?php

use app\modules\thuexe\models\HinhXe;
use app\custom\CustomFunc;
use app\modules\thuexe\models\Xe;
use app\widgets\FileDisplayWidget;
use yii\helpers\Html;
use yii\bootstrap5\Modal;
//use cangak\ajaxcrud\CrudAsset;

//CrudAsset::register($this);
\kartik\date\DatePickerAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\HvHocVien */
// Giả sử $id là ID của xe đang xem
$hinhXeList = HinhXe::find()->where(['id_xe' => $model->id])->all();
$hinhXeCount = !empty($hinhXeList) ? count($hinhXeList) : 0;
$giayToCount = count($model->getGiayTosMoiNhat());
$fileCount = \app\modules\kholuutru\models\File::find()
    ->where(['doi_tuong' => Xe::MODEL_ID, 'id_doi_tuong' => $model->id])
    ->count();

// Preload Leaflet map library
$this->registerCssFile('https://unpkg.com/leaflet@1.9.4/dist/leaflet.css', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', ['position' => \yii\web\View::POS_HEAD]);
?>
<div class="hv-hoc-vien-view">

    <div class="row">
        <div class="col-xl-6 col-md-12">
            <div class="card custom-card">
                <div class="card-header custom-card-header rounded-bottom-0">
                    <div>
                        <h6 class="card-title mb-0 text-center" style="color: red;">Thông tin Xe</h6>
                    </div>
                </div>
                <div class="card-body">
                    <div class="skill-tags">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                            <div>
                                <p>
                                    <strong>Loại xe:</strong> <?= $model->loaiXe->ten_loai_xe ?>
                                    <span style="margin-left: 30px;"></span> <strong>Biển số xe:</strong> <?= $model->bien_so_xe ?>
                                </p>
                                <p>
                                    <strong>Tên xe:</strong> <?= $model->hieu_xe ?>

                                </p>
                                <p><strong>Phân loại:</strong> <?= $model->getLabelPhanLoaiXe() ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Mã số:</strong> <?= $model->ma_so ?></p>
                            </div>

                            <div>
                                <?= $model->qrLink ? Html::img($model->qrLink, ['style' => 'width:100px;height:100px; display:block;']) : '' ?>
                            </div>
                        </div>

                        <p style="display: flex; justify-content: space-between; align-items: center;">
                            <span>
                                <strong>Màu sắc:</strong> <?= $model->renderBadgeMauSac(18) ?> <?= $model->mau_sac ? Html::encode($model->mau_sac) : '' ?>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Số IMEI GPS:</strong> <?= $model->imei_gps ? Html::encode($model->imei_gps) : 'Chưa có' ?>
                            </span>
                            <?php if ($model->imei_gps): ?>
                                <span>
                                    <?= Html::a('<i class="fa fa-map-marker-alt"></i> Xem bản đồ', ['xem-vi-tri-gps', 'id' => $model->id], ['role' => 'modal-remote', 'class' => 'btn btn-outline-primary btn-sm', 'style' => 'margin-top:0px; margin-bottom:0px']) ?>
                                </span>
                            <?php endif; ?>
                        </p>
                        <p><strong>Tình trạng xe:</strong> <?= $model->tinh_trang_xe ?>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <strong>Trạng thái:</strong> <?= $model->trang_thai ?>
                        </p>
                        <p><strong>Người phụ trách:</strong> <?= $model->giaoVien ? $model->giaoVien->ho_ten : '' ?>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <strong>Giấy tờ xe:</strong> <?= $model->getTrangThaiGiayToBadge() ?>
                        </p>
                        <p><strong>Số KM cập nhật gần nhất: <?= $model->getKMHienTai() ?> km</strong>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <strong>Ngày cập nhật KM:</strong> <?= CustomFunc::convertYMDHISToDMY($model->getNgayCapNhatKMHienTai()) ?>
                        </p>
                        <p><strong>Ghi chú:</strong> <?= $model->ghi_chu ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-md-12">
            <div class="card custom-card">
                <div class="card-header custom-card-header rounded-bottom-0">
                    <div>
                        <h6 class="card-title mb-0 text-center" style="color: red;">Thông tin khác</h6>
                    </div>
                </div>
                <div class="card-body">
                    <div class="skill-tags">
                        <p><strong>Số hợp đồng xe:</strong> <?= $model->so_hop_dong ?></p>
                        <p><strong>Đặc điểm:</strong> <?= $model->dac_diem ?></p>
                    </div>

                    <div class="skill-tags">
                        <p><strong>Số khung:</strong> <?= $model->so_khung ?>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <strong>Số máy/Số động cơ:</strong> <?= $model->so_may ?>
                        </p>
                        <p><strong>Xe mới/Đã qua sử dụng:</strong> <?= $model->la_xe_cu == 1 ? 'Xe đã qua sử dụng' : 'Xe mới' ?>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <strong>Ngày đăng kiểm:</strong> <?= CustomFunc::convertYMDToDMY($model->ngay_dang_kiem) ?>
                        </p>
                        <p><strong>Giá trị xe:</strong> <?= number_format($model->so_tien) . ' đ' ?>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <strong>Số hóa đơn:</strong> <?= $model->so_hoa_don ?>
                        </p>
                        <p><strong>Năm sản xuất:</strong> <?= $model->nam_san_xuat ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Năm mua:</strong> <?= $model->nam_mua ?></p>
                        <p><strong>Nhà cung cấp:</strong> <?= $model->nha_cung_cap ?></p>
                        <p>
                            <strong>Đơn vị sở hữu:</strong> <?= $model->donViSoHuu ? Html::encode($model->donViSoHuu->ten_don_vi) : '' ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12 col-md-12">
            <div class="card custom-card">
                <div class="card-header custom-card-header rounded-bottom-0">
                    <ul class="nav nav-tabs" id="xeDetailTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="hinh-anh-xe-tab" data-bs-toggle="tab" href="#pane-hinh-anh-xe" role="tab" aria-controls="pane-hinh-anh-xe" aria-selected="true" style="color: blue;">
                                <i class="fa fa-file-image-o me-1"></i> Hình ảnh xe (<?= $hinhXeCount ?>)
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="xe-giay-to-tab" data-bs-toggle="tab" href="#pane-xe-giay-to" role="tab" aria-controls="pane-xe-giay-to" aria-selected="false" style="color: blue;">
                                <i class="fa fa-file-text-o me-1"></i> Giấy tờ xe (<span id="giay-to-count-badge"><?= $giayToCount ?></span>)
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="file-dinh-kem-tab" data-bs-toggle="tab" href="#pane-file-dinh-kem" role="tab" aria-controls="pane-file-dinh-kem" aria-selected="false" style="color: blue;">
                                <i class="fa fa-paperclip me-1"></i> File đính kèm (<?= $fileCount ?>)
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="skill-tags">
                        <div class="tab-content" id="xeDetailTabContent">
                            <div class="tab-pane fade active show" id="pane-hinh-anh-xe" role="tabpanel" aria-labelledby="hinh-anh-xe-tab">
                                <?php if (!empty($hinhXeList)): ?>
                                    <div class="row">
                                        <?php foreach ($hinhXeList as $hinhXe): ?>
                                            <div class="col-md-4 mb-3">
                                                <img src="<?= Yii::getAlias('@web/images/hinh-xe/' . $hinhXe->hinh_anh) ?>" alt="Hình ảnh xe" class="img-fluid rounded uniform-img" data-fancybox="gallery1" data-caption="<?= $hinhXe->hinh_anh ?>" style="<?= $hinhXe->la_dai_dien ? 'border:1px solid blue' : '' ?>" />
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <p class="text-muted p-2">Không có hình ảnh nào cho xe này.</p>
                                <?php endif; ?>
                            </div>

                            <div class="tab-pane fade" id="pane-xe-giay-to" role="tabpanel" aria-labelledby="xe-giay-to-tab">

                                <?= $this->render('_giay_to_xe_wrap', ['model' => $model]) ?>

                            </div>

                            <div class="tab-pane fade" id="pane-file-dinh-kem" role="tabpanel" aria-labelledby="file-dinh-kem-tab">
                                <?= FileDisplayWidget::widget([
                                    'type' => 'ALL',
                                    'doiTuong' => Xe::MODEL_ID,
                                    'idDoiTuong' => $model->id,
                                ]) ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<?php if (!Yii::$app->request->isAjax): ?>
    <?php Modal::begin([
        'options' => [
            'id' => 'ajaxCrudModal',
            'tabindex' => false
        ],
        'closeButton' => ['label' => '<span aria-hidden=\'true\'>×</span>'],
        'id' => 'ajaxCrudModal',
        'footer' => '',
        'size' => Modal::SIZE_EXTRA_LARGE
    ]) ?>
    <?php Modal::end(); ?>

    <?php Modal::begin([
        'options' => [
            'id' => 'ajaxCrudModal2',
            'tabindex' => false
        ],
        'closeButton' => ['label' => '<span aria-hidden=\'true\'>×</span>'],
        'id' => 'ajaxCrudModal2',
        'footer' => '',
        'size' => Modal::SIZE_LARGE
    ]) ?>
    <?php Modal::end(); ?>
<?php endif; ?>