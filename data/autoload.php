<?php

spl_autoload_register(function ($class_name) {
    $file = "../" . str_replace("\\", "/", $class_name) . ".php";

    if (file_exists($file)) {
        require_once $file;
    }
    else {
        die("Файл $file не найден.");
    }
});