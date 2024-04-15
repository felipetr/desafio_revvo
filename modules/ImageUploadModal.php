<?php
// ImageUploadModal

?>
<div class="modal fade" id="imageUploadModal" tabindex="-1" aria-labelledby="imageUploadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageUploadModalLabel">
                    Enviar Imagem</h5> <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">

                <form class="alert alert-secondary text-center" id="uploadForm" enctype="multipart/form-data">
                    <input class="d-none" type="file" id="fileInput" name="file">
                    <button type="button" class="btn btn-dark btn-lg" id="fileFormBtn">Enviar</button>
                    <p id="status" style="display: none;"></p>
                </form>
                <div class="alert loader" id="loader" style="display:none;">
                    <h1>&nbsp;</h1>
                    <h1>&nbsp;</h1>
                </div>



            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('fileInput');
    const fileFormBtn = document.getElementById('fileFormBtn');

    fileInput.addEventListener('change', function() {
        submitForm();
    });

    fileFormBtn.addEventListener('click', function() {
        fileInput.click();
        

    });

    const imageUploadModal = new bootstrap.Modal(document.getElementById('imageUploadModal'));
       
    const imageUploadModalEvent = document.getElementById('imageUploadModal');
    imageUploadModalEvent.addEventListener('hidden.bs.modal', function() {
       
            if(loading == true)
            {
                 imageUploadModal.show();
            }
    });

      
        var loading = false;
    function submitForm() {
        
        const form = document.getElementById('uploadForm');
        const fileInput = document.getElementById('fileInput');
        const file = fileInput.files[0];
        const statusElement = document.getElementById('status');
        const uploadForm = document.getElementById('uploadForm');
        const loader = document.getElementById('loader');
        uploadForm.style.display = "none";
        loader.style.display = "block";
        
        loading = true;
        
        
        statusElement.style.display = "none";

        if (file) {
            const formData = new FormData();
            formData.append('file', file);
            formData.append('width', <?php echo $props['width']; ?>);
            formData.append('height', <?php echo $props['height']; ?>);

            const xhr = new XMLHttpRequest();
            xhr.open("POST", serverPath + "uploadImage.php", true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        const response = JSON.parse(xhr.responseText);

                        var imgCropped = response.imgCropped;
                        var imgUrl = response.imgUrl;

                        var imgCroppedEl = document.querySelector('#<?php echo $props['target']; ?> .imgCropped');
                        var imgUrlEl = document.querySelector('#<?php echo $props['target']; ?> .imgUrl');
                        imgUrlEl.value = imgUrl;
                        imgCroppedEl.src = imgCropped;
                        loading = false;
                        uploadForm.style.display = "block";
                         loader.style.display = "none";
                        imageUploadModal.hide();




                    } else {
                        statusElement.innerHTML = '<div class="alert alert-danger">Erro ao enviar imagem.</div>';
                         uploadForm.style.display = "block";
                         loader.style.display = "none";
                        statusElement.style.display = "block";
                        loading = false;
                    }
                }
            };
            xhr.send(formData);
        } else {
            statusElement.textContent = 'Selecione um arquivo para enviar.';
        }
    }
});
</script>