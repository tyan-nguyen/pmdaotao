<?php
use yii\helpers\Url;
use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;
use kartik\grid\GridView;
use cangak\ajaxcrud\CrudAsset; 
use cangak\ajaxcrud\BulkButtonWidget;
use app\widgets\FilterFormWidget;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\user\models\UserAjaxSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

Yii::$app->params['showSearch'] = true;
Yii::$app->params['showExport'] = true;

?>

<div class="card border-default" id="divFilterExtend">
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

<?php Pjax::begin([
    'id'=>'myGrid',
    'timeout' => 10000,
    'formSelector' => '.myFilterForm'
]); ?>

<div class="user-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'pjax'=>true,
            'columns' => require(__DIR__.'/_columns.php'),
            //'options'=>['class'=>'table-responsive border p-0 pt-3'],
            'tableOptions' => [
                //'id' => 'theDatatable',
                //'class'=>'table table-bordered mg-b-0'
            ],
            /* 'toolbar'=> [
                ['content'=>
                    Html::a('<i class="fas fa fa-plus" aria-hidden="true"></i> Thêm mới', ['create'],
                    ['role'=>'modal-remote','title'=> 'Thêm mới Users','class'=>'btn btn-outline-primary']).
                    Html::a('<i class="fas fa fa-sync" aria-hidden="true"></i> Tải lại', [''],
                    ['data-pjax'=>1, 'class'=>'btn btn-outline-primary', 'title'=>'Tải lại']).
                    //'{toggleData}'.
                    '{export}'
                ],
            ],    */
            'toolbar'=> [
                ['content'=>
                    '
                    <div class="dropdown">
						<button aria-expanded="false" aria-haspopup="true" class="btn dropdown-toggle" data-bs-toggle="dropdown" type="button"><i class="fa fa-bars"></i></button>
						<div class="dropdown-menu tx-13" style="">
							<h6 class="dropdown-header tx-uppercase tx-11 tx-bold bg-info tx-spacing-1">
								Chọn chức năng</h6>'
                    .
                    Html::a('<i class="fas fa fa-plus" aria-hiddi="true"></i> Thêm mới', ['create'],
                        ['role'=>'modal-remote','title'=> 'Thêm mới','class'=>'dropdown-item'])
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
                    '/* .
                    '{export}' */
                ],
            ],
            'striped' => false,
            'condensed' => true,
            'responsive' => true,
            'panelHeadingTemplate'=>'<div style="width:100%;"><div class="float-start mt-2 text-primary">{title}</div> <div class="float-end">{toolbar}</div></div>',
            'panelFooterTemplate'=>'<div style="width:100%;"><div class="float-start">{summary}</div><div class="float-end">{pager}</div></div>',
            'summary'=>'Tổng: {totalCount} dòng dữ liệu',
            'panel' => [
                'headingOptions'=>['class'=>'card-header rounded-bottom-0 card-header text-dark'],
                'heading' => '<i class="typcn typcn-folder-open"></i> DANH SÁCH TÀI KHOẢN',
                'before'=>false,
            ],
            'export'=>[
                'options' => [
                    'class' => 'btn'
                ]
            ]
            //'panelHeadingTemplate'=>'{title}',
            //'panelFooterTemplate'=>'{summary}',
            //'summary'=>'Hiển thị dữ liệu {count}/{totalCount}, Trang {page}/{pageCount}',
            /* 'panel' => [
                //'type' => 'primary', 
                'heading' => '<i class="fas fa fa-list" aria-hidden="true"></i> Danh sách',
                'headingOptions' => ['class'=>'card-header'],
                'before'=>'<em>* Danh sách Users</em>',
                'after'=>BulkButtonWidget::widget([
                    'buttons'=>Html::a('<i class="fas fa fa-trash" aria-hidden="true"></i>&nbsp; Xóa đã chọn',
                        ["bulkdelete"] ,
                        [
                            "class"=>"btn btn-sm btn-outline-danger",
                            'role'=>'modal-remote-bulk',
                            'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                            'data-request-method'=>'post',
                            'data-confirm-title'=>'Xác nhận xóa?',
                            'data-confirm-message'=>'Bạn có chắc muốn xóa?'
                        ]),
                ]).                        
                '<div class="clearfix"></div>',
            ], */
            /* 'panelTemplate'=>'<div class="panel {type} card custom-card">
                {panelHeading}
                {panelBefore}
                {items}
                {panelAfter}
                {panelFooter}
            </div>' */
        ])?>
    </div>
</div>

<?php Pjax::end(); ?>

<?php Modal::begin([
   "options" => [
        "id"=>"ajaxCrudModal",
        "tabindex" => false // important for Select2 to work properly
    ],
    "dialogOptions"=>["class"=>"modal-xl"],
    'closeButton'=>['label'=>'<span aria-hidden="true">×</span>'],
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>

<?php
    $searchContent = $this->render("_search", ["model" => $searchModel]);
    echo FilterFormWidget::widget(["content"=>$searchContent, "description"=>"Nhập thông tin tìm kiếm."]) 
?>

