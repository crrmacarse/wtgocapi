<?php
    namespace Classes\Cmeal;

    use Classes\dbConnect as dbConnect;
    
    /*
        Diday / 10.1.1.11 - Masterlist 
    */

    class clsCmealUser {
        
        private $tableName = "TblCMealUser";
        private $connection;

        private $FLDCMUID;
        private $FLDCMUCID;
        private $FLDCMULastName;
        private $FLDCMUFirstName;
        private $FLDCMUMiddleName;
        private $FLDCMUSuffix;
        private $FLDCMUFullName;
        private $FLDCMUPassword;
        private $FLDCMUMember;
        private $FLDCMUPosition;
        private $FLDCMUStatus;
        private $FLDCMUCreditLimit;
        private $FLDCMUCreditRemaining;
        private $FLDMLLOWCreditLimit;
        private $FLDMLLOWCreditRemaining;
        private $FLDLevel;
        private $FLDCMUSerial;
        private $FLDCMUMacAddress;
        private $FLDCMUSessionId;        
        

        function setFLDCMUID($FLDCMUID){ $this->FLDCMUID = $FLDCMUID; }
        function getFLDCMUID(){ return $this->FLDCMUID; }
        function setFLDCMUCID($FLDCMUCID){ $this->FLDCMUCID = $FLDCMUCID; }
        function getFLDCMUCID(){ return $this->FLDCMUCID; }
        function setFLDCMULastName($FLDCMULastName){ $this->FLDCMULastName = $FLDCMULastName; }
        function getFLDCMULastName(){ return $this->FLDCMULastName; }
        function setFLDCMUFirstName($FLDCMUFirstName){ $this->FLDCMUFirstName = $FLDCMUFirstName; }
        function getFLDCMUFirstName($FLDCMUFirstName){ $this->FLDCMUFirstName; }
        function setFLDCMUMiddleName($FLDCMUMiddleName){ $this->FLDCMUMiddleName = $FLDCMUMiddleName; }
        function getFLDCMUMiddleName(){ return $this->FLDCMUMiddleName; } 
        function setFLDCMUSuffix($FLDCMUSuffix){ $this->FLDCMUSuffix = $FLDCMUSuffix; }
        function getFLDCMUSuffix(){ return $this->FLDCMUSuffix; }
        function setFLDCMUFullName($FLDCMUFullName){ $this->FLDCMUFullName = $FLDCMUFullName; }
        function getFLDCMUFullName(){ return $this->FLDCMUFullName; }
        function setFLDCMUPassword($FLDCMUPassword){ $this->FLDCMUPassword = $FLDCMUPassword; }
        function getFLDCMUPassword(){ return $this->FLDCMUPassword; }
        function setFLDCMUMember($FLDCMUMember){ $this->FLDCMUMember = $FLDCMUMember; }
        function getFLDCMUMember(){ return $this->$FLDCMUMember; }
        function setFLDCMUPosition($FLDCMUPosition){ $this->FLDCMUPosition = $FLDCMUPosition; }
        function getFLDCMUPosition(){ return $this->$FLDCMUPosition; }
        function setFLDCMUStatus($FLDCMUStatus){ $this->FLDCMUStatus = $FLDCMUStatus; }
        function getFLDCMUStatus(){ return $this->$FLDCMUStatus; }
        function setFLDCMUCreditLimit($FLDCMUCreditLimit){ $this->FLDCMUCreditLimit = $FLDCMUCreditLimit; }
        function getFLDCMUCreditLimit(){ return $this->$FLDCMUCreditLimit; }
        function setFLDCMUCreditRemaining($FLDCMUCreditRemaining){ $this->FLDCMUCreditRemaining = $FLDCMUCreditRemaining; }
        function getFLDCMUCreditRemaining(){ return $this->$FLDCMUCreditRemaining; }
        function setFLDMLLOWCreditLimit($FLDMLLOWCreditLimit){ $this->FLDMLLOWCreditLimit = $FLDMLLOWCreditLimit; }
        function getFLDMLLOWCreditLimit(){ return $this->$FLDMLLOWCreditLimit; }
        function setFLDMLLOWCreditRemaining($FLDMLLOWCreditRemaining){ $this->FLDMLLOWCreditRemaining = $FLDMLLOWCreditRemaining; }
        function getFLDMLLOWCreditRemaining(){ return $this->$FLDMLLOWCreditRemaining; }
        function setFLDLevel($FLDLevel){ $this->FLDLevel = $FLDLevel; }
        function getFLDLevel(){ return $this->$FLDLevel; }
        function setFLDCMUSerial($FLDCMUSerial){ $this->FLDCMUSerial = $FLDCMUSerial; }
        function getFLDCMUSerial(){ return $this->$FLDCMUSerial; }
        function setFLDCMUMacAddress($FLDCMUMacAddress){ $this->FLDCMUMacAddress = $FLDCMUMacAddress; }
        function getFLDCMUMacAddress(){ return $this->$FLDCMUMacAddress; }
        function setFLDCMUSessionId($FLDCMUSessionId){ $this->FLDCMUSessionId = $FLDCMUSessionId; }
        function getFLDCMUSessionId(){ return $this->$FLDCMUSessionId; }
        
        public function __construct() {
            $db = new dbConnect();
            $db->setDidayDatabase("Masterlist");
            
            $this->connection = $db->connectDiday();
        }

        public function getAllCmealUser() {
                $sql = "SELECT
                    
                            FLDCMUID,
                            FLDCMUCID,
                            FLDCMULastName,
                            FLDCMUFirstName,
                            FLDCMUMiddleName,
                            FLDCMUSuffix,
                            FLDCMUFullName,
                            FLDCMUMember,
                            FLDCMUPosition,
                            FLDCMUStatus,
                            FLDCMUCreditLimit,
                            FLDCMUCreditRemaining,
                            FLDMLLOWCreditLimit,
                            FLDMLLOWCreditRemaining,
                            FLDLevel,
                            FLDCMUSerial,
                            FLDCMUMacAddress,
                            FLDCMUSessionId 
                        
                        FROM " . $this->tableName;

                $result = odbc_exec($this->connection, $sql);  
                $user = array();
                
                while($res = odbc_fetch_array($result)) {
                    array_push($user, $res);
                }
            
                return $user;    
        }
        
    }
?>