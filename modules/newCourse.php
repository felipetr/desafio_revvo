<?php
// newCourse
checkLogin();

$imagesize = array(
    'width' => 1200,
    'height' => 400,
    'target' => 'destaquebox'
);
getModule('ImageUploadModal', $imagesize);

?>
<script src="https://cdn.tiny.cloud/1/<?php echo getenv('TINYMCE_KEY') ?>/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>




<div class="container py-5">



    <form id="newCourseForm">
        <div class="row">
       
                <h1 class="title-page medium-gray-color toUpper">// Novo Curso</h1>
                <hr class="separator">
                <h4 class="title-page medium-gray-color toUpper">// Título:</h4>
                <div class="text-secondary"> <i class="fas fa-info"></i> Clique no título para editar</div>
             
                <h2 id="editable" class="title-page medium-gray-color ret toUpper h2editable" contenteditable="true"></h2>
                
              
                <hr>
                <h4 class="title-page medium-gray-color toUpper">// Resumo</h4>
                <textarea name="text" class="richtext"></textarea>

                <hr>
                <h4 class="title-page medium-gray-color toUpper">// Imagem de Destaque</h4>

                <div id="destaquebox">
                    <div>
                        <input name="image" type="hidden" id="imgUrl" class="imgUrl" value="default.png">
                    </div>
                    <img id="destaqueimg" class="destaqueimg w-100 border border-secondary loader imgCropped" src="<?php echo resizeImage(baseUrl() . 'uploads/' . 'default.png', 1200, 400) ?>" alt="avatar">

                </div>
                <div class="p-3 text-center">
                    <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#imageUploadModal"> Selecionar Imagem </button>
                </div>

                <hr>
                <h4 class="title-page medium-gray-color toUpper">// Configurações</h4>

                <div class="py-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" name="destaque" id="destaque">
                        <label class="form-check-label" for="destaque">
                            Destaque
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" name="isNew" id="isNew">
                        <label class="form-check-label" for="isNew">
                            Etiqueta de "Novo"
                        </label>
                    </div>
                </div>
                <hr>
                <h4 class="title-page medium-gray-color toUpper">// Módulos</h4>
                <div id="modulesbox">
                </div>
                <div class="text-center p-4">
                    <button type="button" id="addModulo" class="btn btn-dark"><i class="fas fa-plus"></i> Adicionar Módulo</button>
                </div>
            <hr>
            <button type="submit" class="btn mb-3 btn-dark d-block w-100">Salvar</button>
            <div id="newCoursemsg"></div>

        </div>
    </form>

</div>



<script>
    document.addEventListener('DOMContentLoaded', function() {

        const h2Editable = document.getElementById('editable');
        const newCourseForm = document.getElementById("newCourseForm");
        const newCoursemsg = document.getElementById("newCoursemsg");
        newCourseForm.addEventListener("submit", function(event) {
            event.preventDefault();

            const formData = new FormData(newCourseForm);
           
            formData.append('title', document.getElementById('editable').innerText)

            const xhr = new XMLHttpRequest();
            xhr.open('POST', serverPath + "includes/courses/createCourse.php", true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 300) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {

                        slug = response.slug;
                        window.location.href = "<?php echo baseUrl(); ?>edit-curso/" + slug;



                    } else {
                        newCoursemsg.innerHTML = '<div class="alert alert-danger">' + response.msg + '</div>';
                    }
                } else {
                    newCoursemsg.innerHTML = '<div class="alert alert-danger">Erro ao salvar dados</div>';
                }
            };
            xhr.send(formData);
        });




        function handleDeleteClick(event) {
            if (event.target.classList.contains('deletamodulo')) {
                var modulobox = event.target.closest('.modulobox');
                if (modulobox) {
                    modulobox.remove();
                }
            }
        }

        document.addEventListener('click', handleDeleteClick);

        var moduleCount = 0;
        var addModulo = document.getElementById("addModulo");
        addModulo.addEventListener("click", function(event) {
            moduleCount++;

            document.getElementById('modulesbox').appendChild(generateNewModule(moduleCount));

            var newrichtext = document.getElementById('richtext' + moduleCount);

            setTimeout(function() {
                
                
                 loadRichText('#richtext' + moduleCount);
              

                
            }, 100);

        });

      

      

       
        loadRichText('.richtext');
        
    });
</script>