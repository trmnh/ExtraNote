<?php
function HTMLInsertHeader() {
    $header = '
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="assets/css/styles.css">
        <link rel="stylesheet" href="assets/css/tooltip.css">
        <title>ExtraNote - Gestionnaire de notes</title>
    </head>';
    
    return $header;
}


function HTMLInsertBanner() {
    $banner = '
    <div class="row">
        <div class="col-12 text-center">      
            <h1><img src="assets/img/banner.png" class="img-fluid" alt="Logo Extra Note">ExtraNote</h1>
        </div>
    </div>';
    
    return $banner;
}

function HTMLInsertMenu() {
    $menu = '
    <div class="row">
        <div class="col-12 text-center">      
            x <a href="index.php">Home</a> X <a href="index.php?page=addnote">Ajouter</a> x
        </div>
    </div>';
    
    return $menu;
}


function HTMLInsertFooter() {
    $footer = '
    <footer class="appFooter">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <hr>
                    <p class="infoFooter">' . APP_NAME . ' - v' . APP_VERSION . ' - ' . APP_DATE_UPDATE . '</p>
                </div>
            </div>
        </div>
    </footer>';
    return $footer;
}
?>

