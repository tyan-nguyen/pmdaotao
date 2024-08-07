<?php
use app\assets\ViboonAsset;
use yii\helpers\Html;

ViboonAsset::register($this);
?>
<?php $this->beginPage() ?>
<!doctype html>
<html lang="en" dir="ltr">

	<head>
		<link rel="shortcut icon" type="image/x-icon" href="<?= Yii::getAlias('@web')  ?>/assets/images/brand/favicon.ico" >
		<!-- Title -->
		<title><?= Html::encode($this->title) ?></title>
		<?php $this->head() ?>
	</head>

	<body class="app sidebar-mini login-img">
	<?php $this->beginBody() ?>
	
	 <!-- Loader -->
        <div id="global-loader">
            <img src="<?= Yii::getAlias('@web')  ?>/assets/images/svgs/loader.svg" alt="loader">
        </div>
        <!-- /Loader -->

        <!-- Page -->
        <div class="page main-signin-wrapper">

            <!-- Row -->
            <div class="row text-center ps-0 pe-0 ms-0 me-0">
                <div class=" col-xl-3 col-lg-5 col-md-5 d-block mx-auto">
                    <div class="text-center mb-2">
                        <a href="index.html">
                            <img src="<?= Yii::getAlias('@web')  ?>/assets/images/brand/logo.png" class="header-brand-img" alt="logo">
                            <img src="<?= Yii::getAlias('@web')  ?>/assets/images/brand/logo1.png" class="header-brand-img theme-logos" alt="logo">
                        </a>
                    </div>
                    <div class="card custom-card">
                        <div class="card-body pd-25">
                            <?= $content ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Row -->

        </div>
        <!-- End Page -->
		
        <!-- Back to top -->
        <a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>
		<?php $this->endBody() ?>
	</body>
</html>
<?php $this->endPage() ?>