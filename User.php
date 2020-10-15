<?php

use \Firebase\JWT\JWT;

require "General.php";

class User extends General{

    protected $table = __CLASS__;

    /**
     * Client connexion
     *
     * @param array $param
     */
    public function connexion($param)
    {
        $statement = ("SELECT * FROM user WHERE email='". $param["email"] ."'");
        $user = $this->db->queryReturn($statement, true);
        if (password_verify($param["password"], $user["password"])) {
            $key = "demo";
            $payload = array(
                "exp" => time() * 1200,
                "id" => $user["id"]
            );
            $token = JWT::encode($payload, $key);
            $this->db->sendData("connexion ok", true, $token);
        }
    }

    /**
     * Save client in Db
     *
     * @param array $param
     */
    public function save($param){
        $statement = "INSERT INTO $this->table (nom, prenom, mail, pass) 
                        VALUES (:nom, :prenom, :mail, :pass)";

        $param["pass"] = password_hash($param["pass"], PASSWORD_DEFAULT);

        $this->db->prepare($statement, "save", $param);
    }
}