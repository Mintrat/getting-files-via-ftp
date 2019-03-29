<?php

include './include.php';

if (isset($_GET['test'])) {
    try {
        $ftp = new GetterFileToFTP($param);
        $ftp->writeToFile();
    } catch (Exception $exception) {
        echo $exception->getMessage();
    }
}

$file = file_get_contents($param['localFile']);

$xml = new SimpleXMLElement($file);
echo '<pre>';

$imgLink = $xml->gd[0]->image;
$arr = explode('/', $imgLink);
$nameImage = $arr[count($arr) - 1];
$nameImage = urldecode($nameImage);
echo str_replace(' ', '_', $nameImage);


