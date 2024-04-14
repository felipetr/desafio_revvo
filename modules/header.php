<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Desafio Revvo<?php
                        $url = '';
                        if (isset($_GET['url'])) {
                            $url = $_GET['url'];
                            $title = getTitle($url);
                            if (strstr($url, '/')) {
                                $urlArr = explode('/', $url);
                                if ($urlArr[0] == 'curso') {
                                    $course = getCourseDataBySlug($urlArr[1]);
                                    $title .= " | " . $course['title'];
                                }
                            }
                        }
                        if (isset($_GET['s'])) {
                            $title .= " | " . $_GET['s'];
                        }


                        if (isset($title)) {
                            echo ' | ' . $title;
                        } ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <link rel="icon shortcut" type="image/x-icon" href="assets/images/favicon.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="<?php echo baseUrl() ?>assets/css/style.css?v=<?php echo time() ?>">
</head>

<body>
    <script>
        const baseUrl = "<?php echo baseUrl(); ?>";
        const serverPath = "<?php echo serverPath(); ?>";
    </script>
    <header class="pt-header">
        <div class="d-block d-md-none">
            <?php getModule('searchForm'); ?>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-7 p-header">
                    <a href="<?php echo baseUrl(); ?>" title="Desafio Revvo">
                        <img src="<?php echo baseUrl(); ?>assets/images/logo_header.svg" class="logoHeader" alt="LEO">
                    </a>
                </div>
                <div class="d-none d-md-block col-3 border-end border-primary-subtle p-header">
                    <?php getModule('searchForm'); ?>
                </div>
                <div class="col-5 col-md-2 p-header text-end">
                    <?php getModule('userDropdown'); ?>
                </div>
            </div>
        </div>
    </header>
    <div class="contentbox">