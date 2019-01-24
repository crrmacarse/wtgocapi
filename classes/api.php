<?php

    class Api extends Rest {

        public function __construct() {
            // triggers parent class(extended class)
            parent::__construct();
        }

        public function generateToken() {
            $username = $this->validateParameter('username', $this->param['username'], STRING);
            $password = encryptPassword($this->validateParameter('password', $this->param['password'], STRING));
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

                // Check if database has a response from user log-in
                if(!$user) {
                    $this->returnResponse(HTTP_BAD_REQUEST, 'Email or Password is incorrect.');
                }

                // Check if user status is still active
                if( $user['Status'] == 0) {
                    $this->returnResponse(HTTP_NOT_ACCEPTABLE, 'User is not activated. Please contact the administrator');
                }

                // creates a standard jwt payload
                $payload = 
                    array(
                     'iat' => time(),
                     'iss' => 'localhost',
                     'exp' => time() + (5*60),
                     'userId' => $user['idAccountUser']
                  )
                ;

                // calls jwt.php encode function
                $token = JWT::encode(json_encode($payload), JWT_SECRET_KEY);
                // success response 
                $data = array('token' => $token);
                $this->returnResponse(HTTP_OK, $data);
            } catch (Exception $e) {
                $this->throwError(HTTP_UNPROCESSABLE_ENTITY, $e->getMessage());
            }

        }

        public function getAllHousehold() { 
            $household = new clsHousehold;
            $data = $household->getAllHousehold();
            if(!$data) { 
                $this->returnResponse(HTTP_NO_CONTENT, array('message' => 'No Content found.'));
            }

            $this->returnResponse(HTTP_OK, $data);
        }

        public function getHouseholdById() {
            $idHousehold = $this->validateParameter('idHousehold', $this->param['idHousehold'], INTEGER);
            
            $household = new clsHousehold;
            $household->setIdHousehold($idHousehold);
            $data = $household->getHouseholdById();
            if(!$data) {
                $this->returnResponse(HTTP_NO_CONTENT, array('message' => 'No Content found.'));
            }
            
            $this->returnResponse(HTTP_OK, $data);
        }
    }

?>