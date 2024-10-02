<?php
use yii\helpers\Html;
use app\modules\kholuutru\models\File;
use app\custom\CustomFunc;
?>
<?php foreach ($files as $fileVB){ ?>
<div id="dFile<?= $fileVB->id ?>" class="col-md-4">
    <div class="card  custom-card mb-0">
        <div class="card-body p-2">
            <div class="d-flex">
                <span class="bg-primary-transparent border border-primary br-3 pd-5">
                    <?= Html::img($fileVB ? File::getIcon($fileVB->file_type) : '', ['width'=>35]) ?>
                </span>
                <div class="ms-auto mt-1 file-dropdown">
                    <a href="javascript:void(0);" class="text-muted" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-vertical fs-18"></i></a>
                    <div class="dropdown-menu dropdown-menu-start">
                    	<?php 
                    /* echo Html::a('<i class="fa fa-external-link me-2 float-start"></i> Mở',
                            ['/kholuutru/file/open', 'id'=>$fileVB->id],
                            [
                                'class'=>'dropdown-item d-flex align-items-center',
                                'role'=>'modal-remote-2'
                            ],
                        ); */
                    ?>    
                    <?php 
                    echo Html::a('<i class="fe fe-download me-2 float-start"></i> Tải về',
                            ['/kholuutru/file/download', 'id'=>$fileVB->id],
                            [
                                'target'=>'_blank',
                                'class'=>'dropdown-item d-flex align-items-center',
                                //'role'=>'modal-remote-2'
                            ],
                        );
                    ?>  
                     <?php 
                    /* echo Html::a('<i class="fe fe-share me-2 float-start"></i> Chia sẻ',
                            ['/kholuutru/file/download', 'id'=>$fileVB->id],
                            [
                                'class'=>'dropdown-item d-flex align-items-center',
                                'role'=>'modal-remote-2'
                            ],
                        ); */
                    ?>       
                   <?php 
                    echo Html::a('<i class="fe fe-info me-2 float-start"></i> Thông tin tệp',
                            ['/kholuutru/file/view', 'id'=>$fileVB->id],
                            [
                                'class'=>'dropdown-item d-flex align-items-center',
                                'role'=>'modal-remote-2'
                            ],
                        );
                    ?>                        
                    <?php 
                    echo Html::a('<i class="fe fe-edit me-2 float-start"></i>Sửa', 
                            ['/kholuutru/file/update', 'id'=>$fileVB->id],
                            [
                                'class'=>'dropdown-item d-flex align-items-center',
                                'role'=>'modal-remote-2'
                            ],
                        );
                    ?>                    
                    <?php 
                    echo Html::a('<i class="fe fe-trash me-2 float-start"></i>Xóa', 
                            ['/kholuutru/file/delete', 'id'=>$fileVB->id],
                            [
                                'class'=>'dropdown-item d-flex align-items-center',
                                'role'=>'modal-remote-2',
                                'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                                'data-request-method'=>'post',
                                'data-confirm-title'=>'Xác nhận xóa dữ liệu?',
                                'data-confirm-message'=>'Bạn có chắc chắn thực hiện hành động này?',
                            ],
                        );
                    ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer border-top-0 p-2 m-1">
            <div class="d-flex row">
                <div class="col-md-8">
                	<?= Html::a('<h5 class="fs-11 text-muted">'. CustomFunc::getStringByChars($fileVB->file_name,40) . '</h5>',
                            ['/kholuutru/file/download', 'id'=>$fileVB->id],
                            [
                                'target'=>'_blank',
                            ],
                        ) ?>  
                </div>
                <div class="col-md-4">
                    <h6 class="fs-11 text-muted"><?= $fileVB->file_size ?></h6>
                </div>
                
            </div>
        </div>
    </div>
</div>
<?php } ?>