
<div class="container py-5">
    <h4 class="medium-gray-color">MEUS CURSOS</h4>
    <hr class="separator">
    <div class="listCourses">
        <div class="row">
            <?php $conn = connectServer();

$sql = "SELECT * FROM cursos ORDER BY `createdDate` DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC); 
for ($i = 0; $i < count($results); $i++) { 
    $course = $results[$i];
    ?>
    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
        <div class="autoH pb-30">
                <div class="courseCard p-relative">
                    <?php if($course['isNew'])
                    {
?>
<img src="<?php echo distUrl().'assets/images/etiqueta.svg'?>" alt="Novo" title="Novo" class="etiqueta">
<?php
                    } ?>
                    <figure class="loader">
                        <img title="<?php echo $course['title']; ?>" src="<?php
                                echo resizeImage(distUrl() . '/uploads/'.$course['image'], 300, 145);
                                ?>" class="d-block w-100" alt="<?php echo $course['title']; ?>">
                    </figure>
                    <div class="p-3">
                        <h6 class="medium-gray-color toUpper ret"><?php echo $course['title']; ?></h6>
                        <div class="courseCardContent text-secondary mb-3">
                            <?php echo $course['text']; ?>
                        </div>
                        <div class="courseCardFooter">&nbsp;</div>
                        <a class="courseslink" href="<?php
                                            echo distUrl() .'curso/'. $course['slug'];
                                            ?>">VER CURSO</a>
                       
                    </div>
                </div>
                
            </div></div>
            <?php } ?>
            
            <div class="col-6 col-md-4 col-lg-3 pb-30"><div class="autoH pb-30">
                <a class="newCourse" href="<?php echo distUrl().'novoCurso'; ?>">
                <div>
                <img title="Adicionar Curso" src="<?php
                                echo distUrl() . 'assets/images/add_course.svg';
                                ?>"  alt="Adicionar Curso">
                                <h4 class="toUpper">Adicionar<br><small>curso</small>
                                </h4>
                </div>
                </a>
            </div>
            </div>

        </div>
    </div>
</div>