<?php

class Database {

    private $user = "root";
    private $pwd = "";
    public $pdo;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:host=localhost:3306;dbname=banque',
                         $this->user,
                          $this->pwd);
        
    }
    /**
     * Get informations from Db
     *
     * @param string $statement
     * @param boolean $one
     */
    public function query($statement, $one = false){

        try {
            
            $statement = $this->pdo->query($statement, PDO::FETCH_OBJ);

            if ($one) {
                $data = $statement->fetch();
            } else {
                $data = $statement->fetchAll();
            }
            $this->sendData("Données récupérées", true, $data);

        } catch (\Throwable $th) {
            $this->sendData("Impossible de récupérer les données");
        }
    }

    /**
     * Create, update or delete informations in Db
     *
     * @param string $statement
     * @param string $action
     * @param array $param
     */
    public function prepare($statement, $action = "save",  $param = array())
    {
        try {
            $statement = $this->pdo->prepare($statement);
            $statement->execute($param);
            if ($action == "save") {
                $this->sendData("Enregistrement ok", true);
            } elseif ($action == "delete") {
                $this->sendData("Suppression ok", true);
            } elseif($action == "put"){
                $this->sendData("Modification ok", true);
            }
        } catch (\Throwable $th) {
            if ($action == "save") {
                $this->sendData("Erreur lors de l'enregistrement");
            } elseif ($action == "delete") {
                $this->sendData("Erreur lors de la suppression");
            } elseif($action == "put"){
                $this->sendData("Erreur lors de la modification");
            }
        }
    }

    /**
     * Send response to client
     *
     * @param string $message
     * @param boolean $success
     * @param array $data
     * @return void
     */
    private function sendData($message, $success= false, $data = array())
    {
        $result["success"] = $success;
        $result["message"] = $message;
        $result["data"] = $data;

        header('content-type:application/json');
        echo json_encode($result);

    }
}