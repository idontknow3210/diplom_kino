<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
header('Access-Control-Allow-Origin: http://localhost:8000');
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Headers: Content-Type');

if(isset($_POST)) {
    $jsonData = file_get_contents('php://input');
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/controler/controler.json', $jsonData);
} 

