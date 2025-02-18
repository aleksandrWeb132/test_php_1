<?php
require_once "autoload.php";
require_once "../config/config.php";

use lib\Orm;

$connect = new PDO("mysql:host=$host;dbname=$database", $username, $password);

$orm = new Orm($connect, "POSTS");

$posts = $orm->getList();

die(json_encode($posts));