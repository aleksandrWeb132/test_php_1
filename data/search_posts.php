<?php
require_once "autoload.php";
require_once "../config/config.php";

use lib\Orm;

$data = json_decode(file_get_contents('php://input'), true);

if(!array_key_exists('search', $data)) {
    die(json_encode([
        "code" => 40382,
        "message" => "Ошибка, не удалось найти параметр поиска!",
        "body" => $data
    ]));
}

$connect = new PDO("mysql:host=$host;dbname=$database", $username, $password);

$orm = new Orm($connect, "POSTS");

$search = $orm->findByString($data["search"]);

die(json_encode($search));