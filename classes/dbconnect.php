<?php
    namespace Classes;
    
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

        private $dblocalmysqlserver = DB_LOCAL_MYSQL_SERVER;
        private $dblocalmysqlname = DB_LOCAL_MYSQL_DBNAME;
        private $dblocalmysqlusername = DB_LOCAL_MYSQL_USERNAME;
        private $dblocalmysqlpassword = DB_LOCAL_MYSQL_PASSWORD;

        public function connect(){
            try {
                $conn = odbc_connect('Driver=FreeTDS;Server=' . $this->dbserver . ';Port='. $this->dbport .';Database='. $this->dbname , $this->dbusername , $this->dbpassword);
                // $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                return $conn;
            } catch (Exception $e){
                die('Database Error: ' . $e->getMessage());
            }
        }

        public function connectDiday($database){
            try {
                $conn = odbc_connect('Driver=FreeTDS;Server=' . $this->dbserver . ';Port='. $this->dbport .';Database='. $connectDiday , $this->dbusername , $this->dbpassword);
                // $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                return $conn;
            } catch (Exception $e){
                die('Database Error: ' . $e->getMessage());
            }
        }

        public function connectTo($database){
            try {
                $conn = new PDO('sqlsrv:Server=' . $this->dbserver . ';Database='. $this->database , $this->dbusername , $this->dbpassword);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                return $conn;
            } catch (Exception $e){
                $this->throwError(HTTP_NOT_IMPLEMENTED, "Database Change Error. Database doesn't seem to exist");
            }
        }

        public function connectMySQL($db) {
            try {
                $conn = new PDO('mysql:host=' . $this->dblocalmysqlserver . ';dbname='. $db , $this->dblocalmysqlusername , $this->dblocalmysqlpassword);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                return $conn;
            } catch (Exception $e){
                die('Database Error: ' . $e->getMessage());
            }
        }

    }

?>