<?php
require_once "../config/config.php";

try {
    // Создаем подключение к базе данных
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);

    // SQL-запрос для создания таблицы POSTS
    $sqlPosts = "CREATE TABLE IF NOT EXISTS POSTS (
        ID INT AUTO_INCREMENT PRIMARY KEY,
        USER_ID INT NOT NULL,
        TITLE VARCHAR(255) NOT NULL,
        BODY TEXT NOT NULL
    );";

    // SQL-запрос для создания таблицы COMMENTS
    $sqlComments = "CREATE TABLE IF NOT EXISTS COMMENTS (
        ID INT AUTO_INCREMENT PRIMARY KEY,
        POST_ID INT NOT NULL,
        NAME VARCHAR(100) NOT NULL,
        EMAIL VARCHAR(100) NOT NULL,
        BODY TEXT NOT NULL,
        FOREIGN KEY (POST_ID) REFERENCES POSTS(ID) ON DELETE CASCADE
    );";

    // Выполняем запросы
    $pdo->exec($sqlPosts);
    $pdo->exec($sqlComments);

    echo "Таблицы успешно созданы!";
}
catch (PDOException $e) {
    echo "Ошибка подключения: " . $e->getMessage();
}