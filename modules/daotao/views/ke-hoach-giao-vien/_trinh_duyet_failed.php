<?php
use app\custom\CustomFunc;
?>
<div class="alert alert-danger">
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true">×</button>
	<span><svg xmlns="http://www.w3.org/2000/svg" height="40" width="40" viewBox="0 0 24 24">
			<path fill="#f07f8f" d="M20.05713,22H3.94287A3.02288,3.02288,0,0,1,1.3252,17.46631L9.38232,3.51123a3.02272,3.02272,0,0,1,5.23536,0L22.6748,17.46631A3.02288,3.02288,0,0,1,20.05713,22Z"></path>
			<circle cx="12" cy="17" r="1" fill="#e62a45"></circle>
			<path fill="#e62a45" d="M12,14a1,1,0,0,1-1-1V9a1,1,0,0,1,2,0v4A1,1,0,0,1,12,14Z"></path>
		</svg></span>
	<strong>Không thể trình duyệt kế hoạch!</strong>
	<hr class="message-inner-separator">
	<p>Nguyên nhân: Kế hoạch chưa có nội dung. Vui lòng cập nhật nội dung cho kế hoạch ngày 
		<?= CustomFunc::convertYMDToDMY($model->ngay_thuc_hien) ?>!</p>
</div>