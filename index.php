<?php

//$a = rand(000000,999999);
//echo sha1($a).'<br>';

if (isset($_GET['api'])) {

    $url = $_GET['api'];
    $urlArray = explode('/', $url);
    // Array 0 = vbi-api
    // Array 1 = file

    //print_r($urlArray);

    // Cek Array
    if (empty($urlArray[0]) || empty($urlArray[1])) {
        echo 'Pindahkan ke VBI Web Tidak ada Array';
    } else {
        if ($urlArray[0] == 'vbi-api') {
            // URL dengan auth vbiApi

            // Cek File
            $file = 'Controller/' . ucfirst($urlArray[1]) . 'Controller.php';

            if (file_exists($file)) {
                include_once $file;
            } else {
                echo 'Pindahkan ke VBI Web Tidak ada File';
            }
        } else {
            echo 'Pindahkan ke VBI Web Tidak ada vbi-api';
        }
    }

} else {
    echo 'Pindahkan ke VBI Webs Tidak isset api';
}

?>