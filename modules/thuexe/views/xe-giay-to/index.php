<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\thuexe\models\search\XeGiayToSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use app\modules\thuexe\models\XeGiayTo;

$this->title = 'Quản lý giấy tờ xe';
$this->params['breadcrumbs'][] = $this->title;
\kartik\date\DatePickerAsset::register($this);
Yii::$app->params['showSearch'] = true;
Yii::$app->params['showExport'] = false;
Yii::$app->params['showView'] = true;

// Thống kê số lượng giấy tờ sắp hết hạn hoặc quá hạn
$thongKeHan = XeGiayTo::getThongKeHetHan();
$tongCanhBao = $thongKeHan['tong'];
$quaHan = $thongKeHan['qua_han'];
$sapHet = $thongKeHan['sap_het'];

$titleHeader = '<i class="typcn typcn-folder-open"></i> DANH SÁCH GIẤY TỜ XE';
if ($tongCanhBao > 0) {
    $detail = [];
    if ($quaHan > 0) {
        $detail[] = $quaHan . ' quá hạn';
    }
    if ($sapHet > 0) {
        $detail[] = $sapHet . ' sắp hết hạn';
    }
    /*$titleHeader .= ' <span class="badge bg-danger ms-2" style="font-size: 0.85rem;"><i class="fa fa-exclamation-triangle"></i> ' . $tongCanhBao . ' sắp hết hạn hoặc quá hạn (' . implode(', ', $detail) . ')</span>';*/
    $titleHeader .=  '<span class="badge bg-danger ms-2" style="font-size: 0.85rem;"><i class="fa fa-exclamation-triangle"></i> ' .  implode(', ', $detail) . '</span>';
} else {
    $titleHeader .= ' <span class="badge bg-success ms-2" style="font-size: 0.85rem;"><i class="fa fa-check-circle"></i> Tất cả giấy tờ hợp lệ</span>';
}
?>

<?php if (Yii::$app->params['showSearch']): ?>
    <div class="card border-default" id="divFilterExtend">
        <div class="card-header rounded-bottom-0 card-header text-dark" id="simple">
            <h5 class="mt-2 mb-0"><i class="fe fe-search"></i> Tìm kiếm nâng cao</h5>
        </div>
        <div class="card-body">
            <div class="expanel expanel-default">
                <div class="expanel-body">
                    <?= $this->render('_search', ['model' => $searchModel]) ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php Pjax::begin([
    'id' => 'myGrid',
    'timeout' => 10000,
    'formSelector' => '.myFilterForm'
]); ?>

<div class="xe-giay-to-index">
    <div id="ajaxCrudDatatable">
        <?= GridView::widget([
            'id' => 'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax' => true,
            'columns' => require(__DIR__ . '/_columns.php'),
            'toolbar' => [
                [
                    'content' =>
                    '
                    <div class="dropdown">
						<button aria-expanded="false" aria-haspopup="true" class="btn dropdown-toggle" data-bs-toggle="dropdown" type="button"><i class="fa fa-navicon"></i></button>
						<div class="dropdown-menu tx-13">
							<h6 class="dropdown-header tx-uppercase tx-11 tx-bold bg-info tx-spacing-1">
								Chọn chức năng</h6>'
                        .
                        Html::a(
                            '<i class="fas fa fa-plus" aria-hidden="true"></i> Thêm mới',
                            ['create'],
                            ['role' => 'modal-remote', 'title' => 'Thêm mới giấy tờ xe', 'class' => 'dropdown-item']
                        )
                        .
                        Html::a(
                            '<i class="fas fa fa-sync" aria-hidden="true"></i> Tải lại',
                            [''],
                            ['data-pjax' => 1, 'class' => 'dropdown-item', 'title' => 'Tải lại']
                        )
                        .
                        Html::a(
                            '<i class="fas fa fa-trash" aria-hidden="true"></i>&nbsp; Xóa danh sách',
                            ["bulkdelete"],
                            [
                                'class' => 'dropdown-item text-secondary',
                                'role' => 'modal-remote-bulk',
                                'data-confirm' => false,
                                'data-method' => false,
                                'data-request-method' => 'post',
                                'data-confirm-title' => 'Xác nhận xóa?',
                                'data-confirm-message' => 'Bạn có chắc muốn xóa các mục đã chọn?'
                            ]
                        )
                        .
                        '
						</div>
					</div>
                    ' .
                        '{export}'
                ],
            ],
            'striped' => false,
            'condensed' => true,
            'responsive' => false,
            'panelHeadingTemplate' => '<div style="width:100%;"><div class="float-start mt-2 text-primary">{title}</div> <div class="float-end">{toolbar}</div></div>',
            'panelFooterTemplate' => '<div style="width:100%;"><div class="float-start">{summary}</div><div class="float-end">{pager}</div></div>',
            'summary' => 'Tổng: {totalCount} dòng dữ liệu',
            'panel' => [
                'headingOptions' => ['class' => 'card-header rounded-bottom-0 card-header text-dark'],
                'heading' => $titleHeader,
                'before' => false,
            ],
            'export' => [
                'options' => [
                    'class' => 'btn'
                ]
            ]
        ]) ?>
    </div>
</div>

<?php Pjax::end(); ?>

<?php Modal::begin([
    'options' => [
        'id' => 'ajaxCrudModal',
        'tabindex' => false
    ],
    'closeButton' => ['label' => '<span aria-hidden=\'true\'>×</span>'],
    'id' => 'ajaxCrudModal',
    'footer' => '',
    'size' => Modal::SIZE_LARGE
]) ?>
<?php Modal::end(); ?>

<?php Modal::begin([
    'options' => [
        'id' => 'ajaxCrudModal2',
        'tabindex' => false // important for Select2 to work properly
    ],
    // 'dialogOptions'=>['class'=>'modal-lg'],
    'closeButton' => ['label' => '<span aria-hidden=\'true\'>×</span>'],
    'id' => 'ajaxCrudModal2',
    'footer' => '', // always need it for jquery plugin
    'size' => Modal::SIZE_LARGE
]) ?>

<?php Modal::end(); ?>