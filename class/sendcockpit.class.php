<?php

/**
 * sendcockpit class
 *
 * @author Marian Steinhorst
 */
class sendcockpit{
    
    protected $client;

    /**
     * @param object $client
     */
    function __construct($client = false){
        if (!is_object($client) && !$client){throw new Exception('no SOAP client given');}
        
        $this->client = $client;
    }

    function sendRequest($service, $parameter = false){
        if (!$parameter){
            $response =  $this->client->{$service}();
        }
        else{
            $response =  $this->client->{$service}($parameter);
        }
        return $response;

    }
}

class SOAPAuth{
    
	public $userid;
	public $apikey;
	public $version;
    public $mode;

    public function __construct($userid, $apikey, $version, $mode = 'test'){
		$this->userid = $userid;
		$this->apikey = $apikey;
		$this->version = $version;
        $this->mode = $mode;
	}
}

?>
