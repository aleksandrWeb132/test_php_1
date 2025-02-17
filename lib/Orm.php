<?php

namespace lib;

class Orm {
    private $connect;
    private $table;

    function __construct($connect, $table) {
        $this->connect = $connect;
        $this->table = $table;
    }

    /** Получить список всех записей **/
    public function getList() {

    }

    /** Получить список записей по строке **/
    public function findByString($string) {

    }

    /** Добавить новые записи в таблицу **/
    public function add($id, $params) {

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