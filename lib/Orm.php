<?php

namespace lib;

use PDOException;

class Orm {
    private $connect;
    private $table;

    function __construct($connect, $table) {
        $this->connect = $connect;
        $this->table = $table;
    }

    /** Получить список всех записей **/
    public function getList(): array {
        try {
            $sql = "SELECT * FROM $this->table";

            $stmt = $this->connect->prepare($sql);
            $stmt->execute();

            return [
              "code" => 1,
              "message" => "Успешно получили записи!",
              "body" => $stmt->fetchAll($this->connect::FETCH_ASSOC)
            ];
        }
        catch (PDOException $e) {
            return [
                "code" => 4011,
                "message" => "Ошибка в запросе на получение записей!",
                "body" => $e->getMessage()
            ];
        }
    }

    /** Получить список записей по строке **/
    public function findByString($string) {

    }

    /** Добавить новые записи в таблицу **/
    public function addPosts($posts): array {
        try {
            $sql = "INSERT INTO $this->table (USER_ID, TITLE, BODY) VALUES (:userId, :title, :body)";

            $this->connect->setAttribute($this->connect::ATTR_ERRMODE, $this->connect::ERRMODE_EXCEPTION);

            $stmt = $this->connect->prepare($sql);

            foreach($posts as $post) {
                $stmt->execute([
                    ':userId' => $post['userId'],
                    ':title' => $post['title'],
                    ':body' => $post['body']
                ]);
            }

            return [
                "code" => 1,
                "message" => "Успешно добавили посты!",
                "body" => count($posts)
            ];
        }
        catch (PDOException $e) {
            return [
                "code" => 4473,
                "message" => "Ошибка в запросе на добавление постов!",
                "body" => $e->getMessage()
            ];
        }
    }

    /** Добавить все данные в массив **/
    private function getArray($result): array {
        $data = [];

        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        return $data;
    }
}