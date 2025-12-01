<?php
use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;
use kartik\grid\GridView;
//use cangak\ajaxcrud\CrudAsset;
use cangak\ajaxcrud\BulkButtonWidget;
use yii\widgets\Pjax;
use app\widgets\FilterFormWidget;
use app\modules\hocvien\models\HangDaoTao;
use app\modules\hocvien\models\HocVien;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\vanban\models\search\VBDenSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Hồ sơ học viên';
$this->params['breadcrumbs'][] = $this->title;
//CrudAsset::register($this);
Yii::$app->params['showSearch'] = true;
Yii::$app->params['showExport'] = true;
?>

<style>
#crud-datatable-togdata-page{
    border:0px!important;
}
.ho-so-da-huy td{
    color:blue !important;
    text-decoration: line-through;
}
</style>

<div class="card border-default" id="divFilterExtend">
	<div class="card-header rounded-bottom-0 card-header text-dark" id="simple">
		<h5 class="mt-2"><i class="fe fe-search"></i> Tìm kiếm</h5>
	</div>
	<div class="card-body">
		<div class="expanel expanel-default">
			<div class="expanel-body">
				<?php 
                    echo $this->render("simple_search", ["model" => $searchModel]);
                ?>
			</div>
		</div>
	</div>
</div>

<?php Pjax::begin([
    'id'=>'myGrid',
    'timeout' => 10000,
    'formSelector' => '.myFilterForm'
]); ?>

<div class="van-ban-den-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'pjax'=>true,
            //'showPageSummary' => true,
            'columns' => require(__DIR__.'/simple_columns.php'),
            'rowOptions' => function ($model, $key, $index, $grid) {
                if($model->huy_ho_so){
                    return ['class' => 'ho-so-da-huy'];
                }
            },
            'toolbar'=> [
                ['content'=>
                    '
                    <div class="dropdown">
						<button aria-expanded="false" aria-haspopup="true" class="btn dropdown-toggle" data-bs-toggle="dropdown" type="button"><i class="fa fa-navicon"></i></button>
						<div class="dropdown-menu tx-13" style="">
							<h6 class="dropdown-header tx-uppercase tx-11 tx-bold bg-info tx-spacing-1">
								Chọn chức năng</h6>'
                    
                   /*  .Html::a('<i class="fas fa fa-plus" aria-hiddi="true"></i> Thêm mới', ['create'],
                        ['role'=>'modal-remote','title'=> 'Thêm mới','class'=>'dropdown-item']) */
                    .
                    Html::a('<i class="fas fa fa-sync" aria-hidden="true"></i> Tải lại', [''],
                        ['data-pjax'=>1, 'class'=>'dropdown-item', 'title'=>'Tải lại'])
                    /*.
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
                    .'<li><hr class="dropdown-divider"></li>'
                    . Html::a('<i class="fas fa-clipboard-list"></i> In DS theo ca', ['report-list'],
                        ['role'=>'modal-remote','title'=> 'In DS theo ca','class'=>'dropdown-item'])
                    .'<li><hr class="dropdown-divider"></li>'
                    . Html::a('<i class="fas fa-clipboard-list"></i> Báo cáo DS HV', ['/hocvien/bao-cao/rp-danh-sach-dang-ky'],
                        ['role'=>'modal-remote','title'=> 'Báo cáo danh sách học viên','class'=>'dropdown-item'])
                    */
                    
                   /*  . Html::a('<i class="fas fa-clipboard-list"></i> In Báo cáo theo ca', ['report-sum'],
                        ['role'=>'modal-remote','title'=> 'In Báo cáo tổng','class'=>'dropdown-item']) */
                    .'
						</div>
					</div>
                    '.
                    '{toggleData}'
                    .'{export}'
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
                'heading' => '<i class="typcn typcn-folder-open"></i> DANH SÁCH HỌC VIÊN',
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
                    'filename' => 'ds_hoc_vien_' . date('Y-m-d'),
                    'options' => ['title' => 'Danh sách học viên'],
                    'config' => [
                        'worksheet' => 'Học viên',
                        'cssFile' => '', // nếu cần
                    ],
                ],
                GridView::PDF => [
                    'label' => 'Xuất PDF',
                    'filename' => 'ds_hoc_vien_' . date('Y-m-d'),
                    'options' => ['title' => 'Danh sách học viên'],
                    'config' => [
                        'methods' => [
                            'SetHeader' => ['DANH SÁCH HỌC VIÊN|DANH SÁCH|Xuất ngày: ' . date("d/m/Y")],
                            'SetFooter' => ['|Trang {PAGENO}|'],
                        ],
                        'options' => [
                            'title' => 'Danh sách học viên',
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
   //'dialogOptions'=>['class'=>'modal-lg'],
   'closeButton'=>['label'=>'<span aria-hidden=\'true\'>×</span>'],
   'id'=>'ajaxCrudModal',
    'footer'=>'',// always need it for jquery plugin
    'size'=>Modal::SIZE_EXTRA_LARGE
])?>

<?php Modal::end(); ?>

<?php Modal::begin([
   'options' => [
        'id'=>'ajaxCrudModal2',
        'tabindex' => false // important for Select2 to work properly
   ],
  // 'dialogOptions'=>['class'=>'modal-lg'],
   'closeButton'=>['label'=>'<span aria-hidden=\'true\'>×</span>'],
   'id'=>'ajaxCrudModal2',
    'footer'=>'',// always need it for jquery plugin
    'size'=>Modal::SIZE_LARGE
])?>

<?php Modal::end(); ?>

<?php
    /* $searchContent = $this->render("_search", ["model" => $searchModel]);
    echo FilterFormWidget::widget(["content"=>$searchContent, "description"=>"Nhập thông tin tìm kiếm."])  */
?>