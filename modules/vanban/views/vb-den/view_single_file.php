<?php
use yii\helpers\Html;
?>
<div class="card  custom-card">
    <div class="card-body p-3">
        <div class="d-flex">
            <span class="bg-primary-transparent border border-primary br-3 pd-5">
                <?= Html::img($fileVB->icon, ['width'=>50]) ?>
            </span>
            <div class="ms-auto mt-1 file-dropdown">
                <a href="javascript:void(0);" class="text-muted" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-vertical fs-18"></i></a>
                <div class="dropdown-menu dropdown-menu-start">
                    <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);"><i class="fe fe-edit me-2 float-start"></i>
                        Edit</a>
                    <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);"><i class="fe fe-share me-2 float-start"></i>
                        Share</a>
                    <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);"><i class="fe fe-download me-2 float-start"></i>
                        Download</a>
                    <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);"><i class="fe fe-trash me-2 float-start"></i>
                        Delete</a>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer border-top-0">
        <div class="d-flex">
            <div>
                <h5 class="text-primary">Videos</h5>
                <p class="text-muted fs-13 mb-0">25 Files</p>
            </div>
            <div class="ms-auto">
                <h6 class="fs-11 text-muted">1 GB</h6>
            </div>
        </div>
    </div>
</div>