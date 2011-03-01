<?php

/**
 * PHP5 testclient for sendcockpit api
 *
 * @author Marian Steinhorst
 * @tutorial http://de.supportcockpit.com/index.php/API
 */
ini_set('max_execution_time', '300');

require '/class/sendcockpit.class.php';
require '/class/subscriber.class.php';
require '/class/libs/Smarty.class.php';

$smarty = new Smarty;

define('DOCUMENT_ROOT',$_SERVER['DOCUMENT_ROOT'] . '/github/PHP5/');

$smarty->template_dir = DOCUMENT_ROOT . 'view/templates/';
$smarty->compile_dir  = DOCUMENT_ROOT . 'view/templates_c/';
$smarty->config_dir   = DOCUMENT_ROOT . 'view/configs/';
$smarty->cache_dir    = DOCUMENT_ROOT . 'view/cache/';

$client = new SoapClient("http://api.sendcockpit.com/server.php?wsdl");
$auth = new SOAPAuth($_GET['userID'],$_GET['apiKey'],'1.0','live');
$header = new SOAPHeader('sendcockpit', 'validate', $auth);
$client->__setSoapHeaders($header);

try{
    if ($_GET['action'] == 'request'){
        $subscriber = new subscriber($client);

        switch ($_GET['apiService']){
            case 'apiGetList':
                // call's apiGetList service from api
                $subscriber->apiGetList();
                $smarty->assign('list', $subscriber->getList());
                $serviceTemplate = $smarty->fetch('list.html');
                break;
            case 'apiGetSubscriber':
                // call's apiGetSubscriber service with single list id from api
                $subscriber->apiGetSubscriber($_GET['listID']);
                $smarty->assign('subscriber', $subscriber->getSubscriber());
                $serviceTemplate = $smarty->fetch('subscriber.html');
                break;
            case 'apiGetSubscriber':
                // call's apiGetSubscriber service with single list id from api
                $subscriber->apiGetSubscriberUnsubscribes($_GET['listID']);
                $smarty->assign('subscriber', $subscriber->getSubscriber());
                $serviceTemplate = $smarty->fetch('subscriber.html');
                break;
            case 'apiGetSubscriberDetails':
                // call's apiGetSubscriberFields and apiGetSubscriber service with single list id from api
                $subscriber->apiGetSubscriberFields();
                $subscriber->apiGetSubscriberDetails($_GET['listID']);

                $smarty->assign('subscriber', $subscriber->getSubscriber());
                $smarty->assign('subscriberCustomFields', $subscriber->getSubscriberCustomFields());

                $serviceTemplate = $smarty->fetch('subscriberDetails.html');
                break;
            case 'apiGetSubscriberHistory':
                $subscriber->apiGetSubscriberHistory($_GET['subscriberID']);
                $smarty->assign('subscriberHistory', $subscriber->getSubscriberHistory());
                $serviceTemplate = $smarty->fetch('subscriberHistory.html');
                break;
        }
    }
    $smarty->assign('serviceTemplate',$serviceTemplate);
    $smarty->display('index.html');
}
catch (SoapFault $exception) {
	echo ($exception->getMessage());
}
catch (exception $exception){
    echo ($exception->getMessage());
}

?>