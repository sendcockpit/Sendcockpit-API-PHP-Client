<?php

/**
 * subscriber class
 * 
 * @author Marian Steinhorst
 */
class subscriber extends sendcockpit{

    private $subscriber;
    private $subscriberGroupList;
    private $countLimit = 100;

    public function requestSubscriberFromApi($subscriberGroupID){
        $loop = 0;
        $lastRequestCount = $this->countLimit;

        while($this->countLimit == $lastRequestCount){
            $start = $loop * $this->countLimit;
            $loop++;

            $parameter = array('listID' => $subscriberGroupID->listID, 'start'=> $start,'count'=> 100);
            $response = parent::sendRequest('apiGetSubscriber', $parameter);

            $lastRequestCount = count($response->subsriberResponse);

            for($i=0; $i<$lastRequestCount; $i++){
                $this->setSubscriber($response->subsriberResponse[$i]->subscriberID, $response->subsriberResponse[$i]->subscriberEmail);
            }
        }
    }

    /**
     * request getSubscriberGroupList from API
     */
    public function requestListFromApi(){
        $response = parent::sendRequest('apiGetList');
        $this->setSubscriberGroupList($response->listResponse);
    }

    /**
     * getter for subscriber
     * @return array
     */
    public function getSubscriber(){
        return $this->subscriber;
    }

    /**
     * setter for subscriber
     * @param string $subscriberID
     * @param string $subscriberEmail
     */
    private function setSubscriber($subscriberID, $subscriberEmail){
        $this->subscriber[$subscriberID] = $subscriberEmail;
        echo $subscriberEmail."<br>";
        ob_flush();flush;
    }

    /**
     * getter for subscriberGroupList
     * @return array
     */
    public function getSubscriberGroupList(){
        return $this->subscriberGroupList;
    }

    /**
     * setter for subscriberGroupList
     * @param array $subscriberGroupList
     */
    private function setSubscriberGroupList($subscriberGroupList){
        $this->subscriberGroupList = $subscriberGroupList;
    }
}

?>
