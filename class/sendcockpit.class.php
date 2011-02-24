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
        if ($response->status == 200){
            return $response;
        }

    }
}

?>
