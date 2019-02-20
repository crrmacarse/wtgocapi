<?php
    namespace Classes;

    use Classes\Cmeal\clsCmealUser as clsCmealUser;
    
    use Classes\Diday\clsAccountUser as clsAccountUser;
    use Classes\Diday\clsBusinessUnit as clsBusinessUnit;
    use Classes\Diday\clsStore as clsStore;
    use Classes\Diday\clsReports as clsReports;
    
    class Api extends \Classes\Rest {

        public function __construct() {
            // triggers parent class(extended class)
            parent::__construct();
        }

        public function generateToken() {
            $username = odbc_escape_string_access($this->validateParameter('username', $this->param['username'], STRING));
            $password = odbc_escape_string_access(encryptPassword($this->validateParameter('password', $this->param['password'], STRING)));
            
            $this->checkLoginAttempt($username);
                    
            try {
                $sql = "SELECT 
                                        
                idAccountUser,
                unAccountUser,
                AUFirstName,
                AULastName,
                AUPassword,
                [Status]

                FROM AccountUser
                
                WHERE unAccountUser = '$username' AND AUPassword = '$password'";
                $result = odbc_exec($this->connection, $sql);   
                $user = odbc_fetch_array($result);

                /*
                    VLUNERABLE TO SQL INJUECTION:
                    {
                        "name":"generateToken",
                        "param":{
                            "username":"1' or 1=1 -- -",
                            "password":"bl"
                        }
                    }
                */

                // Check if database has a response from user log-in
                if(!$user) {
                    $this->writeLoginAttempt($username);
                    
                    $this->returnResponse(HTTP_BAD_REQUEST, 'Email or Password is incorrect.');
                }

                // Check if user status is still active
                if( $user['Status'] == 0) {
                    $this->returnResponse(HTTP_NOT_ACCEPTABLE, 'User is not activated. Please contact the administrator');
                }

                // creates a standard jwt payload
                $payload = 
                    array(
                     "iat" => time(),
                     "iss" => "localhost",
                     "exp" => time() + (5*60),
                     "userId" => $user["idAccountUser"]
                  )
                ;

                // calls jwt.php encode function
                $token = JWT::encode(json_encode($payload), JWT_SECRET_KEY);
                // success response 
                $data = array('token' => $token);
                $this->returnResponse(HTTP_OK, $data);
            } catch (\Exception $e) {
                $this->throwError(HTTP_UNPROCESSABLE_ENTITY, $e->getMessage());
            }

        }

        /* 
                10.1.1.11 - DMSX's AccountUser Table API
        */

        public function getAllAccountUser() {
            $AccountUser = new clsAccountUser;
            $data = $AccountUser->getAllAccountUser();
            if(!data){
                $this->returnResponse(HTTP_NO_CONTENT, array('message' => 'No Content found'));
            }
            $this->returnResponse(HTTP_OK, $data);
        }

        public function getAccountUserById() {
            $idAccountUser = $this->validateParameter('idAccountUser', $this->param['idAccountUser'], INTEGER);
            
            $AccountUser = new clsAccountUser;
            $AccountUser->setidAccountUser($idAccountUser);
            $data = $AccountUser->getAccountUserById();
            if(!$data) {
                $this->returnResponse(HTTP_NO_CONTENT, array('message' => 'No Content found.'));
            }
            
            $this->returnResponse(HTTP_OK, $data);
        }

        public function getAccountUserByUser() {
            $unAccountUser = $this->validateParameter('unAccountUser', $this->param['unAccountUser'], STRING);
            
            $AccountUser = new clsAccountUser;
            $AccountUser->setunAccountUser($unAccountUser);
            $data = $AccountUser->getAccountUserByUser();
            if(!$data) {
                $this->returnResponse(HTTP_NO_CONTENT, array('message' => 'No Content found.'));
            }
            
            $this->returnResponse(HTTP_OK, $data);
        }

        public function getAccountUserByGroup() {
            $AUGroup = $this->validateParameter('AUGroup', $this->param['AUGroup'], STRING);
            
            $AccountUser = new clsAccountUser;
            $AccountUser->setAUGroup($AUGroup);
            $data = $AccountUser->getAccountUserByGroup();
            if(!$data) {
                $this->returnResponse(HTTP_NO_CONTENT, array('message' => 'No Content found.'));
            }
            
            $this->returnResponse(HTTP_OK, $data);
        }

        public function getAccessRightsByUser() {
            $idAccountUser = $this->validateParameter('idAccountUser', $this->param['idAccountUser'], INTEGER);
            
            $AccountUser = new clsAccountUser;
            $AccountUser->setidAccountUser($idAccountUser);
            $data = $AccountUser->getAccessRightsByUser();
            if(!$data) {
                $this->returnResponse(HTTP_NO_CONTENT, array('message' => 'No Content found.'));
            }
            
            $this->returnResponse(HTTP_OK, $data);
        }

        /* 
            10.1.1.11 - DMSX's Store Table API
        
        */

        public function getAllStore() {
            $Store = new clsStore;
            $data = $Store->getAllStore();
            if(!$data) {
                $this->returnResponse(HTTP_NO_CONTENT, array('message' => 'No Content found.'));
            }
            
            $this->returnResponse(HTTP_OK, $data);
        }

        public function getStoreById() {
            $idStore = $this->validateParameter('idStore', $this->param['idStore'], INTEGER);
            
            $Store = new clsStore;
            $Store->setidStore($idStore);
            $data = $Store->getStoreById();
            if(!$data) {
                $this->returnResponse(HTTP_NO_CONTENT, array('message' => 'No Content found.'));
            }
            
            $this->returnResponse(HTTP_OK, $data);
        }

        public function getStoreByBUCode() {
            $BUCode = $this->validateParameter('BUCode', $this->param['BUCode'], STRING);
            
            $Store = new clsStore;
            $Store->setBUCode($BUCode);
            $data = $Store->getStoreByBUCode();
            if(!$data) {
                $this->returnResponse(HTTP_NO_CONTENT, array('message' => 'No Content found.'));
            }
            
            $this->returnResponse(HTTP_OK, $data);
        }

        public function getStoreByBUSAPCardCode() {
            $BUSAPCardCode = $this->validateParameter('BUSAPCardCode', $this->param['BUSAPCardCode'], STRING);
            
            $Store = new clsStore;
            $Store->setBUCode($BUSAPCardCode);
            $data = $Store->getStoreByBUSAPCardCode();
            if(!$data) {
                $this->returnResponse(HTTP_NO_CONTENT, array('message' => 'No Content found.'));
            }
            
            $this->returnResponse(HTTP_OK, $data);
        }

        /* 
            10.1.1.11 - Masterlist's CMeal Api
        
        */

        public function getAllCmealUser() {
            $cmeal = new clsCmealUser;
            $data = $cmeal->getAllCmealUser();
            if(!$data) {
                $this->returnResponse(HTTP_NO_CONTENT, array('message' => 'No Content found.'));
            }
            
            $this->returnResponse(HTTP_OK, $data);
        }
        
        




    }

?>