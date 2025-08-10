<?php
use yii\helpers\Url;
use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;
use kartik\grid\GridView;
use cangak\ajaxcrud\CrudAsset; 
use cangak\ajaxcrud\BulkButtonWidget;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\thuexe\models\search\LichThueSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lịch thuê xe (có thiết bị)';
$this->params['breadcrumbs'][] = $this->title;
Yii::$app->params['showSearch'] = true;
Yii::$app->params['showView'] = true;
//CrudAsset::register($this);

?>

<style>
#crud-datatable-togdata-page{
    border:0px!important;
}
/*an add xử lý 2 select bị đè lên nhau khi open*/
/* .select2-container {
    z-index: 9999 !important;
}
.select2-dropdown {
    z-index: 9999 !important;
}*/
/*end -- an add xử lý 2 select bị đè lên nhau khi open*/
.trang-thai-khachle{
    color: blue !important;
}
</style>

<?php if(Yii::$app->params['showSearch']):?><div class="card border-default" id="divFilterExtend">
	<div class="card-header rounded-bottom-0 card-header text-dark" id="simple">
		<h5 class="mt-2"><i class="fe fe-search"></i> Tìm kiếm</h5>
	</div>
	<div class="card-body">
		<div class="expanel expanel-default">
			<div class="expanel-body">
				<?php 
                    echo $this->render("_search", ["model" => $searchModel]);
                ?>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>
<?php Pjax::begin([
    'id'=>'myGrid',
    'timeout' => 10000,
    'formSelector' => '.myFilterForm'
]); ?>

<div class="lich-thue-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'pjax'=>true,
            'columns' => require(__DIR__.'/_columns.php'),
            'toolbar'=> [
                ['content'=>
                    '
                    <div class="dropdown">
						<button aria-expanded="false" aria-haspopup="true" class="btn dropdown-toggle" data-bs-toggle="dropdown" type="button"><i class="fa fa-navicon"></i></button>
						<div class="dropdown-menu tx-13" style="">
							<h6 class="dropdown-header tx-uppercase tx-11 tx-bold bg-info tx-spacing-1">
								Chọn chức năng</h6>'
                    .
                    Html::a('<i class="fas fa fa-plus" aria-hiddi="true"></i> Thêm (Học viên trường)', ['create?type=hocvien'],
                        ['role'=>'modal-remote','title'=> 'Thêm mới (Học viên trường)','class'=>'dropdown-item'])
                    .
                    Html::a('<i class="fas fa fa-plus" aria-hiddi="true"></i> Thêm (Khách ngoài)', ['create?type=khachngoai'],
                        ['role'=>'modal-remote','title'=> 'Thêm mới (Khách ngoài)','class'=>'dropdown-item'])
                    .
                    Html::a('<i class="fas fa fa-plus" aria-hiddi="true"></i> Thêm (Liên kết)', ['create?type=lienket'],
                        ['role'=>'modal-remote','title'=> 'Thêm mới (Liên kết)','class'=>'dropdown-item'])
                    .
                    Html::a('<i class="fas fa fa-sync" aria-hidden="true"></i> Tải lại', [''],
                        ['data-pjax'=>1, 'class'=>'dropdown-item', 'title'=>'Tải lại'])
                    .
                    Html::a('<i class="fas fa fa-trash" aria-hidden="true"></i>&nbsp; Xóa danh sách',
                        ["bulkdelete"],
                        [
                            'class'=>'dropdown-item text-secondary',
                            'role'=>'modal-remote-bulk',
                            'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                            'data-request-method'=>'post',
                            'data-confirm-title'=>'Xác nhận xóa?',
                            'data-confirm-message'=>'Bạn có chắc muốn xóa?'
                        ])
                    .
                    '
						</div>
					</div>
                    '.
                    '{toggleData}'.
                    '{export}'
                ],
            ],             
            'striped' => false,
            'condensed' => true,
            'responsive' => false,
            'panelHeadingTemplate'=>'<div style="width:100%;"><div class="float-start mt-2 text-primary">{title}</div> <div class="float-end">{toolbar}</div></div>',
            'panelFooterTemplate'=>'<div style="width:100%;"><div class="float-start">{summary}</div><div class="float-end">{pager}</div></div>',
            'summary'=>'Tổng: {totalCount} dòng dữ liệu',
            'panel' => [
                'headingOptions'=>['class'=>'card-header rounded-bottom-0 card-header text-dark'],
                'heading' => '<i class="typcn typcn-folder-open"></i> LỊCH THUÊ XE (CÓ THIẾT BỊ)',
                'before'=>false,
            ],
            'export'=>[
                'fontAwesome' => true,
                'showConfirmAlert' => false,
                'target' => GridView::TARGET_BLANK, // xuất ra tab mới
                'filename' => 'ds_hoc_vien' . date('Y-m-d'), // tên file export mặc định
                'options' => [
                    'class' => 'btn'
                ]
            ],
            'exportConfig' => [
                GridView::EXCEL => [
                    'label' => 'Xuất Excel',
                    'filename' => 'ds_thue_xe_cam_bien_' . date('Y-m-d'),
                    'options' => ['title' => 'Danh sách thuê xe cảm biến'],
                    'config' => [
                        'worksheet' => 'Danh sách',
                        'cssFile' => '', // nếu cần
                    ],
                ],
                GridView::PDF => [
                    'label' => 'Xuất PDF',
                    'filename' => 'ds_thue_xe_cam_bien_' . date('Y-m-d'),
                    'options' => ['title' => 'Danh sách thuê xe cảm biến'],
                    'config' => [
                        'methods' => [
                            'SetHeader' => ['DANH SÁCH THUÊ XE|DANH SÁCH|Xuất ngày: ' . date("d/m/Y")],
                            'SetFooter' => ['|Trang {PAGENO}|'],
                        ],
                        'options' => [
                            'title' => 'Danh sách thuê xe cảm biến',
                            'subject' => 'Xuất file PDF',
                            'keywords' => 'export, pdf,',
                        ],
                    ],
                ],
            ], 
        ])?>
    </div>
</div>

<?php Pjax::end(); ?>

<?php Modal::begin([
   'options' => [
        'id'=>'ajaxCrudModal',
        'tabindex' => false // important for Select2 to work properly
   ],
   'dialogOptions'=>['class'=>'modal-xl modal-xxl'],
   'closeButton'=>['label'=>'<span aria-hidden=\'true\'>×</span>'],
   'id'=>'ajaxCrudModal',
    'footer'=>'',// always need it for jquery plugin
])?>

<?php Modal::end(); ?>

<?php Modal::begin([
   'options' => [
        'id'=>'ajaxCrudModal2',
        'tabindex' => false // important for Select2 to work properly
   ],
   'dialogOptions'=>['class'=>'modal-xs modal-dialog-centered'],
   'closeButton'=>['label'=>'<span aria-hidden=\'true\'>×</span>'],
   'id'=>'ajaxCrudModal2',
   'footer'=>'',// always need it for jquery plugin
]) ?>

<?php Modal::end(); ?>
