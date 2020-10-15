<?php

// require "Database.php";

class General {

    /**
     * Db connexion
     *
     * @var Database
     */
    protected $db;

    /**
     * Class in use
     *
     * @var string
     */
    protected $table;

    public function __construct()
    {
        $this->db = new Database();
        $this->table = strtolower($this->table);
    }

    /**
     * Get all informations from Db
     *
     */
    public function getAll()
    {
        $this->db->query("SELECT * FROM $this->table");
    }

    /**
     * Gat information from Db
     *
     * @param int $id
     */
    public function getOne($id)
    {
        $this->db->query(
            "SELECT * FROM $this->table 
            WHERE id = " . $id, true);
    }

    /**
     * Save new categorie in Db
     *
     * @param array $param
     */
    public function save($param)
    {
        $statement = "INSERT INTO $this->table (";
        $values = " VALUES (";
        foreach ($param as $key => $value) {
            $statement .= $key.", ";
            $values .= ":".$key. ", ";
        }
        $statement = substr($statement, 0, -2) .") ";
        $values = substr($values, 0, -2);
        $statement .= $values. ")";

        $this->db->prepare($statement, "save", $param);
    }

    /**
     * Delete a categorie line in Db
     *
     * @param int $id
     */
    public function delete($id)
    {
        $statement = "DELETE FROM $this->table where id=".$id;
        $this->db->prepare($statement);
    }

    /**
     * Modify a category line in Db
     *
     * @param int $id
     * @param array $param
     */
    public function put($id, $param)
    {
        $champs = explode(",", $param);
        $data = array();
        $statement = "UPDATE $this->table SET ";
        foreach ($champs as $value) {
            $line = explode(':', $value);
            $data[$line[0]] = $line[1];
            $statement .= $line[0]."=".$line[1].", ";
        }
        $statement = substr($statement, 0, -2);
        $statement .= " WHERE id=$id";
        $this->db->prepare($statement, "put", $data);
    }
}