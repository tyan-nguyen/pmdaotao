<?php
use yii\helpers\Url;
use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;
use kartik\grid\GridView;
use cangak\ajaxcrud\CrudAsset; 
use cangak\ajaxcrud\BulkButtonWidget;
use yii\widgets\Pjax;
use app\widgets\FilterFormWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\dungchung\models\HistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Hoạt động';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

//Yii::$app->params['showSearch'] = true;
//Yii::$app->params['showExport'] = true;

?>

<?php Pjax::begin([
    'id'=>'myGrid',
    'timeout' => 10000,
    'formSelector' => '#myFilterForm'
]); ?>

<div class="history-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'pjax'=>true,
            'columns' => require(__DIR__.'/_column_activitys.php'),
            'toolbar'=> [
                ['content'=>
                    Html::a('<i class="fas fa fa-sync" aria-hidden="true"></i> Tải lại', [''],
                    ['data-pjax'=>1, 'class'=>'btn btn-outline-primary', 'title'=>'Tải lại'])
                ]],
            'striped' => false,
            'condensed' => true,
            'responsive' => true,
            'panelHeadingTemplate'=>'{title}',
            'panelFooterTemplate'=>'<div class="row"><div class="col-md-8">{pager}</div><div class="col-md-4">{summary}</div></div>',
            'summary'=>'Hiển thị dữ liệu {count}/{totalCount}, Trang {page}/{pageCount}',          
            'panel' => [
                //'type' => 'primary', 
                'heading' => '<i class="fas fa fa-list" aria-hidden="true"></i> Danh sách',
                'before'=>'<em>* Lịch sử hoạt động</em>',
                                      
                        '<div class="clearfix"></div>',
            ]
        ])?>
    </div>
</div>

<?php Pjax::end(); ?>

<?php Modal::begin([
   'options' => [
        'id'=>'ajaxCrudModal',
        'tabindex' => false // important for Select2 to work properly
   ],
   'dialogOptions'=>['class'=>'modal-lg'],
   'closeButton'=>['label'=>'<span aria-hidden=\'true\'>×</span>'],
   'id'=>'ajaxCrudModal',
    'footer'=>'',// always need it for jquery plugin
])?>

<?php Modal::end(); ?>