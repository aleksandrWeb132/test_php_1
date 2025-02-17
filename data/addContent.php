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
    $addPosts = $orm->addPosts($posts["body"]);

    $countPost = $addPosts["body"];
}
else {
    $titlesPostsBd = array_column($postsBd["body"], "TITLE");

    $result = array_filter($posts["body"], function($item) use ($titlesPostsBd) {
        return !in_array($item["title"], $titlesPostsBd);
    });

    if(count($result) !== 0) {
        $addPosts = $orm->addPosts($result);

        if($addPosts["code"] !== 1) {
            die($addPosts["message"]);
        }

        $countPost = $addPosts["body"];
    }
}

$comments = $cron->get("https://jsonplaceholder.typicode.com/comments");
if($comments["code"] === 404) {
    die($comments["message"]);
}

$orm = new Orm($connect, "COMMENTS");

$commentsBd = $orm->getList();
if(count($commentsBd["body"]) === 0) {
    $addComments = $orm->addComments($comments["body"]);

    $countComment = $addComments["body"];
}
else {
    $titlesCommentsBd = array_column($commentsBd["body"], "NAME");

    $result = array_filter($comments["body"], function($item) use ($titlesCommentsBd) {
        return !in_array($item["name"], $titlesCommentsBd);
    });

    if(count($result) !== 0) {
        $addComments = $orm->addComments($result);

        if($addComments["code"] !== 1) {
            die($addComments["message"]);
        }

        $countComment = $addComments["body"];
    }
}

echo "Загружено $countPost записей и $countComment комментариев";