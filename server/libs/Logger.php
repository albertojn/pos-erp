<?php

class Logger
{

  private static $db_querys = 0;

  public static final function read($lines = 100)
  {

        if(!file_exists(POS_CONFIG_LOG_ACCESS_FILE)){
            die("POS: Unable to open logfile:" .POS_CONFIG_LOG_ACCESS_FILE );
        }

    // $file: Name of file to open
    // $lines: Number of lines to obtain from the end of the file
    // $header: flag to indicate that the file contains a header which should not be included if the number of lines in the file is <= lines
    
    $file = POS_CONFIG_LOG_ACCESS_FILE;
     $header = null;
    global $error_string;
    
    // Number of lines read per time
    $bufferlength = 1024;
    $aliq = "";
    $line_arr = array();
    $tmp = array();
    $tmp2 = array();
    
    if (!($handle = fopen($file , "r"))) {
        echo("Could not fopen $file");
    }

    if (!$handle) {
        echo("Bad file handle");
        return 0;
    }

    // Get size of file
    fseek($handle, 0, SEEK_END);
    $filesize = ftell($handle);

    $position= - min($bufferlength,$filesize);

    while ($lines > 0) {
        if (fseek($handle, $position, SEEK_END)) {
            echo("Could not fseek");
            return 0;
        }
        
        unset($buffer);
        $buffer = "";
        // Read some data starting fromt he end of the file
        if (!($buffer = fread($handle, $bufferlength))) {
            echo("Could not fread");
            return 0;
        }
        
        // Split by line
        $cnt = (count($tmp) - 1);
        for ($i = 0; $i < count($tmp); $i++ ) {
            unset($tmp[0]);
        }
        unset($tmp);
        $tmp = explode("\n", $buffer);
        
        // Handle case of partial previous line read
        if ($aliq != "") {
            $tmp[count($tmp) - 1] .= $aliq;
        }

        unset($aliq);
        // Take out the first line which may be partial
        $aliq = array_shift($tmp);
        $read = count($tmp);
        
        // Read too much (exceeded indicated lines to read)
        if ($read >= $lines) {
            // Slice off the lines we need and merge with current results
            unset($tmp2);
            $tmp2 = array_slice($tmp, $read - $lines);
            $line_arr = array_merge($tmp2, $line_arr);
            
            // Discard the header line if it is there
            if ($header &&
                (count($line_arr) <= $lines)) {
                array_shift($line_arr);
            }

            // Break the loop
            $lines = 0;
        }
        // Reached start of file
        elseif (-$position >= $filesize) {
            // Get back $aliq which contains the very first line of the file
            unset($tmp2);
            $tmp2[0] = $aliq;
            
            $line_arr = array_merge($tmp2, $tmp, $line_arr);
            
            // Discard the header line if it is there
            if ($header &&
                (count($line_arr) <= $lines)) {
                array_shift($line_arr);
            }

            // Break the loop
            $lines = 0;
        }
        // Continue reading
        else {
            // Add the freshly grabbed lines on top of the others
            $line_arr = array_merge($tmp, $line_arr);
            $lines -= $read;

            // No longer a full buffer's worth of data to read
            if ($position - $bufferlength < -$filesize) {
                $bufferlength = $filesize + $position;
                $position = -$filesize;                    
            }
            // Still >= $bufferlength worth of data to read
            else {
                $position -= $bufferlength;
            }
        }
    }
    
    fclose($handle);

    return $line_arr;
    
  }
  
  
  
  public static final function logSQL( $sql )
  {
    
    if(POS_CONFIG_LOG_DB_QUERYS){
      self::$db_querys ++;
      self::log( "SQL(" . self::$db_querys . "): " . $sql );
      
    }
  }


  public static final function error ($msg )
  {
    self::log(  "ERROR:" . $msg );
  }

  public static final function warn ($msg )
  {
    self::log(  "WARN:" . $msg );
  }


  public static final function debug ($msg )
  {
    self::log(  "		-->DEBUG:" . $msg );
  }

  public static final function log( $msg, $level = 0 )
  {
        if(!POS_CONFIG_LOG_TO_FILE)
            return;
        
        if(!file_exists(POS_CONFIG_LOG_ACCESS_FILE)){
            //die("POS: Unable to open logfile:" .POS_CONFIG_LOG_ACCESS_FILE );
			return;
        }

        if(!is_writable(POS_CONFIG_LOG_ACCESS_FILE)){
            //die("POS: Unable to write to logfile:" .POS_CONFIG_LOG_ACCESS_FILE );
			return;
        }


        $log = fopen( POS_CONFIG_LOG_ACCESS_FILE, "a" );

        $out = date("g:i:sa j M");

		if(isset($_SERVER["REMOTE_ADDR"])){
        	$out .= " | " . $_SERVER["REMOTE_ADDR"];

		}else{
	        $out .= " | CLI"  ;

		}


        
        if(isset($_SESSION["INSTANCE_ID"])){
            $out .= " | INSTANCE:" . $_SESSION["INSTANCE_ID"];
        }


        if(isset($_SESSION['userid'])){
            $out .= " | USERID:" . $_SESSION['userid'];
        }

    	/*
        if(isset($_SESSION['sucursal']) 
	      && method_exists($_SESSION['sucursal'], '__toString') //bug #121
	    ){
	      try{
	              $out .= " | SUC:" . $_SESSION['sucursal'];
	      }catch(Exception $e){
	        return Logger::log($e);
	      }

        }*/

    if(POS_CONFIG_LOG_TRACKBACK){
          $d = debug_backtrace();
      $track = " | TRACK : ";
      for ($i= 1; $i < sizeof($d) -1 ; $i++) { 
//        $track .= isset($d[$i]["function"]) ? "->" . $d[$i]["function"] : "*" ;
        $track .= isset($d[$i]["file"]) ? substr( strrchr( $d[$i]["file"], "/" ), 1 )  : "*"; 
        $track .= isset($d[$i]["line"]) ? ":" .  $d[$i]["line"] ." "  : "* " ;
      }
      $out .=  $track ;      
    }

        
        

        fwrite($log, $out. " | " . $msg . "\n");

        fclose($log);

  }
  
  
  
  
  
}
