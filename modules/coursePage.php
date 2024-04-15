<?php
// coursePage
checkLogin();
$props = getUrlArray($_GET['url']);


$pdo = connectServer();

$slug = $props[0];

$curso = getCursoBySlug($slug, $pdo);

?>

<img title="<?php echo $curso['title']; ?>" src="<?php
                                                    echo resizeImage(baseUrl() . '/uploads/' . $curso['image'], 1440, 325);
                                                    ?>" class="d-none d-md-block w-100" alt="<?php echo $curso['title']; ?>">
<img title="<?php echo $curso['title']; ?>" src="<?php
                                                    echo resizeImage(baseUrl() . '/uploads/' . $curso['image'], 800, 450);
                                                    ?>" class="d-block d-md-none w-100" alt="<?php echo $curso['title']; ?>">



<div class="container py-5">
    <h1 class="title-page medium-gray-color toUpper">// <?php echo $curso['title']; ?></h1>
    <hr class="separator">

    <div class="alert alert-secondary text-end">
        <button data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" title="Excluir" type="button" class="btn btn-danger"><i class="fas fa-trash"></i> Excluir</button>
        <a title="Editar" href="<?php echo baseUrl() . 'edit-curso/' . $curso['slug']; ?>" class="btn btn-dark"><i class="fas fa-edit"></i> Editar</a>

    </div>

    <?php echo $curso['text']; ?>

    <hr>

    <h3 class="title-page medium-gray-color toUpper">// Módulos</h3>

    <div class="accordion" id="accordionCourse">


        <?php
        $contentArr = json_decode($curso['content']);

        foreach ($contentArr as $index => $modulo) {

            $title = $modulo->title;
            $content = $modulo->content;
        ?>
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading<?php echo $index ?>">
                    <button class="accordion-button <?php echo $index ? 'collapsed' : ''; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $index ?>" aria-expanded="<?php echo $index ? 'false' : 'true'; ?>" aria-controls="collapse<?php echo $index ?>">
                        <?php echo $title; ?>
                    </button>
                </h2>
                <div id="collapse<?php echo $index ?>" class="accordion-collapse collapse <?php echo $index ? '' : 'show'; ?>" aria-labelledby="heading<?php echo $index ?>" data-bs-parent="#accordionCourse">
                    <div class="accordion-body">
                        <?php echo $content; ?>
                    </div>
                </div>
            </div>

        <?php } ?>
    </div>

    
</div>

<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Exclusão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Tem certeza de que deseja excluir este curso?
                <div id="deleteCoursemsg" class="pt-3" style="display:none;"></div>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>

                <button type="button" class="btn btn-danger" id="confirmDelete">Excluir</button>

            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const confirmDelete = document.getElementById("confirmDelete");
        const deleteCoursemsg = document.getElementById("deleteCoursemsg");

confirmDelete.addEventListener("click", function(event) {
            event.preventDefault();

            const formData = new FormData();
		formData.append('slug', '<?php echo $curso['slug']; ?>');

            const xhr = new XMLHttpRequest();
            xhr.open('POST', serverPath + "includes/courses/deleteCourse.php", true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 300) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        window.location.href = "<?php echo baseUrl(); ?>cursos/1";

                    } else {
                        deleteCoursemsg.innerHTML = '<div class="alert alert-danger">' + response.msg + '</div>';
                        deleteCoursemsg.style.display = 'block';
                    }
                } else {
                    deleteCoursemsg.innerHTML = '<div class="alert alert-danger">Erro ao excluir curso</div>';
                    deleteCoursemsg.style.display = 'block';
                }
            };
            xhr.send(formData);
        });

    });
</script>