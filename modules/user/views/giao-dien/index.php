<?php 
$this->title = 'Tùy chỉnh giao diện';
?>

<?php 
$this->registerJsFile("@web/assets/js/custom-switcher.js",[
    'depends' => [
        \yii\web\JqueryAsset::className()
    ]
]);
$this->registerJsFile("@web/assets/switcher/js/switcher.js",[
    'depends' => [
        \yii\web\JqueryAsset::className()
    ]
]);
?>

<!-- <script src="<?= Yii::getAlias('@web') ?>/assets/js/custom-switcher.js"></script>
<script src="<?= Yii::getAlias('@web') ?>/assets/switcher/js/switcher.js"></script>
 -->
 
<!--Row-->
<div class="container">
	<div class="row row-sm">
		<div class="col-xl-8 m-auto">
			<div class="switcher-wrapper">
				<div class="">
					<div class="card form_holder sidebar-right1">
						<div class="card-body row text-center">
						<h1>TÙY CHỈNH GIAO DIỆN CHO THIẾT BỊ</h1>
							<div class="predefined_styles">
								<!-- <div class="swichermainleft text-center">
									<h6>LTR AND RTL VERSIONS</h6>
									<div class="skin-body">
										<div class="switch_section">
											<div class="switch-toggle d-flex mt-2">
												<span class="me-auto">LTR</span>
												<p class="onoffswitch2 my-0"><input type="radio"
														name="onoffswitch25" id="switchbtn-ltr"
														class="onoffswitch2-checkbox" checked>
													<label for="switchbtn-ltr"
														class="onoffswitch2-label"></label>
												</p>
											</div>
											<div class="switch-toggle d-flex mt-2">
												<span class="me-auto">RTL</span>
												<p class="onoffswitch2 my-0"><input type="radio"
														name="onoffswitch25" id="switchbtn-rtl"
														class="onoffswitch2-checkbox">
													<label for="switchbtn-rtl"
														class="onoffswitch2-label"></label>
												</p>
											</div>
										</div>
									</div>
								</div> -->
								<div class="swichermainleft switcher-nav">
									<h6>Menu điều hướng</h6>
									<div class="skin-body">
										<div class="switch_section">
											<div class="switch-toggle d-flex">
												<span class="me-auto">Menu dọc</span>
												<p class="onoffswitch2 my-0"><input type="radio"
														name="onoffswitch15" id="switchbtn-vertical"
														class="onoffswitch2-checkbox" checked>
													<label for="switchbtn-vertical"
														class="onoffswitch2-label"></label>
												</p>
											</div>
											<div class="switch-toggle d-flex mt-2">
												<span class="me-auto">Menu ngang - Click chuột để mở</span>
												<p class="onoffswitch2 my-0"><input type="radio"
														name="onoffswitch15"
														id="switchbtn-horizontal"
														class="onoffswitch2-checkbox">
													<label for="switchbtn-horizontal"
														class="onoffswitch2-label"></label>
												</p>
											</div>
											<div class="switch-toggle d-flex mt-2">
												<span class="me-auto">Menu ngang - Rê chuột để mở</span>
												<p class="onoffswitch2 my-0"><input type="radio"
														name="onoffswitch15"
														id="switchbtn-horizontalHover"
														class="onoffswitch2-checkbox">
													<label for="switchbtn-horizontalHover"
														class="onoffswitch2-label"></label>
												</p>
											</div>
										</div>
									</div>
								</div>
								<div class="swichermainleft">
									<h6>Phong cách trang</h6>
									<div class="skin-body">
										<div class="switch_section">
											<div class="switch-toggle d-flex">
												<span class="me-auto">Light Theme</span>
												<p class="onoffswitch2 my-0"><input type="radio"
														name="onoffswitch1" id="switchbtn-light"
														class="onoffswitch2-checkbox" checked>
													<label for="switchbtn-light"
														class="onoffswitch2-label"></label>
												</p>
											</div>
											<div class="switch-toggle d-flex mt-2">
												<span class="me-auto">Dark Theme</span>
												<p class="onoffswitch2 my-0"><input type="radio"
														name="onoffswitch1" id="switchbtn-dark"
														class="onoffswitch2-checkbox">
													<label for="switchbtn-dark"
														class="onoffswitch2-label"></label>
												</p>
											</div>
										</div>
									</div>
								</div>
								<div class="swichermainleft">
									<h6>Màu sắc</h6>
									<div class="skin-body">
										<div class="switch_section">
											<div class="switch-toggle d-flex">
												<span class="me-auto">Màu chính</span>
												<div class="">
													<input
														class="wd-30 h-30 input-color-picker color-primary-light"
														value="#150570" id="colorID"
														oninput="changePrimaryColor()" type="color"
														data-id="bg-color" data-id1="bg-hover"
														data-id2="bg-border"
														data-id3="transparentcolor"
														name="lightPrimary">
												</div>
											</div>
											<div class="switch-toggle d-flex mt-2">
												<span class="me-auto">Màu nền</span>
												<div class="">
													<input
														class="wd-30 h-30 input-transparent-color-picker color-bg-transparent"
														value="#272145" id="transparentBgColorID"
														oninput="transparentBgColor()" type="color"
														data-id5="background" data-id6="white"
														data-id7="menu-bg" data-id8="header-bg"
														name="transparentBackground">
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="swichermainleft leftmenu-styles">
									<h6>Phong cách menu trái</h6>
									<div class="skin-body">
										<div class="switch_section">
											<div class="switch-toggle d-flex">
												<span class="me-auto">Light Menu</span>
												<p class="onoffswitch2 my-0"><input type="radio"
														name="onoffswitch2" id="switchbtn-lightmenu"
														class="onoffswitch2-checkbox" checked>
													<label for="switchbtn-lightmenu"
														class="onoffswitch2-label"></label>
												</p>
											</div>
											<div class="switch-toggle d-flex mt-2">
												<span class="me-auto">Color Menu</span>
												<p class="onoffswitch2 my-0"><input type="radio"
														name="onoffswitch2" id="switchbtn-colormenu"
														class="onoffswitch2-checkbox">
													<label for="switchbtn-colormenu"
														class="onoffswitch2-label"></label>
												</p>
											</div>
											<div class="switch-toggle d-flex mt-2">
												<span class="me-auto">Dark Menu</span>
												<p class="onoffswitch2 my-0"><input type="radio"
														name="onoffswitch2" id="switchbtn-darkmenu"
														class="onoffswitch2-checkbox">
													<label for="switchbtn-darkmenu"
														class="onoffswitch2-label"></label>
												</p>
											</div>
											<div class="switch-toggle d-flex mt-2">
												<span class="me-auto">Gradient Menu</span>
												<p class="onoffswitch2 my-0"><input type="radio"
														name="onoffswitch2"
														id="switchbtn-gradientmenu"
														class="onoffswitch2-checkbox">
													<label for="switchbtn-gradientmenu"
														class="onoffswitch2-label"></label>
												</p>
											</div>
										</div>
									</div>
								</div>
								<div class="swichermainleft header-styles">
									<h6>Phong cách menu top</h6>
									<div class="skin-body">
										<div class="switch_section">
											<div class="switch-toggle d-flex">
												<span class="me-auto">Light Header</span>
												<p class="onoffswitch2 my-0"><input type="radio"
														name="onoffswitch3"
														id="switchbtn-lightheader"
														class="onoffswitch2-checkbox" checked>
													<label for="switchbtn-lightheader"
														class="onoffswitch2-label"></label>
												</p>
											</div>
											<div class="switch-toggle d-flex mt-2">
												<span class="me-auto">Color Header</span>
												<p class="onoffswitch2 my-0"><input type="radio"
														name="onoffswitch3"
														id="switchbtn-colorheader"
														class="onoffswitch2-checkbox">
													<label for="switchbtn-colorheader"
														class="onoffswitch2-label"></label>
												</p>
											</div>
											<div class="switch-toggle d-flex mt-2">
												<span class="me-auto">Dark Header</span>
												<p class="onoffswitch2 my-0"><input type="radio"
														name="onoffswitch3"
														id="switchbtn-darkheader"
														class="onoffswitch2-checkbox">
													<label for="switchbtn-darkheader"
														class="onoffswitch2-label"></label>
												</p>
											</div>
											<div class="switch-toggle d-flex mt-2">
												<span class="me-auto">Gradient Header</span>
												<p class="onoffswitch2 my-0"><input type="radio"
														name="onoffswitch3"
														id="switchbtn-gradientheader"
														class="onoffswitch2-checkbox">
													<label for="switchbtn-gradientheader"
														class="onoffswitch2-label"></label>
												</p>
											</div>
										</div>
									</div>
								</div>
								<div class="swichermainleft">
									<h6>Chế độ Shadow</h6>
									<div class="switch_section">
										<div class="switch-toggle d-flex">
											<span class="me-auto">Shadow</span>
											<div class="onoffswitch2"><input type="radio"
													name="onoffswitchBody" id="switchbtn-shadow"
													class="onoffswitch2-checkbox" checked="">
												<label for="switchbtn-shadow"
													class="onoffswitch2-label"></label>
											</div>
										</div>
										<div class="switch-toggle d-flex">
											<span class="me-auto">No-shadow</span>
											<div class="onoffswitch2"><input type="radio"
													name="onoffswitchBody" id="switchbtn-noshadow"
													class="onoffswitch2-checkbox">
												<label for="switchbtn-noshadow"
													class="onoffswitch2-label"></label>
											</div>
										</div>
									</div>
								</div>
								<div class="swichermainleft">
									<h6>Định dạng layout</h6>
									<div class="skin-body">
										<div class="switch_section">
											<div class="switch-toggle d-flex">
												<span class="me-auto">Full Width</span>
												<p class="onoffswitch2 my-0"><input type="radio"
														name="onoffswitch4" id="switchbtn-fullwidth"
														class="onoffswitch2-checkbox" checked>
													<label for="switchbtn-fullwidth"
														class="onoffswitch2-label"></label>
												</p>
											</div>
											<div class="switch-toggle d-flex mt-2">
												<span class="me-auto">Boxed</span>
												<p class="onoffswitch2 my-0"><input type="radio"
														name="onoffswitch4" id="switchbtn-boxed"
														class="onoffswitch2-checkbox">
													<label for="switchbtn-boxed"
														class="onoffswitch2-label"></label>
												</p>
											</div>
										</div>
									</div>
								</div>
								<div class="swichermainleft switcher-layout">
									<h6>Layout Positions</h6>
									<div class="skin-body">
										<div class="switch_section">
											<div class="switch-toggle d-flex">
												<span class="me-auto">Fixed</span>
												<p class="onoffswitch2 my-0"><input type="radio"
														name="onoffswitch5" id="switchbtn-fixed"
														class="onoffswitch2-checkbox" checked>
													<label for="switchbtn-fixed"
														class="onoffswitch2-label"></label>
												</p>
											</div>
											<div class="switch-toggle d-flex mt-2">
												<span class="me-auto">Scrollable</span>
												<p class="onoffswitch2 my-0"><input type="radio"
														name="onoffswitch5"
														id="switchbtn-scrollable"
														class="onoffswitch2-checkbox">
													<label for="switchbtn-scrollable"
														class="onoffswitch2-label"></label>
												</p>
											</div>
										</div>
									</div>
								</div>
								<div class="swichermainleft vertical-switcher">
									<h6>Định dạng menu trái</h6>
									<div class="skin-body">
										<div class="switch_section">
											<div class="switch-toggle d-flex">
												<span class="me-auto">Default Menu</span>
												<p class="onoffswitch2 my-0"><input type="radio"
														name="onoffswitch6"
														id="switchbtn-defaultmenu"
														class="onoffswitch2-checkbox default-menu"
														checked>
													<label for="switchbtn-defaultmenu"
														class="onoffswitch2-label"></label>
												</p>
											</div>
											<div class="switch-toggle d-flex mt-2">
												<span class="me-auto">Closed Menu</span>
												<p class="onoffswitch2 my-0"><input type="radio"
														name="onoffswitch6" id="switchbtn-closed"
														class="onoffswitch2-checkbox default-menu">
													<label for="switchbtn-closed"
														class="onoffswitch2-label"></label>
												</p>
											</div>
											<div class="switch-toggle d-flex mt-2">
												<span class="me-auto">Icon with Text</span>
												<p class="onoffswitch2 my-0"><input type="radio"
														name="onoffswitch6" id="switchbtn-text"
														class="onoffswitch2-checkbox">
													<label for="switchbtn-text"
														class="onoffswitch2-label"></label>
												</p>
											</div>
											<div class="switch-toggle d-flex mt-2">
												<span class="me-auto">Icon Overlay</span>
												<p class="onoffswitch2 my-0"><input type="radio"
														name="onoffswitch6" id="switchbtn-overlay"
														class="onoffswitch2-checkbox">
													<label for="switchbtn-overlay"
														class="onoffswitch2-label"></label>
												</p>
											</div>
											<div class="switch-toggle d-flex mt-2">
												<span class="me-auto">Hover Submenu</span>
												<p class="onoffswitch2 my-0"><input type="radio"
														name="onoffswitch6" id="switchbtn-hoversub"
														class="onoffswitch2-checkbox">
													<label for="switchbtn-hoversub"
														class="onoffswitch2-label"></label>
												</p>
											</div>
											<div class="switch-toggle d-flex mt-2">
												<span class="me-auto">Hover Submenu style
													1</span>
												<p class="onoffswitch2 my-0"><input type="radio"
														name="onoffswitch6" id="switchbtn-hoversub1"
														class="onoffswitch2-checkbox">
													<label for="switchbtn-hoversub1"
														class="onoffswitch2-label"></label>
												</p>
											</div>
											<div class="switch-toggle d-flex mt-2">
												<span class="me-auto">Double Menu</span>
												<p class="onoffswitch2 my-0"><input type="radio"
														name="onoffswitch6"
														id="switchbtn-doublemenu"
														class="onoffswitch2-checkbox">
													<label for="switchbtn-doublemenu"
														class="onoffswitch2-label"></label>
												</p>
											</div>
											<div class="switch-toggle d-flex mt-2">
												<span class="me-auto">Double Menu with
													Tabs</span>
												<p class="onoffswitch2 my-0"><input type="radio"
														name="onoffswitch6"
														id="switchbtn-doublemenu-tabs"
														class="onoffswitch2-checkbox">
													<label for="switchbtn-doublemenu-tabs"
														class="onoffswitch2-label"></label>
												</p>
											</div>
										</div>
									</div>
								</div>
								<div class="swichermainleft">
									<h6>Phục hồi mặc định</h6>
									<div class="skin-body mb-0">
										<div class="switch_section my-2">
											<div class="d-grid">
												<button id="resetbtn" class="btn btn-primary"
													onclick="localStorage.clear();
														document.querySelector('html').style = '';
														names() ;
														resetData()" type="button">Phụ hồi cấu hình mặc định
												</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--End Row-->