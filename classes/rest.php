<?php
    namespace Classes;

    use Classes\dbConnect as dbConnect;

    require_once(dirname(__DIR__).'/config/constants.php');

    class Rest {

        protected $request;
        protected $serviceName;
        protected $param;
        protected $connection;
        protected $userId;
        protected $ip;

        public function __construct() {
            if($_SERVER['REQUEST_METHOD'] == 'GET'){
                $this->returnResponse(HTTP_NO_CONTENT, 
                array(
                    'message' => 'Welcome to the Waffle Time Group of Comapnies REST API!',
                    'links' => array(
                        'Waffle Time' => 'https://waffletime.com',
                        'Coffeebreak' => 'https://coffeebreak.ph',
                        'Mango Magic' => 'https://mangomagic.ph',
                        'Great Foods Concept INC.' => 'https://www.greatfoodsconcepts.ph/',
                    ),
                    'maintained by' => array(
                        '@crrmacarse' => 'https://twitter.com/pablongbuhaymo',
                    ),
                    'note' => 'This API only accept POST method for inbound requests.'
                ));
            };

            // Check if submitted request method is a post
            if($_SERVER['REQUEST_METHOD'] !== 'POST'){
                $this->throwError(HTTP_METHOD_NOT_ALLOWED, 'Request Method is not valid.');
            };

            // Gets the Ip of client
            $this->ip = filter_input(INPUT_SERVER, 'HTTP_CLIENT_IP', FILTER_VALIDATE_IP)
                ?: filter_input(INPUT_SERVER, 'HTTP_X_FORWARDED_FOR', FILTER_VALIDATE_IP)
                ?: $_SERVER['REMOTE_ADDR'];

            // reads submitted data
            $handler = fopen('php://input', 'r');
            $this->request = stream_get_contents($handler);
            $this->validateRequest();

            // constructs a connection string
            $db = new dbConnect;
            $db->setDidayDatabase("DMSX");
            $this->connection = $db->connectDiday();
   
            // filters generatetoken api request so it could not conflict with validateToken()
            if('generatetoken' != strtolower( $this->serviceName)) { 
                $this->validateToken();
            }
        }

        /*
	        validateRequest: Validates request source credentials
        */

        public function validateRequest() {
            // Check if submitted content-type is a json format. pass parameter must be content-type: application/json
            if($_SERVER['CONTENT_TYPE'] !== 'application/json'){
                $this->throwError(HTTP_NOT_ACCEPTABLE, 'Request content type is not valid. Must be JSON Format only.');
            }

            /*
                There seems to be an error in json_decode as it returns null
                  
                submitted json:
                    {
                        "name":"getStoreById", <= "," the comma triggers the error
                    }

            */

            // converts to json to array
            $data = json_decode($this->request, true);

            // Check if submitted data has name in it
            if(!isset($data['name']) || $data['name'] == ''){
                $this->throwError(HTTP_PRECONDITION_REQUIRED,'API name required.');
            }
            $this->serviceName = $data['name'];

            // Check if submitted data has param in it
            if(!isset($data['param']) || !is_array($data['param'])){
                $this->throwError(HTTP_PRECONDITION_REQUIRED, 'API PARAM is required.');
            }

            /* 
                02/21/19 -- pota daw sa postman ang problema kay gna submit nya isa lang guro

                Throws an error if found to have a duplicate key. 
                
                note: $data['param'] + 1: BECAUSE ARRAY STARTS AT 0 and the other param returns number value
           
           
                test:

                    die(json_encode(count($data['param])));
                    die(json_encode(count(array_unique($keys)))); 
                    die(json_encode(count(array_keys($this->param))));            
            */

            $arrKeys = array_keys($data['param']);
            if(count($data['param']) !== count(array_unique($arrKeys))) {
                $this->throwError(HTTP_BAD_REQUEST, 'There seems to be a duplicate key on the parameters.');           
            }

            $this->param = $data['param'];        
        }
        
        /*
	        processApi: Accepts and validates dynamic api request
        */

        public function processApi() {
            try {
                // creates an instance of API class
                $api = new \Classes\Api;
                /*
                    allows to call a class method 'dynamically'. notice how we grab serviceName(trace for reference)
                */
                $rMethod = new \reflectionMethod('\Classes\API', $this->serviceName);
                // checks if the method $this->serviceName exists in API class
                if(!method_exists($api, $this->serviceName)) {
                    $this->throwError(HTTP_NOT_IMPLEMENTED, 'API method does not exist.');
                }
                // invoke allows rMethod to accetpt the object of the API class
                $rMethod->invoke($api);
            } catch (\Exception $e) {
                $this->throwError(HTTP_NOT_IMPLEMENTED, 'API does not exist');
            }
        }

        /*
	        validateParameter: Validates the paramater by Data Type and required check
        */
        
        public function validateParameter($fieldName, $value, $dataType, $required = true) {
            // validates if it is required
            if($required == true && empty($value) == true) {
                $this->throwError(HTTP_EXPECTATION_FAILED, $fieldName . ' parameter is required.');
            }

            // validates if value's datatype is correct; capslock BOOLEAN, INTEGER, STRING are from constants.php;
            switch ($dataType) {
                case BOOLEAN:
                    if(!is_bool($value)) {
                        $this->throwError(HTTP_BAD_REQUEST, "Datatype is not valid for $fieldName. It should be boolean");
                    }
                    break;
                case INTEGER:
                    if(!is_numeric($value)) {
                        $this->throwError(HTTP_BAD_REQUEST, "Datatype is not valid for $fieldName. It should be numeric.");
                    }
                    break;
                case STRING:
                    if(!is_string($value)) {
                        $this->throwError(HTTP_BAD_REQUEST, "Datatype is not valid for $fieldName. It should be a string.");
                    }
                    break;
                default:
                    $this->throwError(HTTP_BAD_REQUEST, "Datatype is not valid for $fieldName.");
                    break;
            }

            return $value;
        }

        /*
	        throwError: Return error in json format
        */

        public function throwError($code, $message) {
            // defines the response to be a json format(important for requesting json only response)
            // header('content-type: application/json');
            // converts error message to json
            $errMsg = json_encode(array('error'=> array("status" => $code, "message" => $message)));
            die($errMsg);
            
        }

        /*
	        returnResponse: Return response in json format
        */

        public function returnResponse($code, $data) {
            // defines the response to be a json format(refer at $this->throwError())        
            // header('content-type: application/json');
            // converts error response to json
            $response = json_encode(array('response' => array("status" => $code, "result" => $data)));
            die($response);   
        }

        /*
	        getAthorization: Get hearder Authorization
        */

        public function getAuthorizationHeader() {
            $headers = null;
            if(isset($_SERVER['Authorization'])) {
                $headers = trim($_SERVER["Authorization"]);
            }
            // for Nginx or fast CGI
            else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { 
                $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
            } 
            // Catch statement
            elseif(function_exists('apache_request_headers')) {
	            $requestHeaders = apache_request_headers();
	            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
	            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
	            if (isset($requestHeaders['Authorization'])) {
	                $headers = trim($requestHeaders['Authorization']);
	            }
	        }

            return $headers;
        }

        /*
	        getBearerToken: Get the access token from header
	    */
	    public function getBearerToken() {
	        $headers = $this->getAuthorizationHeader();
	        // HEADER: Get the access token from the header
	        if (!empty($headers)) {
	            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
	                return $matches[1];
	            }
	        }
	        $this->throwError(HTTP_NOT_FOUND, 'Access Token Not found.');
        }
        
        /*
	        validateToken: validates token every iteration of this class(except generatetoken request api call)
	    */
        public function validateToken() {
            try {
                // gets token and decode with JWT::decode translates to jwt.php then decode function
                $token = $this->getBearerToken();
                $payload = JWT::decode($token, JWT_SECRET_KEY, array('HS256'));
                
                // PDO query to check for user
                $sql = "SELECT * FROM AccountUser WHERE idAccountUser = '$payload->userId'";
                $result = odbc_exec($this->connection, $sql);   
                $user = odbc_fetch_array($result);

                if(!$user) {
                    $this->writeLoginAttempt($username);
                    
                    $this->returnResponse(HTTP_NOT_FOUND, 'No user found');
                }
                
                if( $user['Status'] == 0) {
                    $this->returnResponse(HTTP_NOT_ACCEPTABLE, 'User is not activated. Please contact the administrator.');
                }

                // assigns userId for future use
                $this->userId = $payload->userId;
            } catch (\Exception $e) {
                $this->throwError(HTTP_UNPROCESSABLE_ENTITY, $e->getMessage());
            }
        }

        public function checkLoginAttempt($userId) {
            $mysqlconn = new dbConnect;
            $mysqlconn->setLampugakDatabase("wtgocapi");

            $conn = $mysqlconn->connectLampugak(); 
            try {

                $stmt = $conn->prepare("SELECT COUNT(*) AS total
                
                FROM UserSession
                
                WHERE USERID = :uid 
                AND INET_NTOA(IPADDRESS) = :ip 
                AND DESCRIPT = 'A Login attempt has been made'
                AND DATEATTEMPT > (NOW() - INTERVAL 24 HOUR)");
                $stmt->bindParam('uid', $userId);
                $stmt->bindParam('ip', $this->ip);
                $stmt->execute();
                $result = $stmt->fetch(\PDO::FETCH_ASSOC);

                if($result["total"] >= 5) {
                    $this->throwError(HTTP_BAD_REQUEST, "You've exceeded the maximum log-in attempt for today. Sorry for the inconvenience (This module was implemented for security reasons).");
                }

            } catch (\Exception $e){
                $this->throwError(HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
            }

         }

        public function writeLoginAttempt($userId) {
            $mysqlconn = new dbConnect;
            $mysqlconn->setLampugakDatabase("wtgocapi");

            $conn = $mysqlconn->connectLampugak(); 

            try {
                $stmt = $conn->prepare("INSERT INTO UserSession(USERID, IPADDRESS, DESCRIPT, DATEATTEMPT)  
                
                VALUES(:uid, INET_ATON(:ip), 'A Login attempt has been made', now())");               
                $stmt->bindParam(':uid', $userId);
                $stmt->bindParam(':ip', $this->ip);
                $stmt->execute();
                
            } catch (\Exception $e){
               $this->throwError(HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
            }
        }

        public function getIPAddress() {
            return $this->ip;
        }

    }
?> 