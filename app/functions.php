<?php


function getImg(String $pathToRemoteImg, ?array &$error = null): bool
{
    $dir = DIR . '/img';

    if (!file_exists($dir)) {
        mkdir($dir);
    }
    $content = file_get_contents($pathToRemoteImg);

    if (!$content) {
        if ($error) {
            $error[] = 'Failed get image';
        }
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
        if ($error) {
            $error[] = "File {$imageName} exists";
        }
        return false;
    }

    $file =  fopen($pathToFile, 'w');
    if ($file) {
        if ($error) {
            $error[] = 'Failed to create a file';
        }
    }
    fclose($file);
}