<?php
require_once 'config/database.php';
require_once 'library/library.php';
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
    $tbname = 'students';
    $labeight = new labEight();
    $data = $labeight ->getAll($tbname);

    echo json_encode([
        'result'=> true,
        'message'=> 'Get students successfully',
        'data'=> $data
    ]);
