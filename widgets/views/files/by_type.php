<?php
use app\modules\kholuutru\models\File;
?>

<?php foreach($fileTypes as $type){
    $files = File::getAllByLoaiFile($type->id, $doiTuong, $idDoiTuong);
?>
   	
<div class="text-dark mb-2 ms-1 fs-20 tx-medium"><?= $type->ten_loai ?></div>
<div class="row">        		
	<?php 
	if($files){
	   echo $this->render('file_thumbnail', ['files'=>$files]);
	} else {
	   echo '<div class="alert alert-primary" role="alert">Chưa có file</div>';
	}?>        		
</div>
<?php } ?>