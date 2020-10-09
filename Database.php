<?php

class Database{
    private $user = "root";
    private $pwd = "";
    public $pdo;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:host=localhost:3306;dbname=banque',
                         $this->user,
                          $this->pwd);
    }
}