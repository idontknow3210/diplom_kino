<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Headers: Content-Type');

$address = $_SERVER['DOCUMENT_ROOT'] . '/films';
$jsonData = json_decode(file_get_contents('php://input'), true);
$seances = json_decode(file_get_contents($address . '/seance.json'), true);

if($jsonData[0]==='price') {
    $way = mb_substr($jsonData[1], -1);
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . '\JSON\price\priceHall' . $way . '.json', json_encode($jsonData[2]));
} else if($jsonData[0]==='chairs') {  
    $way = mb_substr($jsonData[1], -1);
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . '\JSON\halls\chairsHall' . $way . '.json', json_encode($jsonData[2]));
} else if($jsonData[0]==='deleteSeance') {
    foreach($seances[$jsonData[1]][$jsonData[2]] as $key=>$value) {
      if($value===$jsonData[3]) {
        unset($seances[$jsonData[1]][$jsonData[2]][$key]);
        if(count($seances[$jsonData[1]][$jsonData[2]])===0) {
          unset($seances[$jsonData[1]][$jsonData[2]]);
        }
      }
    }
    file_put_contents($address . '/seance.json', json_encode($seances, JSON_UNESCAPED_UNICODE));
} else if($jsonData[0]==='deletefilm') {
    $films = json_decode(file_get_contents($address . '/infofilm.json'), true);
    unlink($_SERVER['DOCUMENT_ROOT'] .  '/i/posters/' . $jsonData[4]);
    unset($seances[$jsonData[1]]);
    unset($films[$jsonData[1]]);
    file_put_contents($address . '/seance.json', json_encode($seances, JSON_UNESCAPED_UNICODE));
    file_put_contents($address . '/infofilm.json', json_encode($films, JSON_UNESCAPED_UNICODE));
    
}

