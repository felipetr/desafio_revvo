<?php
// editCourse
checkLogin();

$imagesize = array(
    'width' => 1200,
    'height' => 400,
    'target' => 'destaquebox'
);
getModule('ImageUploadModal', $imagesize);
$props = getUrlArray($_GET['url']);
$slug = $props[0];

$pdo = connectServer();

$curso = getCursoBySlug($slug, $pdo);


?>
<script src="https://cdn.tiny.cloud/1/<?php echo getenv('TINYMCE_KEY') ?>/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>




<div class="container py-5">



    <form id="editCourseForm">
        
                <h1 class="title-page medium-gray-color toUpper">// Editar Curso <small><i class="fas fa-chevron-right"></i> <?php echo $curso['title']; ?></small></h1>
                <hr class="separator">
                <h4 class="title-page medium-gray-color toUpper">// Título:</h4>
                <div class="text-secondary"> <i class="fas fa-info"></i> Clique no título para editar</div>
                <h2 id="editable" class="title-page medium-gray-color ret toUpper h2editable" contenteditable="true"><?php echo $curso['title'] ?></h2>
                 <input value="<?php echo $curso['title'] ?>" required type="hidden" name="title">

                <hr>
                <h4 class="title-page medium-gray-color toUpper">// Resumo</h4>
                <textarea name="text" id="richtext" class="richtext"><?php echo $curso['text'] ?></textarea>
                <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                loadRichText('#richtext');
                            });
                        </script>
                <hr>
                <h4 class="title-page medium-gray-color toUpper">// Imagem de Destaque</h4>

                <div id="destaquebox">
                    <div>
                        <input name="image" type="hidden" id="imgUrl" class="imgUrl" value="<?php echo $curso['image'] ?>">
                    </div>
                    <img id="destaqueimg" class="destaqueimg w-100 border border-secondary loader imgCropped" src="<?php echo resizeImage(baseUrl() . 'uploads/' . $curso['image'], 1200, 400) ?>" alt="avatar">

                </div>
                <div class="p-3 text-center">
                    <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#imageUploadModal"> Selecionar Imagem </button>
                </div>

                <hr>
                <h4 class="title-page medium-gray-color toUpper">// Configurações</h4>

                <div class="py-3">
                    <div class="form-check">
                        <input <?= $curso['destaque'] ? 'checked' : '' ?> class="form-check-input" type="checkbox" value="1" name="destaque" id="destaque">
                        <label class="form-check-label" for="destaque">
                            Destaque
                        </label>
                    </div>
                    <div class="form-check">
                        <input <?= $curso['isNew'] ? 'checked' : '' ?> class="form-check-input" type="checkbox" value="1" name="isNew" id="isNew">
                        <label class="form-check-label" for="isNew">
                            Etiqueta de "Novo"
                        </label>
                    </div>
                </div>
                <hr>
                <h4 class="title-page medium-gray-color toUpper">// Módulos</h4>
                <div id="modulesbox">
                    <?php
                    $contentArr = json_decode($curso['content']);
                    $moduleCount = 0;
                    foreach ($contentArr as $index => $modulo) {
                        $moduleCount = $index;
                        $moduletitle = $modulo->title;
                        $modulecontent = $modulo->content;
                    ?>

                        <div id="modulo<?php echo $index; ?>" class="alert alert-secondary modulobox">
                            <div class="pb-3">Título:
                                <input value="<?php echo $moduletitle ?>" required type="text" class="form-control" name="modulo_title[]">
                            </div>

                            Conteúdo:
                            <textarea name="modulo_content[]" class="richtext" id="richtext<?php echo $index; ?>"><?php echo $modulecontent; ?></textarea>

                            <div class="text-center p-3">
                                <button type="button" id="deletamodulo<?php echo $index; ?>'" class="btn btn-danger deletamodulo">
                                    <i class="fas fa-trash"></i>Remover Módulo</button>
                            </div>
                        </div>

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                loadRichText('#richtext<?php echo $index; ?>');
                            });
                        </script>
                    <?php
                    }

                    ?>

                </div>
                <div class="text-center p-4">
                    <button type="button" id="addModulo" class="btn btn-dark"><i class="fas fa-plus"></i> Adicionar Módulo</button>
                </div>
            <hr>
            <button type="submit" class="btn mb-3 btn-dark d-block w-100">Salvar</button>
            <div id="editCoursemsg"></div>
       
    </form>

</div>



<script>
    document.addEventListener('DOMContentLoaded', function() {

        const editCourseForm = document.getElementById("editCourseForm");
        const editCoursemsg = document.getElementById("editCoursemsg");
        editCourseForm.addEventListener("submit", function(event) {
            event.preventDefault();

            const formData = new FormData(editCourseForm);
            formData.append('slug', '<?php echo $curso['slug']; ?>');


            const xhr = new XMLHttpRequest();
            xhr.open('POST', serverPath + "includes/courses/updateCourse.php", true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 300) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {

                        slug = response.slug;
                        editCoursemsg.innerHTML = '<div class="alert alert-success">Curso editado com sucesso</div>';
                    

                    } else {
                        editCoursemsg.innerHTML = '<div class="alert alert-danger">' + response.msg + '</div>';
                               }
                } else {
                    editCoursemsg.innerHTML = '<div class="alert alert-danger">Erro ao salvar dados</div>';
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

        var moduleCount = <?php echo $moduleCount; ?>;
        var addModulo = document.getElementById("addModulo");
        addModulo.addEventListener("click", function(event) {
            moduleCount++;

            document.getElementById('modulesbox').appendChild(generateNewModule(moduleCount));

            var newrichtext = document.getElementById('richtext' + moduleCount);

            setTimeout(function() {


                loadRichText('#richtext' + moduleCount);



            }, 100);

        });

        const h2Editable = document.getElementById('editable');

        h2Editable.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
            }
        });

        h2Editable.addEventListener('input', function() {

            const hiddenInput = document.getElementById('hiddenInput');
            hiddenInput.value = h2Editable.innerText;
        });


        loadRichText('.richtext');

    });
</script>