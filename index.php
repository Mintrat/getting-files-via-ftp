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

for ($count = 0; $count < 200; ++$count) {
    if (isset($xml->gd[$count])) {
        $imgLink = $xml->gd[$count]->image;

        if ($imgLink) {
            getImg($imgLink);
        }
    }

}