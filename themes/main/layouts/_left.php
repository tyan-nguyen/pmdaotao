<?php
use app\modules\user\models\User;
?>
<!-- Sidemenu -->
<div class="sticky">
	<div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
	<aside class="app-sidebar ps horizontal-main">
		<div class="app-sidebar__header">
			<a class="main-logo" href="<?= Yii::getAlias('@web/') ?>">
				<img src="<?= Yii::getAlias('@web') ?>/assets/images/brand/logo.png" class="desktop-logo desktop-logo-dark"
					alt="viboonlogo">
				<img src="<?= Yii::getAlias('@web') ?>/assets/images/brand/logo1.png" class="desktop-logo" alt="viboonlogo">
				<img src="<?= Yii::getAlias('@web') ?>/assets/images/brand/favicon.png" class="mobile-logo mobile-logo-dark"
					alt="viboonlogo">
				<img src="<?= Yii::getAlias('@web') ?>/assets/images/brand/favicon-1.png" class="mobile-logo" alt="viboonlogo">
			</a>
		</div>
		
		
		
		
		<div class="main-sidemenu">
			<!-- <div class="slide-left disabled" id="slide-left">
				<svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24"
					viewBox="0 0 24 24">
					<path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
				</svg>
			</div> -->
			
			
			

			<ul class="side-menu">
				<li class="side-item side-item-category" style="background-color:var(--primary-bg-color);padding:10px 20px;color:white;margin-top:-15px"><img alt="avatar" src="<?= Yii::getAlias('@web') ?>/uploads/icons/user.png" width="25">&nbsp;Xin chào, <?= User::getCurrentUser()->username ?></li>
				<!-- <li class="side-item side-item-category">Dashboard</li> 
				<li>
					<a class="side-menu__item" data-bs-toggle="slide" href="<?= Yii::getAlias('@web/') ?>">
						<span class="side-menu__icon"><i class="bi bi-house-door side_menu_img"></i></span>
						<span class="side-menu__label">Dashboard</span>
					</a>
				</li>
				-->
				
				<li class="side-item side-item-category">Module</li>
				<?= $this->render('menus/van-ban') ?>
				
				<?= $this->render('menus/hoc-vien') ?>

				<?= $this->render('menus/nhan-vien')?>
				
				<?= $this->render('menus/giao-vien') ?>
				
				<?= $this->render('menus/kho-luu-tru') ?>
				
				<?= $this->render('menus/khoa-hoc') ?>
				
				<?= $this->render('menus/thue-xe') ?>

				<?= $this->render('menus/tai-khoan') ?>				
				
				<li class="side-item side-item-category">Tùy chỉnh</li>
				<li>
					<a class="side-menu__item help-support" href="<?= Yii::getAlias('@web/user/giao-dien?menu=gdtb') ?>" data-menu="gdtb">
						<span class="side-menu__icon">
							<i class="bi bi-gear side_menu_img"></i>
						</span>
						<span class="side-menu__label">Giao diện thiết bị</span></a>
				</li>
				<li>
					<a class="side-menu__item help-support" href="<?= Yii::getAlias('@web/user/auth/logout?menu=gdtb3') ?>" data-menu="gdtb3">
						<span class="side-menu__icon">
							<i class="fe fe-power side_menu_img"></i>
						</span>
						<span class="side-menu__label">Đăng xuất</span></a>
				</li>
				<!-- <li class="side-item side-item-category">Trợ giúp</li>
				<li>
					<a class="side-menu__item help-support" href="#">
						<span class="side-menu__icon">
							<i class="bi bi-question-octagon side_menu_img"></i>
						</span>
						<span class="side-menu__label">Trợ giúp #</span></a>
				</li> -->
			</ul>
			<div class="slide-right" id="slide-right">
				<svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24"
					viewBox="0 0 24 24">
					<path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z">
					</path>
				</svg>
			</div>
		</div>
	</aside>
</div>
<!-- End Sidemenu -->