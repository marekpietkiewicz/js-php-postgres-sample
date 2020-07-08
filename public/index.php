<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use MarekApp\Conn as Connection;
use MarekApp\Colors as Colors;
use MarekApp\Votes as Votes;
 
try {
    // connect to the PostgreSQL database, and get all data
    $db = Connection::get()->connect();
    
    if(isset($_GET['color'])){
        //for precaution
        $color = htmlspecialchars(pg_escape_string($_GET['color']));
        $votes = new Votes($db);

        header('Content-Type: application/json');
        echo json_encode($votes->getOne($color));
        exit;
    }else{
        $colors = new Colors($db);
        // Instantiate our Twig
        $loader = new Twig_Loader_Filesystem(__DIR__.'/template');
        $twig   = new Twig_Environment($loader);
        // render the homepage view
        echo $twig->render('index.html', ['colors' => $colors->all()] );
    }
} catch (\PDOException $e) {
    echo $e->getMessage();
}