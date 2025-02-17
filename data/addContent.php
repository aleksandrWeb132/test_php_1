<?php
require_once "autoload.php";
require_once "../config/config.php";

use lib\Cron;
use lib\Orm;

$connect = new PDO("mysql:host=$host;dbname=$database", $username, $password);

$countPost = 0;
$countComment = 0;

$cron = new Cron();

$posts = $cron->get("https://jsonplaceholder.typicode.com/posts");
if($posts["code"] === 404) {
    die($posts["message"]);
}

$orm = new Orm($connect, "POSTS");

$postsBd = $orm->getList();
if(count($postsBd["body"]) === 0) {
    $orm->addPosts($posts["body"]);
}
else {
    $titlesPostsBd = array_column($postsBd["body"], 'TITLE');

    $result = array_filter($posts["body"], function($item) use ($titlesPostsBd) {
        return !in_array($item['title'], $titlesPostsBd);
    });

    if(count($result) !== 0) {
        $orm->addPosts($result);

        $countPost = count($result);
    }
}



//$comments = $cron->get("https://jsonplaceholder.typicode.com/comments");