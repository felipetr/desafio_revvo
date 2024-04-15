<?php
// editCourse
checkLogin();

$props = getUrlArray($_GET['url']);

$imagesize = array(
    'width' => 1200,
    'height' => 400,
    'target' => 'destaquebox'
);
getModule('ImageUploadModal', $imagesize);

$slug = $props[0];

$pdo = connectServer();

$curso = getCursoBySlug($slug, $pdo);


?>
<script src="https://cdn.ckeditor.com/ckeditor5/35.2.0/classic/ckeditor.js"></script>



<div class="container py-5">



    <form id="editCourseForm">
        <div class="row">
            <div class="col-12 col-md-10">
                <h1 class="title-page medium-gray-color toUpper">// Editar Curso <small><i class="fas fa-chevron-right"></i> <?php echo $curso['title']; ?></small></h1>
                <hr class="separator">
                <h2 id="editable" class="title-page medium-gray-color ret toUpper h2editable" contenteditable="true"></h2>
                <input required type="hidden" id="hiddenInput" name="title">

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
                    <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#imageUploadModal"> Mudar Imagem </button>
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
                        $title = $modulo->title;
                        $content = $modulo->content;
                    ?>

                        <div id="modulo<?php echo $index; ?>" class="alert alert-secondary modulobox">
                            <div class="pb-3">Título:
                                <input required type="text" class="form-control" name="modulo_title[]">
                            </div>
                            
                            Conteúdo:
                            <textarea required name="modulo_content[]" class="richtext" id="rt<?php echo $index; ?>"><?php echo $content; ?></textarea>

                            <div class="text-center p-3">
                                <button type="button" id="deletamodulo<?php echo $index; ?>'" class="btn btn-danger deletamodulo">
                                    <i class="fas fa-trash"></i>Remover Módulo</button>
                            </div>
                        </div>

                    <?php
                    }

                    ?>
                </div>
                <div class="text-center p-4">
                    <button type="button" id="addModulo" class="btn btn-dark"><i class="fas fa-plus"></i> Adicionar Módulo</button>
                </div>
            </div>
            <div class="col-12 d-none d-md-block col-md-2">
                <div class="p-fixed">
                    <button type="submit" class="btn btn-dark d-block w-100">Salvar</button>
                    <div id="editCoursemsg"></div>

                </div>
            </div>
        </div>
        <div class="p-3 text-center d-block d-md-none">
            <button type="submit" class="btn btn-dark d-block w-100">Salvar</button>
        </div>
    </form>

</div>



<script>
    document.addEventListener('DOMContentLoaded', function() {

        const editCourseForm = document.getElementById("editCourseForm");
        const editCoursemsg = document.getElementById("editCoursemsg");
        editCourseForm.addEventListener("submit", function(event) {
            event.preventDefault();

            const formData = new FormData(updateProfileForm);

         
            const xhr = new XMLHttpRequest();
            xhr.open('POST', serverPath + "includes/updateCourse.php", true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 300) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        editCoursemsg.innerHTML = '<div class="alert alert-success">Informações salvas com sucesso!</div>';

                    } else {
                        editCoursemsg.innerHTML = '<div class="alert alert-danger">' + response.msg + '</div>';
                    }
                } else {
                    editCoursemsg.innerHTML = '<div class="alert alert-danger">Erro ao salvar dados</div>';
                }
            };
            xhr.send(formData);
        });


        function loadCK(el) {
            if (el.tagName !== 'TEXTAREA') {
                console.error('O elemento deve ser um textarea.');
                return;
            }


            ClassicEditor
                .create(el, {
                    language: 'pt-br'
                })
                .then(editor => {
                    console.log(editor);
                })
                .catch(error => {
                    console.error(error);
                });
        }


        function loadCKtoAll(textareas) {
            for (const textarea of textareas) {
                loadCK(textarea);
            }
        }

        const textareas = document.querySelectorAll('.richtext');

        loadCKtoAll(textareas);

        function handleDeleteClick(event) {
            if (event.target.classList.contains('deletamodulo')) {
                var modulobox = event.target.closest('.modulobox');
                if (modulobox) {
                    modulobox.remove();
                }
            }
        }

        document.addEventListener('click', handleDeleteClick);

        var addModulo = document.getElementById("addModulo");
        addModulo.addEventListener("click", function(event) {
            generateNewModule();
        });

        function deletamodulo(id) {


        }
        var moduleCount = <?php echo $moduleCount; ?>;


        function generateNewModule() {

            moduleCount++;
            var newModulo = '<div id="modulo' + moduleCount + '" class="alert alert-secondary modulobox">' +
                '<div class="pb-3">Título: <input required type="text" class="form-control" ' +
                'name="modulo_title[]"></div>Conteúdo:<textarea required name="modulo_content[]" ' +
                'class="richtext" id="rt' + moduleCount + '"></textarea>' +
                '<div class="text-center p-3">' +
                '<button type="button" ' +
                'id="deletamodulo' + moduleCount + '" class="btn btn-danger deletamodulo">' +
                '<i class="fas fa-trash"></i>Remover Módulo</button></div></div>';


            var modulesbox = document.getElementById("modulesbox");

            var newEl = document.createElement('div');

            newEl.innerHTML = newModulo;



            modulesbox.appendChild(newEl);
            []

            var textarea = document.getElementById('rt' + moduleCount);

            function loadCK(el) {
                if (el.tagName !== 'TEXTAREA') {
                    console.error('O elemento deve ser um textarea.');
                    return;
                }


                ClassicEditor
                    .create(el, {
                        language: 'pt-br'
                    })
                    .then(editor => {
                        console.log(editor);
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }

            loadCK(textarea);




        }



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
    });
</script>