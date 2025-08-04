<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="image-selection">
    <form action="<?= Url::to(['upload-images', 'id' => $id]) ?>" 
          class="dropzone" 
          id="image-dropzone">
        <div class="dz-message">
            Kéo và thả ảnh vào đây hoặc nhấp để chọn.
        </div>
    </form>
</div>


<script>
Dropzone.autoDiscover = false;

var selectedImages = [];
var dropzone = new Dropzone("#image-dropzone", {
    maxFilesize: 2, 
    acceptedFiles: "image/*", 
    addRemoveLinks: true, 
    dictRemoveFile: "Xóa",
    success: function(file, response) {
        if (response.success) {
            selectedImages.push(response.fileName); 
        } else {
            alert("Lỗi tải ảnh: " + response.message);
        }
    },
    removedfile: function(file) {
        var fileName = file.upload.filename;
        selectedImages = selectedImages.filter(img => img !== fileName);
        file.previewElement.remove();
    }
});

function saveSelectedImages() {
    if (selectedImages.length === 0) {
        alert("Vui lòng tải lên ít nhất một ảnh.");
        return;
    }

    // Gửi danh sách ảnh đã chọn tới server
    $.post({
        url: "<?= Url::to(['add-image', 'id' => $id]) ?>",
        data: { selectedImages: selectedImages },
        success: function(response) {
            if (response.success) {
                alert(response.message);
                $.pjax.reload({container: '#crud-datatable-pjax'});
                $("#modal").modal("hide");
            } else {
                alert(response.message);
            }
        },
        error: function(xhr) {
        alert("Đã có lỗi xảy ra: " + xhr.status + " - " + xhr.responseText);
        console.error("Chi tiết lỗi:", xhr); 
    },
    });
}
</script>
