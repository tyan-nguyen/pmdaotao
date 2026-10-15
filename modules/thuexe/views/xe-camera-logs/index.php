<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchTripModel app\modules\thuexe\models\search\XeLuotRaVaoSearch */
/* @var $dataTripProvider yii\data\ActiveDataProvider */
/* @var $searchLogModel app\modules\thuexe\models\search\XeCameraLogsSearch */
/* @var $dataLogProvider yii\data\ActiveDataProvider */
/* @var $activeTab string */

$this->title = 'Quản lý Lượt Xe & Nhật ký Camera';
$this->params['breadcrumbs'][] = ['label' => 'Thuê xe', 'url' => ['/thuexe']];
$this->params['breadcrumbs'][] = $this->title;

Yii::$app->params['showSearch'] = false;
Yii::$app->params['showExport'] = false;
Yii::$app->params['showView'] = false;

$isTabLogs = ($activeTab === 'logs');
?>

<div class="xe-camera-logs-index">
    <!-- Header Thống Kê & Công Cụ Đồng Bộ -->
    <div class="card custom-card mb-3">
        <div class="card-body py-3">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                <div>
                    <h5 class="card-title mb-1 text-primary">
                        <i class="fe fe-video me-1"></i> <?= Html::encode($this->title) ?>
                    </h5>
                    <p class="text-muted small mb-0">Hệ thống tự động ghép cặp xe Đi (Mặt trước) - Về (Mặt sau) và tính toán thời gian ở ngoài.</p>
                </div>
                <div class="d-flex gap-2">
                    <?= Html::a(
                        '<i class="fa fa-print me-1"></i> BC Cổng Căn Tin',
                        '#modalExportExcel',
                        [
                            'class' => 'btn btn-primary btn-sm',
                            'data-bs-toggle' => 'modal',
                            'data-cong' => 'cong_can_tin',
                            'title' => 'In trực tiếp & Xuất file Excel báo cáo lượt xe Cổng Căn Tin',
                        ]
                    ) ?>
                    <?= Html::a(
                        '<i class="fa fa-print me-1"></i> BC Sân Cảm Biến',
                        '#modalExportExcel',
                        [
                            'class' => 'btn btn-success btn-sm',
                            'data-bs-toggle' => 'modal',
                            'data-cong' => 'cong_san_cam_bien',
                            'title' => 'In trực tiếp & Xuất file Excel báo cáo lượt xe Cổng Sân Cảm Biến',
                        ]
                    ) ?>
                    <?= Html::a(
                        '<i class="fa fa-refresh me-1"></i> Làm lại dữ liệu (Tính lại lượt đi - về)',
                        ['rebuild-trips'],
                        [
                            'role' => 'modal-remote',
                            'class' => 'btn btn-outline-warning text-dark btn-sm',
                            'title' => 'Quét và tính toán lại các lượt xe từ toàn bộ dữ liệu nhật ký camera',
                            'data-bs-toggle' => 'tooltip',
                        ]
                    ) ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs Lựa Chọn Chế Độ Xem -->
    <div class="card custom-card">
        <div class="card-header custom-card-header border-bottom-0 pb-0">
            <ul class="nav nav-tabs card-header-tabs" id="cameraLogsTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link <?= !$isTabLogs ? 'active' : '' ?>" id="trips-tab" data-bs-toggle="tab" href="#pane-trips" role="tab" aria-selected="<?= !$isTabLogs ? 'true' : 'false' ?>">
                        <i class="fa fa-exchange me-1 text-primary"></i> <strong>LƯỢT XE ĐI - VỀ (BLOCK TÍNH GIỜ)</strong>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link <?= $isTabLogs ? 'active' : '' ?>" id="logs-tab" data-bs-toggle="tab" href="#pane-logs" role="tab" aria-selected="<?= $isTabLogs ? 'true' : 'false' ?>">
                        <i class="fa fa-list me-1 text-info"></i> <strong>NHẬT KÝ CHI TIẾT TỪNG MẮT ĐỌC (RAW LOGS)</strong>
                    </a>
                </li>
            </ul>
        </div>

        <div class="card-body p-3">
            <div class="tab-content" id="cameraLogsTabsContent">
                <!-- TAB 1: LƯỢT XE ĐI - VỀ -->
                <div class="tab-pane fade <?= !$isTabLogs ? 'active show' : '' ?>" id="pane-trips" role="tabpanel" aria-labelledby="trips-tab">
                    <!-- KHUNG SEARCH OUTSIDE CHO LƯỢT XE -->
                    <?= $this->render('_search_trips', ['model' => $searchTripModel]) ?>

                    <?php Pjax::begin([
                        'id' => 'myGridTrips',
                        'timeout' => 10000,
                        'enablePushState' => false,
                        'formSelector' => '.myFilterFormTrips',
                    ]); ?>

                    <div id="ajaxCrudDatatableTrips">
                        <?= GridView::widget([
                            'id' => 'crud-datatable-trips',
                            'dataProvider' => $dataTripProvider,
                            'pjax' => true,
                            'columns' => require(__DIR__ . '/_columns_trips.php'),
                            'toolbar' => [
                                [
                                    'content' =>
                                    Html::a(
                                        '<i class="fa fa-refresh"></i> Tải lại',
                                        ['index', 'tab' => 'trips'],
                                        ['data-pjax' => 1, 'class' => 'btn btn-outline-secondary btn-sm', 'title' => 'Tải lại danh sách']
                                    ) . '{export}'
                                ],
                            ],
                            'striped' => false,
                            'condensed' => true,
                            'responsive' => true,
                            'panelHeadingTemplate' => '<div style="width:100%;"><div class="float-start mt-2 text-primary">{title}</div> <div class="float-end">{toolbar}</div></div>',
                            'panelFooterTemplate' => '<div style="width:100%;"><div class="float-start">{summary}</div><div class="float-end">{pager}</div></div>',
                            'summary' => 'Tổng cộng: <strong>{totalCount}</strong> lượt xe',
                            'panel' => [
                                'headingOptions' => ['class' => 'card-header rounded-bottom-0 card-header text-dark'],
                                'heading' => '<i class="fa fa-road text-primary"></i> DANH SÁCH LƯỢT XE RA - VÀO',
                                'before' => false,
                            ],
                            'export' => [
                                'options' => [
                                    'class' => 'btn btn-sm btn-outline-primary'
                                ]
                            ]
                        ]) ?>
                    </div>

                    <?php Pjax::end(); ?>
                </div>

                <!-- TAB 2: NHẬT KÝ CHI TIẾT TỪNG MẮT ĐỌC -->
                <div class="tab-pane fade <?= $isTabLogs ? 'active show' : '' ?>" id="pane-logs" role="tabpanel" aria-labelledby="logs-tab">
                    <!-- KHUNG SEARCH OUTSIDE CHO NHẬT KÝ CAMERA -->
                    <?= $this->render('_search_logs', ['model' => $searchLogModel]) ?>

                    <?php Pjax::begin([
                        'id' => 'myGridLogs',
                        'timeout' => 10000,
                        'enablePushState' => false,
                        'formSelector' => '.myFilterFormLogs',
                    ]); ?>

                    <div id="ajaxCrudDatatableLogs">
                        <?= GridView::widget([
                            'id' => 'crud-datatable-logs',
                            'dataProvider' => $dataLogProvider,
                            'pjax' => true,
                            'columns' => require(__DIR__ . '/_columns_logs.php'),
                            'toolbar' => [
                                [
                                    'content' =>
                                    Html::a(
                                        '<i class="fa fa-refresh"></i> Tải lại',
                                        ['index', 'tab' => 'logs'],
                                        ['data-pjax' => 1, 'class' => 'btn btn-outline-secondary btn-sm', 'title' => 'Tải lại nhật ký']
                                    ) . '{export}'
                                ],
                            ],
                            'striped' => false,
                            'condensed' => true,
                            'responsive' => true,
                            'panelHeadingTemplate' => '<div style="width:100%;"><div class="float-start mt-2 text-info">{title}</div> <div class="float-end">{toolbar}</div></div>',
                            'panelFooterTemplate' => '<div style="width:100%;"><div class="float-start">{summary}</div><div class="float-end">{pager}</div></div>',
                            'summary' => 'Tổng cộng: <strong>{totalCount}</strong> bản ghi nhật ký',
                            'panel' => [
                                'headingOptions' => ['class' => 'card-header rounded-bottom-0 card-header text-dark'],
                                'heading' => '<i class="fe fe-list text-info"></i> NHẬT KÝ CHI TIẾT CAMERA ANPR',
                                'before' => false,
                            ],
                            'export' => [
                                'options' => [
                                    'class' => 'btn btn-sm btn-outline-info'
                                ]
                            ]
                        ]) ?>
                    </div>

                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Xuất Báo Cáo Excel -->
<?= $this->render('_modal_export') ?>

<?php Modal::begin([
    'options' => [
        'id' => 'ajaxCrudModal',
        'tabindex' => false
    ],
    'closeButton' => ['label' => '<span aria-hidden=\'true\'>×</span>'],
    'footer' => '',
    'size' => Modal::SIZE_EXTRA_LARGE
]) ?>
<?php Modal::end(); ?>
