<?php
// searchList

checkLogin(); 
?>
<div class="container py-5">
    <h1 class="title-page medium-gray-color toUpper">// PESQUISAR CURSOS <small><i class="fas fa-chevron-right"></i> Procurando por: "<?php echo $_GET['s']; ?>"</small></h1>
    <hr class="separator">
    <div class="listCourses">
        <div class="row">
            <?php $conn = connectServer();
$search = strtolower($_GET['s']);
$search = '%' . addslashes($search) . '%';


$props = getUrlArray($_GET['url']);
$pagination = pagination($props[0]);


// Consulta para contar o total de resultados
$countSql = "SELECT COUNT(*) AS total FROM cursos
             WHERE LOWER(title) LIKE :search
             OR LOWER(text) LIKE :search
             OR LOWER(content) LIKE :search";

$stmt = $conn->prepare($countSql);
$stmt->bindParam(':search', $search);
$stmt->execute();
$pagination['totalResults'] = $stmt->fetchColumn();

$sql = "SELECT * FROM cursos
        WHERE LOWER(title) LIKE :search
        OR LOWER(text) LIKE :search
        OR LOWER(content) LIKE :search
        ORDER BY `createdDate` DESC
        LIMIT :limit OFFSET :offset";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':search', $search);
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