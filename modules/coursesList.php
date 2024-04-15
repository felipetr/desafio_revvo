<?php
// coursesList
checkLogin(); 
?><div class="container py-5">
    <h1 class="title-page medium-gray-color toUpper">// Cursos</h1>
    <hr class="separator">
    <div class="alert alert-secondary text-end">
        <a title="Novo Curso" href="<?php echo baseUrl() . 'novo-curso/'; ?>" class="btn btn-dark"><i class="fas fa-plus"></i> Novo Curso</a>

    </div>
    <hr class="separator">

    <div class="listCourses">
        <div class="row">
            <?php 



$conn = connectServer();


// Consulta para contar o total de resultados
$countSql = "SELECT COUNT(*) AS total FROM cursos";

$stmt = $conn->prepare($countSql);
$stmt->execute();

$props = getUrlArray($_GET['url']);
$pagination = pagination($props[0]);



$pagination['totalResults'] = $stmt->fetchColumn();



$sql = "SELECT * FROM cursos
        ORDER BY `createdDate`
        LIMIT :limit OFFSET :offset";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':limit', $pagination['limit'], PDO::PARAM_INT); 
$stmt->bindParam(':offset', $pagination['offset'], PDO::PARAM_INT); 
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
<img src="<?php echo baseUrl().'assets/images/etiqueta.svg'?>" alt="Novo" title="Novo" class="etiqueta">
<?php
                    } ?>
                    <figure class="loader">
                        <img title="<?php echo $course['title']; ?>" src="<?php
                                echo resizeImage(baseUrl() . '/uploads/'.$course['image'], 300, 145);
                                ?>" class="d-block w-100" alt="<?php echo $course['title']; ?>">
                    </figure>
                    <div class="p-3">
                        <h6 class="medium-gray-color toUpper ret"><?php echo $course['title']; ?></h6>
                        <div class="courseCardContent text-secondary mb-3">
                            <?php echo $course['text']; ?>
                        </div>
                        <div class="courseCardFooter">&nbsp;</div>
                        <a class="courseslink" href="<?php
                                            echo baseUrl() .'curso/'. $course['slug'];
                                            ?>">VER CURSO</a>
                       
                    </div>
                </div>
                
            </div></div>
            <?php } ?>
            
            

        </div>
    </div>
    <?php
    $pagination['gets'] = $_GET;

    getModule('pagination', $pagination); ?>
    
</div>