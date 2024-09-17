<?php
use yii\widgets\ActiveForm;
?>
<form action="" class="dropzone">
  <div class="fallback">
    <input name="file" type="file" multiple />
  </div>
</form>
 
<script type="text/javascript">
  Dropzone.autoDiscover = false;
	$(function(){
	    uploader = new Dropzone(".dropzone",{
	        url: "/kholuutru/file/upload-multi-process?loaiFile=<?= $loaiFile?>&doiTuong=<?= $doiTuong ?>&idDoiTuong=<?= $idDoiTuong ?>",
	        /*paramName : "uploadedFiles",
	        uploadMultiple :false,
	        acceptedFiles : "image/*,video/*,audio/*",
	        addRemoveLinks: true,
	        forceFallback: false,
	        maxFilesize:1000000,
	        parallelUploads: 100,*/
	       /* init: function() {
			  this.on('addedfile', function(file) {
			    if (this.files.length > 1) {
			      this.removeFile(this.files[0]);
			      //alert('chỉ 1 file được phép!');
			    }
			  });
			}*/

	    });//end drop zone

		uploader.on("success", function(file,response) {
		   	if(response.message == 'success'){
			   	//funcOne(response.data);
		   	}
		   	else{
		   		alert('Có lỗi xảy ra!');
		   	}
	  	});

	});//end jq
</script>