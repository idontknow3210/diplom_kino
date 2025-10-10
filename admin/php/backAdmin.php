<?php
header('Access-Control-Allow-Origin: http://localhost:8000');
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Headers: Content-Type');
$html = json_decode(file_get_contents('php://input'), true);
if('halls'===$html[0]) {
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . '\HTML\halls.json', json_encode($html[1]));
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . '\HTML\hallsSection.json', json_encode($html[2]));
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . '\HTML\hallsSeance.json', json_encode($html[3]));

} else if (isset($_FILES['file'])) {
    move_uploaded_file($_FILES['file']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/i/posters/' . $_FILES['file']['name']);
} else if ('films'===$html[0] || 'removefilms'===$html[0]) {
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . '\HTML\films.json', json_encode($html[1]));
    if ('removefilms'===$html[0]) {
      unlink($_SERVER['DOCUMENT_ROOT'] . '\i\posters\\' . $html[2]);
    } 
} else if ('seances'===$html[0]) {
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . '\HTML\hallsSeance.json', json_encode($html[1]));
} 
