<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpqrcode/qrlib.php';
$json = file_get_contents('php://input');
$data = '';
foreach (json_decode($json, true) as $k=>$v) {
    $data.= "$k: $v; ";
}
header('Access-Control-Allow-Origin: *');
header('Content-Type: image/x-png');
header('Access-Control-Allow-Headers: Content-Type');

QRcode::png($data);
