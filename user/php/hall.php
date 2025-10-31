<?php
header('Access-Control-Allow-Origin: http://localhost:8001');
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Headers: Content-Type');

if($_GET['hall']) {
    $time = str_replace(':', '_', $_GET['time']);
    if(file_exists($_SERVER['DOCUMENT_ROOT'] . '/buySeances' . '/day' . $_GET['day'] . '/chairsHall' . mb_substr($_GET['hall'], -1) . '_' . $time . '.json')) {
        $data = [json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/JSON/price/priceHall' . mb_substr($_GET['hall'], -1) . '.json'), true), json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/buySeances' . '/day' . $_GET['day'] . '/chairsHall' . mb_substr($_GET['hall'], -1) . '_' . $time . '.json'))];
        echo json_encode($data);
    } else {
        $data = [json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/JSON/price/priceHall' . mb_substr($_GET['hall'], -1) . '.json'), true), json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/JSON/halls/chairsHall' . mb_substr($_GET['hall'], -1) . '.json'))];
        echo json_encode($data);
    }
} else {
    $data = json_decode(file_get_contents('php://input'), true);
    $time = str_replace(':', '_', $data[0]['time']);
    if(!is_dir($_SERVER['DOCUMENT_ROOT'] . '/buySeances' . '/day' . $data[0]['day'])) {
        mkdir($_SERVER['DOCUMENT_ROOT'] . '/buySeances' . '/day' . $data[0]['day']);
    }
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/buySeances' . '/day' . $data[0]['day'] . '/chairsHall' . mb_substr($data[0]['hall'], -1) . '_' . $time . '.json', json_encode($data[1]));
}