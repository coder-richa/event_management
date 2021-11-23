<?php

include_once dirname(__FILE__) . '/../settings/site-settings.php';

/**
 * DBHelper class lists off the methods required to perform CRUD operations. 
 * 
 */
class DBHelper {
    /* Specifing the database details */

    protected $db_user = DB_USER;
    protected $db_password = DB_PASSWORD;
    protected $db_database = DB_NAME;
    protected $db_host = DB_HOST;
    protected $connectionObj;

    // open db connection
    function __construct() {
        try {
            $host = $this->db_host;
            $database = $this->db_database;
            $this->connectionObj = new PDO("mysql:host={$host };dbname={$database}", $this->db_user, $this->db_password);
        } catch (PDOException $exception) { //to handle connection error
            echo "Connection error: " . $exception->getMessage();
        }
    }

    // close db connection
    function __destruct() {
        $this->closeConnection();
    }

    function closeConnection() {
        try {
            $this->connectionObj = NULL;
        } catch (PDOException $exception) { //to handle connection error
//            echo "Connection error: " . $exception->getMessage();
        }
    }

    // returns db connection object
    public function getConnection() {

        return $this->connectionObj;
    }

    // return resultset of the select query
    public function select($query, $param = null) {
        $con = $this->getConnection();
        $stmt = $con->prepare($query);
        if (($param != null) && (count($param) > 0)) {

            for ($i = 0; $i < count($param); $i++) {
                $stmt->bindValue($i + 1, $param[$i]);
            }
        }
        $stmt->execute();

        return $stmt;
    }

// return primary id of the inserted record
    public function insert($query, $param = null) {
        $con = $this->getConnection();
        $stmt = $con->prepare($query);
        if (($param != null) && (count($param) > 0)) {

            for ($i = 0; $i < count($param); $i++) {
                $stmt->bindValue($i + 1, $param[$i]);
            }
        }
        $x = $stmt->execute();

        $y = $con->lastInsertId();
        return $y;
    }

// return number of rows affected of the update/delete query
    public function update_delete($query, $param = null) {
        $con = $this->getConnection();
        $stmt = $con->prepare($query);
        if (($param != null) && (count($param) > 0)) {

            for ($i = 0; $i < count($param); $i++) {
                $stmt->bindValue($i + 1, $param[$i]);
            }
        }
        $y = $stmt->execute();

        return $y;
    }

}

?>
