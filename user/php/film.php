<?php
header('Access-Control-Allow-Origin: http://localhost:8000');
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Headers: Content-Type');
$address = $_SERVER['DOCUMENT_ROOT'] . '/films';
if(isset($_POST['duration'])) {
    $dataFilm = [$_POST['name']=>['duration'=>$_POST['duration'], 'description'=>$_POST['description'], 'country'=>$_POST['country'], 'image'=>'http://localhost:8001/i/' . $_FILES['file']['name']]];
    if(!file_exists($address . '/infofilm.json') || filesize($address . '/infofilm.json') == 0) {
        file_put_contents($address . '/infofilm.json', json_encode($dataFilm, JSON_UNESCAPED_UNICODE));
    } else {
        $dataFilm = json_decode(file_get_contents($address . '/infofilm.json'), true);
        $dataFilm[$_POST['name']] = ['duration'=>$_POST['duration'], 'description'=>$_POST['description'], 'country'=>$_POST['country'], 'image'=>'http://localhost:8001/i/' . $_FILES['file']['name']];
        file_put_contents($address . '/infofilm.json', json_encode($dataFilm, JSON_UNESCAPED_UNICODE));
    }
    if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/i/posters/' . $_FILES['file']['name'])) {
        move_uploaded_file($_FILES['file']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] .  '/i/posters/' . $_FILES['file']['name']);
    } else {
        unlink($_SERVER['DOCUMENT_ROOT'] .  '/i/posters/' . $_FILES['file']['name']);
        move_uploaded_file($_FILES['file']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] .  '/i/posters/' . $_FILES['file']['name']);
    }
    

} else if (isset($_POST['hall'])) {
    $dataSeance = [
        $_POST['film']=>[
            $_POST['hall']=>[
                $_POST['start_time']
            ]
        ]
    ];

    if(!file_exists($address . '/seance.json') || filesize($address . '/seance.json') == 0) {
        file_put_contents($address . '/seance.json', json_encode($dataSeance, JSON_UNESCAPED_UNICODE));
    } else {
        $dataSeance = json_decode(file_get_contents($address . '/seance.json'), true);
            if(isset($dataSeance[$_POST['film']][$_POST['hall']])) {
                if(in_array($_POST['start_time'], $dataSeance[$_POST['film']][$_POST['hall']])) {
                    echo 'Ошибка: Это время, для этого зала и фильма, уже было ранее установлено!';
                } else {
                    array_push($dataSeance[$_POST['film']][$_POST['hall']], $_POST['start_time']);
                    file_put_contents($address . '/seance.json', json_encode($dataSeance, JSON_UNESCAPED_UNICODE));
                }
            } else {
                $dataSeance[$_POST['film']][$_POST['hall']]=[$_POST['start_time']];
                file_put_contents($address . '/seance.json', json_encode($dataSeance, JSON_UNESCAPED_UNICODE));
            }
    }
} 