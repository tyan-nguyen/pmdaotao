<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\thuexe\models\search\LoaiGiayToSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Loại giấy tờ xe';
$this->params['breadcrumbs'][] = $this->title;
Yii::$app->params['showSearch'] = false;
Yii::$app->params['showExport'] = false;
Yii::$app->params['showView'] = false;
?>

<?php Pjax::begin([
    'id' => 'myGrid',
    'timeout' => 10000,
    'formSelector' => '.myFilterForm'
]); ?>

<div class="loai-giay-to-index">
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
                            ['role' => 'modal-remote', 'title' => 'Thêm mới loại giấy tờ', 'class' => 'dropdown-item']
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
                'heading' => '<i class="typcn typcn-folder-open"></i> DANH SÁCH LOẠI GIẤY TỜ XE',
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