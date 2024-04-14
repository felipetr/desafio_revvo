<?php
// homeSlider

$conn = connectServer();

$sql = "SELECT * FROM cursos WHERE destaque = 1 ORDER BY `createdDate` DESC LIMIT 4";
$stmt = $conn->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div id="homeSlider" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators-box">
        <div class="carousel-indicators">
            <?php for ($i = 0; $i < count($results); $i++) {
                $course = $results[$i];
            ?>
                <button type="button" data-bs-target="#homeSlider" data-bs-slide-to="<?php echo $i; ?>" <?php
                                                                                                        if (!$i) {  ?>class="active" aria-current="true" <?php } ?>aria-label="<?php echo $course['title']; ?>"></button>
            <?php } ?>
        </div>
    </div>
    <div class="carousel-inner loader">
        <?php
        for ($i = 0; $i < count($results); $i++) {
            $course = $results[$i];
        ?>
            <div class="carousel-item<?php if (!$i) {
                                            echo ' active';
                                        } ?>">
                <div class="p-relative">
                    <div class="slider-content">
                        <div class="container">
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <div class="p-relative">
                                        <div class="sliderBox">
                                            <h2 class="toUpper ret"><?php echo $course['title']; ?></h2>
                                            <div class="resume"><?php echo $course['text']; ?></div>
                                            <a href="<?php
                                                        echo baseUrl() . 'curso/' . $course['slug'];
                                                        ?>" class="seeMore">VER CURSO</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <img title="<?php echo $course['title']; ?>" src="<?php
                                                                        echo resizeImage(baseUrl() . '/uploads/' . $course['image'], 1440, 325);
                                                                        ?>" class="d-none d-md-block w-100" alt="<?php echo $course['title']; ?>">
                    <img title="<?php echo $course['title']; ?>" src="<?php
                                                                        echo resizeImage(baseUrl() . '/uploads/' . $course['image'], 800, 450);
                                                                        ?>" class="d-block d-md-none w-100" alt="<?php echo $course['title']; ?>">

                </div>
            </div>
        <?php
        }
        ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#homeSlider" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Anterior</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#homeSlider" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Próximo</span>
    </button>
</div>