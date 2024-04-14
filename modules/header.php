<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Desafio Revvo<?php if(isset($title))
    {
        echo ' - '.$title;
    } ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <link rel="icon shortcut" type="image/x-icon" href="assets/images/favicon.png" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Arimo:ital,wght@0,400..700;1,400..700&family=GFS+Neohellenic:ital,wght@0,400;0,700;1,400;1,700&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="<?php echo distUrl() ?>assets/css/style.css?v=<?php echo time() ?>">
</head>
<body>
    <script>
        const distUrl = "<?php echo distUrl(); ?>";
        const baseUrl = "<?php echo baseUrl(); ?>";
    </script>
    <header class="pt-header">
        <div class="container">
            <div class="row">
                <div class="col-6 col-md-7 p-header">
                    <a href="<?php echo distUrl(); ?>" title="Desafio Revvo">
                    <img src="<?php echo distUrl(); ?>assets/images/logo_header.svg" class="logoHeader" alt="LEO">
                    </a>
                </div>
                <div class="d-none d-md-block col-3 border-end border-primary-subtle p-header">
                    <form action="<?php echo distUrl(); ?>course-search" id="searchForm">
                        <div class="search-group">
                  
                            <input placeholder="Pesquisar Cursos..." title="Pesquisar Cursos" type="search" class="form-control" name="search"/>
              
                            <button type="button" title="Pesquisar Cursos" class="btn">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-6 col-md-2 p-header">
                    <?php
                    $props = array(
                      'teste' => 1,  
                      'teste2' => 2,  
                    );
                    getModule('userDropdown'); ?>
                </div>
            </div>
        </div>
    </header>
    <div class="contentbox">