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
    <link href="https://fonts.googleapis.com/css2?family=GFS+Neohellenic:ital,wght@0,400;0,700;1,400;1,700&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="row">
                <div class="col-6 col-md-7">
                    <a href="<?php echo $base_url; ?>" title="Desafio Revvo">
                    <img src="<?php echo $base_url; ?>assets/images/logo_header.svg" class="logoHeader" alt="LEO">
                    </a>
                </div>
                <div class="d-none d-md-block col-3">
                    <form action="courseSearch.php" id="searchForm">
                        <div class="search_group">
                  
                            <input placeholder="Pesquisar Cursos..." type="search" name="search"/>
              
                            <button type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-6 col-md-2">

                </div>
            </div>
        </div>
    </header>