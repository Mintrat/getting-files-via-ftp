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

$imgLink = $xml->gd[0]->image;

$messError = '';
$messSuccess = '';
$erroList = [];
$count = 0;

while ($imgLink = $xml->gd[$count]->image) {
    getImg($imgLink);
    ++$count;
}

die;
for ($count = 0; $count < 30; ++$count) {
    $imgLink = $xml->gd[$count]->image;
    $err = array();
    $isComplete = getImg($imgLink, $err);

    if ($isComplete) {
        echo '<p style="color: green">' . $count . ' ok</p>';
        echo '<pre>';
        print_r($err);
        echo '</pre>';

    } else {
        $erroList[] = $err;
        echo '<hr>';
        echo '<p style="color: red">' . $count . ' failed</p>';
        echo '<p style="color: red">' . $imgLink . '</p>';
        echo '<hr>';
    }
}