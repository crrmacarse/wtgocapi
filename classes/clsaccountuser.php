<?php

    /*

        Diday / 10.1.1.11 - DMSX 

    */


    class clsAccountUser {
        private $tableName = 'AccountUser';
        private $connection;

        private $idAccountUser;
        private $unAccountUser;
        private $AUPassword;
        private $AULastName;
        private $AUFirstName;
        private $AUDateAdded;
        private $Status;
        private $AUGroup;
        private $AUAccessMIS;
        private $AUAccessReports;
        private $AUAccessQW;
        private $AUAccessCP;
        private $AUAccessOrderingGFC;
        private $AUAccessCMeal;
        private $AUAccessDTR;
        private $AUAccessCreditCard;
        private $AULastLogin;
        private $AUVersion;

        function setidAccountUser($idAccountUser){ $this->idAccountUser = $idAccountUser; }
        function getidAccountUser(){ return $this->idAccountUser; }
        function setunAccountUser($unAccountUser){ $this->unAccountUser = $unAccountUser; }
        function getunAccountUser(){ return $this->unAccountUser; }
        function setAUPassword($AUPassword){ $this->AUPassword = $AUPassword; }
        function getAUPassword(){ return $this->AUPassword; }
        function setAULastName($AULastName){ $this->AULastName; }
        function getAULastName(){ return $this->AULastName; }
        function setAUFirstName($AUFirstName){ $this->AUFirstName = $AUFirstName; }
        function getAUFirstName(){ return $this->AUFirstName; }
        function setAUDateAdded($AUDateAdded){ $this->AUDateAdded = $AUDateAdded; }
        function getAUDateAdded(){ return $this->AUDateAdded; }
        function setStatus($Status){ $this->Status = $Status; }
        function getStatus(){ return $this->Status; }
        function setAUGroup($AUGroup){ $this->AUGroup = $AUGroup; }
        function getAUGroup(){ return $this->AUGroup; }
        function setAUAccessMIS($AUAccessMIS){ $this->AUAccessMIS = $AUAccessMIS; }
        function getAUAccessMIS(){ return $this->$AUAccessMIS; }
        function setAUAccessReports($AUAccessReports){ $this->AUAccessReports = $AUAccessReports; }
        function getAUAccessReports(){ return $this->$AUAccessReports; }
        function setAUAccessQW($AUAccessQW){ $this->AUAccessQW = $AUAccessQW; }
        function getAUAccessQW(){ return $this->$AUAccessQW; }
        function setAUAccessCP($AUAccessCP){ $this->AUAccessCP = $AUAccessCP; }
        function getAUAccessCP(){ return $this->$AUAccessCP; }
        function setAUAccessOrderingGFC($AUAccessOrderingGFC){ $this->AUAccessOrderingGFC = $AUAccessOrderingGFC; }
        function getAUAccessOrderingGFC(){ return $this->$AUAccessOrderingGFC; }
        function setAUAccessCMeal($AUAccessCMeal){ $this->AUAccessCMeal = $AUAccessCMeal; }
        function getAUAccessCMeal(){ return $this->$AUAccessCMeal; }
        function setAUAccessDTR($AUAccessDTR){ $this->AUAccessDTR = $AUAccessDTR; }
        function getAUAccessDTR(){ return $this->$AUAccessDTR; }
        function setAUAccessCreditCard($AUAccessCreditCard){ $this->AUAccessCreditCard = $AUAccessCreditCard; }
        function getAUAccessCreditCard(){ return $this->$AUAccessCreditCard; }
        function setAULastLogin($AULastLogin){ $this->AULastLogin = $AULastLogin; }
        function getAULastLogin(){ return $this->$AULastLogin; }
        function setAUVersion($AUVersion){ $this->AUVersion = $AUVersion; }
        function getAUVersion(){ return $this->$AUVersion; }
        

        public function __construct() {
            $db = new dbConnect();
            $this->connection = $db->connect();
        } 

        public function getAllAccountUser() {
            $result = odbc_exec($this->connection, "SELECT * FROM " . $this->tableName);   
            $user = array();
            
            while($res = odbc_fetch_array($result)) {
                array_push($user, $res);
            }
        
            return $user;
        }

        public function getAccountUserById() {
            $sql = "SELECT * FROM '$this->tableName' WHERE idAccountUser = '$this->idAccountUser'";        
            $result = odbc_exec($this->connection, $sql);   
            $user = array();

            while($res = odbc_fetch_array($result)) {
                array_push($user, $res);
            }
        
            return $user;
        }

        public function getAccountUserByUser() {
            $sql = "SELECT * FROM $this->tableName WHERE unAccountUser = '$this->unAccountUser'";
            $result = odbc_exec($this->connection, $sql);   
            $user = array();

            while($res = odbc_fetch_array($result)) {
                array_push($user, $res);
            }
            
            return $user;
        }

        public function getAccessRightsByUser(){
            $sql = "SELECT
                            AUGroup,
                            AUAccessMIS,
                            AUAccessReports,
                            AUAccessQW,
                            AUAccessCP,
                            AUAccessOrderingGFC,
                            AUAccessCMeal,
                            AUAccessDTR,
                            AUAccessCreditCard
                    
                    '$this->tableName' 
                    
                    WHERE idAccountUser = '$this->idAccountUser'";

            $result = odbc_exec($this->connection, $sql);   
            $accessRights = array();

            while($res = odbc_fetch_array($result)) {
                array_push($accessRights, $res);
            }

            return $accessRights;
        }


    }

?>