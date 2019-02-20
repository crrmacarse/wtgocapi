<?php
    namespace Classes;
    
    /*

        Database Connection

    */

    require_once(dirname(__DIR__).'/config/constants.php');

    class dbConnect {

        // seperate as $dbSQL and $dbMYSQL soon
        
        private $dbserver = DB_SERVER;
        private $dbport = DB_PORT;
        private $dbname;
        private $dbusername = DB_USERNAME;
        private $dbpassword = DB_PASSWORD;

        private $dbmysqlserver = DB_LOCAL_MYSQL_SERVER;
        private $dbmysqldbname = DB_LOCAL_MYSQL_DBNAME;
        private $dbmysqlusername = DB_LOCAL_MYSQL_USERNAME;
        private $dbmysqlpassword = DB_LOCAL_MYSQL_PASSWORD;

        function setDidayServer($dbserver){ $this->dbserver = $dbserver; }
        function setDidayPort($dbport){ $this->dbport = $dbport; }
        function setDidayDatabase($dbname){ $this->dbname = $dbname; }
        function setDidayUsername($dbusername){ $this->dbusername = $dbusername; }
        function setDidayPassword($dbpassword){ $this->dbpassword = $dbpassword; }

        function setMYSQLServer($dbmysqlserver){ $this->dbserver = $dbmysqlserver; }
        function setMYSQLDatabase($dbmysqldbname){ $this->dbmysqldbname = $dbmysqldbname; }
        function setMYSQLUsername($dbmysqlusername){ $this->dbmysqlusername = $dbmysqlusername; }
        function setMYSQLPassword($dbmysqlpassword){ $this->dbmysqlpassword = $dbmysqlpassword; }

        public function connect(){
            try {
                $conn = odbc_connect('Driver=FreeTDS;Server=' . $this->dbserver . ';Port='. $this->dbport .';Database='. $this->dbname , $this->dbusername , $this->dbpassword);
                
                return $conn;
            } catch (\Exception $e){
                die('Database Error: ' . $e->getMessage());
            }
        }

        public function connectSQL(){
            try {
                $conn = odbc_connect('Driver=FreeTDS;Server=' . $this->dbserver . ';Port='. $this->dbport .';Database='. $this->dbname , $this->dbusername , $this->dbpassword);
                
                return $conn;
            } catch (\Exception $e){
                die('Database Error: ' . $e->getMessage());
            }
        }

        public function connectTo(){
            try {
                $conn = new PDO('sqlsrv:Server=' . $this->dbserver . ';Database='. $this->database , $this->dbusername , $this->dbpassword);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                return $conn;
            } catch (\Exception $e){
                $this->throwError(HTTP_NOT_IMPLEMENTED, "Database Change Error. Database doesn't seem to exist");
            }
        }

        public function connectMySQL() {
            try {
                $conn = new PDO('mysql:host=' . $this->dbmysqlserver . ';dbname='. $dbmysqldbname , $this->dbmysqlusername , $this->dbmysqlpassword);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                return $conn;
            } catch (\Exception $e){
                die('Database Error: ' . $e->getMessage());
            }
        }

    }

?>