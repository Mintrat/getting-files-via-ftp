<?php


function getImg(String $pathToRemoteImg, array &$error = array()): bool
{
    set_time_limit(900);
    $dir = DIR . '/img';

    if (!file_exists($dir)) {
        mkdir($dir);
    }
    $content = file_get_contents($pathToRemoteImg);

    if (!$content) {
        $error[] = 'Failed get image';
        return false;
    }

    $parts = explode('/', $pathToRemoteImg);
    $count = count($parts);
    $lastPart = $count - 1;

    $imageName = $parts[$lastPart];
    $imageName = urldecode($imageName);
    $imageName = str_replace(' ', '_', $imageName);

    $pathToFile = $dir . '/' . $imageName;

    if (file_exists($pathToFile)) {
        $error[] = "File {$imageName} exists";
    }

    $file =  fopen($pathToFile, 'w');
    if ($file) {
        $error[] = 'Failed to create a file';
    }
    fclose($file);
    $result = file_put_contents($pathToFile, $content);

    if ($result) {
        return true;
    } else {
        return false;
    }
}