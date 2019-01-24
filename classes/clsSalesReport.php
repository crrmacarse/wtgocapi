<?php
    class clsSalesReport {

        private $tableName = 'TBLHouseHold';
        private $connection;
        
        private $idHousehold;
        private $idPurok;
        private $FLDMunicipalID;
        private $FLDPurokCode;
        private $FLDHouseholdCode;
        private $FLDHouseholdHead;
        private $FLDAreaType;
        private $FLDTotalPerson;
        private $FLDTotalCL;
        private $FLDTotalAtRisk;
        private $FLDTotalVulnerable;
        private $FLDHHRoleCode;
        private $FLDNumOfFamily;
        private $FLDTimeStamp;
        private $FLDLatitude;
        private $FLDLongitude;
        private $FLDStatus;
        
        
        function setIDHousehold($idHousehold){ $this->idHousehold = $idHousehold; }
        function getIDHousehold(){ return $this->idHousehold; }
        function setIDPurok($idPurok){ $this->idPurok = $idPurok; }
        function getIDPurok(){ return $this->idPurok; }
        function setFLDMunicipalID($FLDMunicipalID){ $this->FLDMunicipalID = $FLDMunicipalID; }
        function getFLDMunicipalID(){ return $this->FLDMunicipalID; }
        function setFLDPurokCode($FLDPurokCode){ $this->FLDPurokCode = $FLDPurokCode; }
        function getFLDPurokCode(){ return $this->FLDPurokCode; }
        function setFLDHouseholdCode($FLDHouseholdCode){ $this->FLDHouseholdCode = $FLDHouseholdCode; }
        function getFLDHouseholdCode(){ return $this->FLDHouseholdCode; }
        function setFLDAreaType($FLDAreaType){ $this->FLDAreaType = $FLDAreaType; }
        function getFLDAreaType(){ return $this->FLDAreaType; }
        function setFLDTotalPerson($FLDTotalPerson){ $this->FLDTotalPerson = $FLDTotalPerson; }
        function getFLDTotalPerson(){ return $this->FLDTotalPerson; }
        function setFLDTotalCL($FLDTotalCL){ $this->FLDTotalCL = $FLDTotalCL; }
        function getFLDTotalCL(){ return $this->FLDTotalCL; }
        function setFLDTotalAtRisk($FLDTotalAtRisk){ $this->FLDTotalAtRisk = $FLDTotalAtRisk; }
        function getFLDTotalAtRisk(){ return $this->FLDTotalAtRisk; }
        function setFLDTotalVulnerable($FLDTotalVulnerable){ $this->FLDTotalVulnerable = $FLDTotalVulnerable; }
        function getFLDTotalVulnerable(){ return $this->FLDTotalVulnerable; }
        function setFLDHHRoleCode($FLDHHRoleCode){ $this->FLDHHRoleCode = $FLDHHRoleCode; }
        function getFLDHHRoleCode(){ return $this->FLDHHRoleCode; }
        function setFLDNumOfFamily($FLDNumOfFamily){ $this->FLDNumOfFamily = $FLDNumOfFamily; }
        function getFLDNumOfFamily(){ return $this->FLDNumOfFamily; }
        function setFLDTimeStamp($FLDTimeStamp){ $this->FLDTimeStamp = $FLDTimeStamp; }
        function getFLDTimeStamp(){ return $this->FLDTimeStamp; }
        function setFLDLatitude($FLDLatitude){ $this->FLDLatitude = $FLDLatitude; }
        function getFLDLatitude(){ return $this->FLDLatitude; }
        function setFLDLongitude($FLDLongitude){ $this->FLDLongitude = $FLDLongitude; }
        function getFLDLongitude(){ return $this->FLDLongitude; }
        function setFLDStatus($FLDStatus){ $this->FLDStatus = $FLDStatus; }
        function getFLDStatus(){ return $this->FLDStatus; }  
        
        public function __construct() {
			$db = new dbConnect();
			$this->dbConn = $db->connect();
        }
        
        public function getAllHousehold() {
			$stmt = $this->dbConn->prepare("SELECT * FROM " . $this->tableName);
			$stmt->execute();
			$hoseholds = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $hoseholds;
        }

        public function getHouseholdById() {
            $stmt = $this->dbConn->prepare("SELECT * FROM " . $this->tableName . " WHERE idHousehold = :idHousehold");
            $stmt->bindParam(':idHousehold',$this->idHousehold);
            $stmt->execute();
            $household = $stmt->fetch(PDO::FETCH_ASSOC);
            return $household;
        }

        public function getAllHoouseholdMapDetails() {
            $stmt = $this->dbConn->prepare("SELECT FLDHouseholdHead, FLDHouseholdCode, FLDLongitude, FLDLatitude
            FROM " . $this->tableName);
            $stmt->execute();
            $householdMapDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return householdMapDetails;
        }

        public function getHouseholdCoordById() { 
            $stmt = $this->dbConn->prepare("SELECT FLDLongitude, FLDLatitude FROM " . $this->tableName . " 
            WHERE idHousehold = :idHousehold");
            $stmt->bindParam('idHousehold');
            $stmt->execute();
            $householdCoord = $stmt->fetch(PDO::FETCH_ASSOC);
            return $householdCoord; 
        }

        /*

        public function insertHousehold() {
            ...
        }

        public function updateHousehold() {
            ...
        }

        */

        public function deleteHousehold() {
            $stmt = $this->dbConn->prepare("DELETE FROM " . $this->tableName . " WHERE idHousehold = :idHousehold"); 
            $stmt->bindParam(':idHousehold', $this->idHousehold);
            if($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }
        
    }

?>