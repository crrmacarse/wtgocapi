<?php
    
    /*

        Database Connection

    */

    require_once(dirname(__DIR__).'/config/constants.php');

    class dbConnect {

        private $dbserver = DB_SERVER;
        private $dbport = DB_PORT;
        private $dbname = DB_DBNAME;
        private $dbusername = DB_USERNAME;
        private $dbpassword = DB_PASSWORD;

        public function connect(){
            try {
                $conn = new PDO('odbc:host=' . $this->dbserver . ';dbname='. $this->database , $this->dbusername , $this->dbpassword);
                $conn = new PDO('odbc:Driver=FreeTDS;Server=' . $this->dbserver . ';Port='. $this->dbport .';Database='. $this->dbname , $this->dbusername , $this->dbpassword);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                return $conn;
            } catch (Exception $e){
                die('Database Error: ' . $e->getMessage());
            }
        }

        public function changeDB($database){
            try {
                $conn = new PDO('sqlsrv:Server=' . $this->dbserver . ';Database='. $this->database , $this->dbusername , $this->dbpassword);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                return $conn;
            } catch (Exception $e){
                $this->throwError(HTTP_NOT_IMPLEMENTED, "Database Change Error. Database doesn't seem to exist");
            }
        }
    }

?>