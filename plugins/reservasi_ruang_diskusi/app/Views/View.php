<?php

namespace ReservasiRuangDiskusi\App\Views;

class View
{
    static function load($filename, $data = [])
    {
        $filename = __DIR__ . '/' . $filename . '.php';
        if (file_exists($filename)) {
            extract($data);
            include $filename;
        }
    }
}
