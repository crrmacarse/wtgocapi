<?php
    namespace Classes;
    
    /*

        Database Connection

    */

    require_once(dirname(__DIR__).'/config/constants.php');

    class dbConnect {

        // DIDAY
        private $didayserver = DIDAY_SERVER;
        private $didayport = DIDAY_PORT;
        private $didayusername = DIDAY_USERNAME;
        private $didaypassword = DIDAY_PASSWORD;
        private $didaydbname;

        // Pam2x
        private $pampamserver = PAMPAM_SERVER;
        private $pampamport = PAMPAM_PORT;
        private $pampamusername = PAMPAM_USERNAME;
        private $pampampassword = PAMPAM_PASSWORD;
        private $pampamdbname;

        // Lampugak
        private $lampugakserver = LAMPUGAK_SERVER;
        private $lampugakusername = LAMPUGAK_USERNAME;
        private $lampugakpassword = LAMPUGAK_PASSWORD;
        private $lampugakdbname;

        // Hostgator
        private $hostgatorserver = HOSTGATOR_SERVER;
        private $hostgatorusername = HOSTGATOR_USERNAME;
        private $hostgatorpassword = HOSTGATOR_PASSWORD;
        private $hostgatordbname;

        function setDidayServer($didayserver){ $this->didayserver = $didayserver; }
        function setDidayPort($didayport){ $this->didayport = $didayport; }
        function setDidayDatabase($didaydbname){ $this->didaydbname = $didaydbname; }
        function setDidayUsername($didayusername){ $this->didayusername = $didayusername; }
        function setDidayPassword($didaypassword){ $this->didaypassword = $didaypassword; }

        function setPampamServer($pampamserver){ $this->pampamserver = $pampamserver; }
        function setPampamPort($pampamport){ $this->pampamport = $pampamport; }
        function setPampamDatabase($pampamdbname){ $this->pampamdbname = $pampamdbname; }
        function setPampamUsername($pampamusername){ $this->pampamusername = $pampamusername; }
        function setPampamPassword($pampampassword){ $this->pampampassword = $pampampassword; }

        function setLampugakServer($lampugakserver){ $this->lampugakserver = $lampugakserver; }
        function setLampugakPort($lampugakport){ $this->lampugakport = $lampugakport; }
        function setLampugakDatabase($lampugakdbname){ $this->lampugakdbname = $lampugakdbname; }
        function setLampugakUsername($lampugakusername){ $this->lampugakusername = $lampugakusername; }
        function setLampugakPassword($lampugakpassword){ $this->lampugakpassword = $lampugakpassword; }

        function setHostgatorServer($hostgatorserver){ $this->hostgatorserver = $hostgatorserver; }
        function setHostgatorPort($hostgatorport){ $this->hostgatorport = $hostgatorport; }
        function setHostgatorDatabase($hostgatordbname){ $this->hostgatordbname = $hostgatordbname; }
        function setHostgatorUsername($hostgatorusername){ $this->hostgatorusername = $hostgatorusername; }
        function setHostgatorPassword($hostgatorpassword){ $this->hostgatorpassword = $hostgatorpassword; }

        public function connectDiday(){
            try {
                $conn = odbc_connect('Driver=FreeTDS;Server=' . $this->didayserver . ';Port='. $this->didayport .';Database='. $this->didaydbname , $this->didayusername , $this->didaypassword);
                
                return $conn;
            } catch (\Exception $e){
                die('Database Error: ' . $e->getMessage());
            }
        }

        public function connectPampam(){
            try {
                $conn = odbc_connect('Driver=FreeTDS;Server=' . $this->pampamserver . ';Port='. $this->pampamport .';Database='. $this->pampamdbname , $this->pampamusername , $this->pampampassword);
                
                return $conn;
            } catch (\Exception $e){
                die('Database Error: ' . $e->getMessage());
            }
        }

        public function connectLampugak() {
            try {
                $conn = new \PDO('mysql:host=' . $this->lampugakserver . ';dbname='. $this->lampugakdbname , $this->lampugakusername , $this->lampugakpassword);
                $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

                return $conn;
            } catch (\Exception $e){
                die('Database Error: ' . $e->getMessage());
            }
        }

        public function connectHostgator() {
            try {
                $conn = new \PDO('mysql:host=' . $this->hostgatorserver . ';dbname='. $this->hostgatordbname , $this->hostgatorusername , $this->hostgatorpassword);
                $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

                return $conn;
            } catch (\Exception $e){
                die('Database Error: ' . $e->getMessage());
            }
        }

    }

?>