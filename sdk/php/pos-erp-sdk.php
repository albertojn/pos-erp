<?php

if (!function_exists('curl_init')) {
  throw new Exception('SDK needs the CURL PHP extension.');
}

if (!function_exists('json_decode')) {
  throw new Exception('SDK needs the JSON PHP extension.');
}


Class PosErp{
    private static $singleton_obj;
    private $waiting;
    private $instance_token;
    private $url;
    private $incoming_login_results;
    private $auth_token;

  /**
   *
   *  Default options for curl.
   *
   *
   */
	public static $CURL_OPTS = array(
			CURLOPT_CONNECTTIMEOUT => 10,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_TIMEOUT        => 60,
			CURLOPT_USERAGENT      => 'caffeina-sdk-php-0.2',
		);


    private function __construct($i_token){
        $this->waiting = false;
        $this->instance_token = $i_token;
		$this->url = "http://pos-nightly.labs2.caffeina.mx/pos/";

	$this->incoming_login_results = false;
        $this->auth_token = null;
    }

    function __clone(){
    }

    function __destroy(){
    }

    public static function getInstance( $i_token = null ){
        if(self::$singleton_obj === null){
            if($i_token === null){
                throw new Exception("You must pass your instance token when calling getInstance() for the first time.");
            }
            self::$singleton_obj = new PosErp($i_token);
        }
        return self::$singleton_obj;
    }

    private function BeforeCall( $api_name, $toSendParams ){
        if ($api_name == "api/sesion/iniciar") {
            $this->incoming_login_results = true;

		} elseif (!is_null($this->auth_token)) {

            //there is an `at` associated with this session
            //lets check if there is at defined in the params
            if(array_key_exists("auth_token", $toSendParams)){
                //he has his own at, send that one
				$toSendParams["at"] = $toSendParams["auth_token"];
            }else{
                //lets use the one we have
                $toSendParams["at"] = $this->auth_token; 
            }
        } else {
			throw new Exception("You are not logged in.");

		}
        return $toSendParams;
    }

	private function AfterCall( $result ){
		//decode json
		$response = json_decode($result);

		//login sucessful reponse may be missing if not all of the
		//params were sent
		if($this->incoming_login_results && isset($response->login_succesful)){
			if(!is_null($response) && $response->login_succesful){
				$this->auth_token = $response->auth_token;
			}
		}

		$this->incoming_login_results = false;
		return $response;
    }

	private function req($method, $url, $params, $ch = null){
		if(!$ch){
			$ch = curl_init();
		}

		$opts = self::$CURL_OPTS;
		$opts[CURLOPT_URL] = $url;

		if ($method == "POST") {
			$opts[CURLOPT_POST] = 1;
			$opts[CURLOPT_POSTFIELDS] = http_build_query($params, null, '&');
		} else {
			$opts[CURLOPT_HTTPGET] = true;
			$opts[CURLOPT_URL] = $url . "?" . http_build_query($params, null, '&');
		}

		// disable the 'Expect: 100-continue' behaviour. This causes CURL to wait
		// for 2 seconds if the server does not support this header.
		if (isset($opts[CURLOPT_HTTPHEADER])) {
			$existing_headers = $opts[CURLOPT_HTTPHEADER];
			$existing_headers[] = 'Expect:';
			$opts[CURLOPT_HTTPHEADER] = $existing_headers;
		} else {
			$opts[CURLOPT_HTTPHEADER] = array('Expect:');
		}

		curl_setopt_array($ch, $opts);
		$result = curl_exec($ch);

		return $result;
	}

	private function ApiCall($method, $address, $params ){
		if (is_null($params)) {
			$params = array();
		}

		$params = $this->BeforeCall($address, $params );

		if(is_null($this->instance_token)){
			throw new Exception("You have not supplied any instance token", 1);
		}

		$r = $this->req($method, $this->url .  $this->instance_token . "/" . $address, $params);
		return $this->AfterCall( $r );
    }

    public function POST($api_name, $parameters){
        return $this->ApiCall( "POST", $api_name, $parameters );
    }

    public function GET($api_name, $parameters = null){
        return $this->ApiCall( "GET", $api_name, $parameters );
    }
}



/*

   Example

$api = PosErp::getInstance("1e65da5dbe04139ee8d810568f1fd406");

$api->POST("api/sesion/iniciar", array( 
        'password' => '123',
        'usuario' => '1'
     ));

$api->POST("api/cliente/nuevo", array( 
        'razon_social' => 'Laura Gonzalez'
     ));

*/

