<?php

/*
 *  Singleton that abstracts HTTP errors
 * 
 */

class ApiHttpErrors
{
    private static $instance;    
    
    // Hide constructor from public
    private function __construct()
    {
        
    }

    public function __clone()
    {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }
    
    public function __wakeup() 
    { 
        trigger_error("Wakeup is not allowed.", E_USER_ERROR); 
    } 
    
    
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
                        
            self::$instance = new self;
        }
        return self::$instance;
    }
    
    // Sets the HTTP header and returns an array with error info
    public function invalidAuthToken($message = NULL)
    {
        // We have an invalid auth token. Dying.
        header('HTTP/1.1 401 FORBIDDEN');
        header('Content-Type: application/json');
        
        if ($message === NULL)
        {
            $message = "You supplied an invalid auth token, or maybe it expired.";
        }
        
        return array("status" => "error",
                     "error"	 => $message,
                     "errorcode" => 500 );
    }

    // Sets the HTTP header and returns an array with error info
    public function invalidParameter($message = NULL)
    {
        // We have an invalid auth token. Dying.
        header('HTTP/1.1 400 BAD REQUEST');
        header('Content-Type: application/json');

        if ($message === NULL)
        {
            $message = "You supplied an invalid value for a parameter.";
        }
        
        return array("status" => "error",
                     "error"	 => $message,
                     "errorcode" => 100 );
    }
    
    // Sets the HTTP header and returns an array with error info
    public function invalidFilesystemOperation($message = NULL)
    {
        // We have an invalid auth token. Dying.
        header('HTTP/1.1 500 INTERNAL SERVER ERROR');
        header('Content-Type: application/json');

        if ($message === NULL)
        {
            $message = "Whops. Ive encoutered an unspecified error. Please try again";
        }
        
        return array("status" => "error",
                     "error"	 => $message,
                     "errorcode" => 104 );
    }    
    
    // Sets the HTTP header and returns an array with error info
    public function invalidDatabaseOperation($message = NULL)
    {
        // We have an invalid auth token. Dying.
        header('HTTP/1.1 500 INTERNAL SERVER ERROR');
        header('Content-Type: application/json');

        if ($message === NULL)
        {
            $message = "Whops. Ive encoutered an internal error error Please try again.";
        }
        
        return array("status" => "error",
                     "error"	 => $message,
                     "errorcode" => 105 );
    } 
    
    // Sets the HTTP header and returns an array with error info
    public function invalidCredentials($message = NULL)
    {
        // We have an invalid auth token. Dying.
        header('HTTP/1.1 403 FORBIDDEN');
        header('Content-Type: application/json');

        if ($message === NULL)
        {
            $message = "Username or password is wrong. Please check your credentials";
        }
        
        return array("status" => "error",
                     "error"	 => $message,
                     "errorcode" => 101 );
    }
    
    // Sets the HTTP header and returns an array with error info
    public function registeredViaThirdPartyNotSupported($message = NULL)
    {
        // We have an invalid auth token. Dying.
        header('HTTP/1.1 400 BAD REQUEST');
        header('Content-Type: application/json');

        if ($message === NULL)
        {
            $message = "It seems you have registered via a third party (Google, Facebook, etc). To use this API you must first create an omegaup.com password.";
        }
        
        return array("status" => "error",
                     "error"	 => $message,
                     "errorcode" => 102 );
    }
    
    
    
    
}

?>