<?php
    namespace Classes\DIDAY;

    use Classes\dbConnect as dbConnect;
    
    /*
        Diday / 10.1.1.11 - DMSX 
    */
    class clsBusinessUnit {
        
        private $tableName = 'BusinessUnit';
        private $connection;
        private $idStore;
        private $idBusinessUnit;
        private $BUCode;
        private $BUName;
        private $SBranchName;
        private $SPOSBranchName;
        private $SAPWhsCode;
        private $SAPCardCode;
        private $SOpen;
        private $SInternet;
        private $SDatabase;
        private $SPOSServer;
        private $SPOSServerLocal;
        private $SPOSPortSQL;
        private $SPOSUsername;
        private $SPOSPassword;
        private $SPOSDatabase;
        function setidStore($idStore){ $this->idStore = $idStore; }
        function getidStore(){ return $this->idStore; }
        function setidBusinessUnit($idBusinessUnit){ $this->idBusinessUnit = $idBusinessUnit; }
        function getidBusinessUnit(){ return $this->unAccountUser; }
        function setBUCode($BUCode){ $this->BUCode = $BUCode; }
        function getBUCode(){ return $this->BUCode; }
        function setBUName($BUName){ $this->BUName = $BUName; }
        function getBUName($BUName){ $this->BUName; }
        function setSBranchName($SBranchName){ $this->SBranchName = $SBranchName; }
        function getSBranchName(){ return $this->SBranchName; } 
        function setSPOSBranchName($SPOSBranchName){ $this->SPOSBranchName = $SPOSBranchName; }
        function getSPOSBranchName(){ return $this->SPOSBranchName; }
        function setSAPWhsCode($SAPWhsCode){ $this->SAPWhsCode = $SAPWhsCode; }
        function getSAPWhsCode(){ return $this->SAPWhsCode; }
        function setSAPCardCode($SAPCardCode){ $this->SAPCardCode = $SAPCardCode; }
        function getSAPCardCode(){ return $this->SAPCardCode; }
        function setSOpen($SOpen){ $this->SOpen = $SOpen; }
        function getSOpen(){ return $this->$SOpen; }
        function setSInternet($SInternet){ $this->SInternet = $SInternet; }
        function getSInternet(){ return $this->$SInternet; }
        function setSDatabase($SDatabase){ $this->SDatabase = $SDatabase; }
        function getSDatabase(){ return $this->$SDatabase; }
        function setSPOSServer($SPOSServer){ $this->SPOSServer = $SPOSServer; }
        function getSPOSServer(){ return $this->$SPOSServer; }
        function setSPOSServerLocal($SPOSServerLocal){ $this->SPOSServerLocal = $SPOSServerLocal; }
        function getSPOSServerLocal(){ return $this->$SPOSServerLocal; }
        function setSPOSPortSQL($SPOSPortSQL){ $this->SPOSPortSQL = $SPOSPortSQL; }
        function getSPOSPortSQL(){ return $this->$SPOSPortSQL; }
        function setSPOSUsername($SPOSUsername){ $this->SPOSUsername = $SPOSUsername; }
        function getSPOSUsername(){ return $this->$SPOSUsername; }
        function setSPOSPassword($SPOSPassword){ $this->SPOSPassword = $SPOSPassword; }
        function getSPOSPassword(){ return $this->$SPOSPassword; }
        function setSPOSDatabase($SPOSDatabase){ $this->SPOSDatabase = $SPOSDatabase; }
        function getSPOSDatabase(){ return $this->$SPOSDatabase; }
        
        public function __construct() {
            $db = new dbConnect();
            $db->setDidayDatabase("DMSX");
            
            $this->connection = $db->connectDiday();
        } 
        public function getAllStore() {
            $result = odbc_exec($this->connection, "SELECT * FROM " . $this->tableName);   
            $stores = array();
            
            while($res = odbc_fetch_array($result)) {
                array_push($stores, $res);
            }
        
            return $stores;
        }
        public function getStoreById() {
            $sql = "SELECT * FROM $this->tableName WHERE idStore = $this->idStore";        
            $result = odbc_exec($this->connection, $sql);   
            $store = array();
            while($res = odbc_fetch_array($result)) {
                array_push($store, $res);
            }
        
            return $store;
        }
        public function getStoreByBUCode() {
            $sql = "SELECT * FROM $this->tableName WHERE BUCode = '$this->BUCode'";
            $result = odbc_exec($this->connection, $sql);   
            $stores = array();
            while($res = odbc_fetch_array($result)) {
                array_push($stores, $res);
            }
            
            return $stores;
        }
        public function getStoreByBUSAPCardCode() {
            $sql = "SELECT * FROM $this->tableName WHERE SAPCardCode = '$this->SAPCardCode'";
            $result = odbc_exec($this->connection, $sql);  
            $store = array();
            while($res = odbc_fetch_array($result)) {
                array_push($store, $res);
            }
            
            return $store;
        }
    }
?>