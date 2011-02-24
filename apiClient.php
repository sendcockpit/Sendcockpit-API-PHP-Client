<?php

ini_set('max_execution_time', '300');

require '/class/sendcockpit.class.php';
require '/class/subscriber.class.php';

$client = new SoapClient("http://api.sendcockpit.com/server.php?wsdl");

class SOAPAuth{
	public $userid;
	public $apikey;
	public $version;

	public function __construct($userid, $apikey, $version, $mode = 'test'){
		$this->userid = $userid;
		$this->apikey = $apikey;
		$this->version = $version;
        $this->mode = $mode;
	}
}

$auth = new SOAPAuth('UserID','APIKey','1.0','live');
$header = new SOAPHeader('sendcockpit', 'validate', $auth);

$client->__setSoapHeaders($header);

try{
    $subscriber = new subscriber($client);

    $subscriber->requestListFromApi();
    $subscriberGroupsList = $subscriber->getSubscriberGroupList();

    $subscriber->requestSubscriberFromApi($subscriberGroupsList[0]);
}
catch (SoapFault $exception) {
	echo ($exception->getMessage());
}
catch (exception $exception){
    echo ($exception->getMessage());
}

?>