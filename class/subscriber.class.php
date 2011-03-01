<?php

/**
 * subscriber class
 * @author Marian Steinhorst
 */
class subscriber extends sendcockpit{

    private $subscriber;
    private $list;
    private $subscriberCustomFields;
    private $subscriberHistory;

    private $countLimit = 100;
    private $countLoops = 1;

    public function apiGetSubscriber($listID){
        $loop = 0;
        $lastRequestCount = $this->countLimit;

        while($this->countLimit == $lastRequestCount && $loop <= $this->countLoops){
            $start = $loop * $this->countLimit;
            $loop++;

            $parameter = array('listID' => $listID, 'start'=> $start,'count'=> 100);
            $response = parent::sendRequest('apiGetSubscriber', $parameter);

            $lastRequestCount = count($response->subsriberResponse);

            for($i=0; $i<$lastRequestCount; $i++){
                $this->setSubscriber($response->subsriberResponse[$i]);
            }
        }
    }

    public function apiGetSubscriberUnsubscribes($listID){
        $loop = 0;
        $lastRequestCount = $this->countLimit;

        while($this->countLimit == $lastRequestCount && $loop <= $this->countLoops){
            $start = $loop * $this->countLimit;
            $loop++;

            $parameter = array('listID' => $listID, 'start'=> $start,'count'=> 100);
            $response = parent::sendRequest('apiGetSubscriberUnsubscribes', $parameter);

            $lastRequestCount = count($response->subsriberResponse);

            for($i=0; $i<$lastRequestCount; $i++){
                $this->setSubscriber($response->subsriberResponse[$i]);
            }
        }
    }

    public function apiGetSubscriberDetails($listID){
        $loop = 0;
        $lastRequestCount = $this->countLimit;

        while($this->countLimit == $lastRequestCount && $loop <= $this->countLoops){
            $start = $loop * $this->countLimit;
            $loop++;

            $parameter = array('listID' => $listID, 'start'=> $start,'count'=> 100);
            $response = parent::sendRequest('apiGetSubscriberDetails', $parameter);

            $lastRequestCount = count($response->subsriberDetailsResponse);

            for($i=0; $i<$lastRequestCount; $i++){

                $detailsCount = count($response->subsriberDetailsResponse[$i]->customFields);

                $tmpCustomField = array();
                for($j=0; $j<$detailsCount; $j++){
                    $tmpCustomField[$response->subsriberDetailsResponse[$i]->customFields[$j]->customFieldID] = utf8_decode($response->subsriberDetailsResponse[$i]->customFields[$j]->customFieldValue);
                }

                $response->subsriberDetailsResponse[$i]->customFields = $tmpCustomField;
                $this->setSubscriber($response->subsriberDetailsResponse[$i]);
            }
        }
    }

    /**
     * request getSubscriberGroupList from API
     */
    public function apiGetList(){
        $response = parent::sendRequest('apiGetList');
        $this->setList($response->listResponse);
    }

    /**
     * request getSubscriberHistory from API
     */
    public function apiGetSubscriberHistory($subscriberID){
        $parameter = array('subscriberID' => $subscriberID);
        $response = parent::sendRequest('apiGetSubscriberHistory',$parameter);
        $this->setSubscriberHistory($response->subsriberHistoryResponse);
    }

    /**
     * request getSubscriberGroupList from API
     */
    public function apiGetSubscriberFields(){
        $response = parent::sendRequest('apiGetSubscriberFields');

        $lastRequestCount = count($response->responseSubsriberCustomFields);

        for($i=0; $i<$lastRequestCount; $i++){
            $this->setSubscriberCustomFields($response->responseSubsriberCustomFields[$i]);
        }

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
    private function setSubscriber($subscriber){
        $this->subscriber[$subscriber->subscriberID] = $subscriber;
    }

    /**
     * getter for subscriberGroupList
     * @return array
     */
    public function getList(){
        return $this->list;
    }

    /**
     * setter for subscriberGroupList
     * @param array $subscriberGroupList
     */
    private function setList($list){
        $this->list = $list;
    }

    /**
     * getter for subscriberCustomFields
     * @return array
     */
    public function getSubscriberCustomFields(){
        return $this->subscriberCustomFields;
    }

    /**
     * setter for subscriberCustomFields
     * @param array $subscriberCustomFields
     */
    private function setSubscriberCustomFields($subscriberCustomFields){
        $this->subscriberCustomFields[$subscriberCustomFields->customFieldID] = $subscriberCustomFields->customFieldName;
    }

    /**
     * getter for subscriberHistory
     * @return array subscriberHistory
     */
    public function getSubscriberHistory(){
        return $this->subscriberHistory;
    }

    /**
     * setter for subscriberHistory
     * @param array subscriberHistory
     */
    private function setSubscriberHistory($subscriberHistory){
        $this->subscriberHistory = $subscriberHistory;
    }
}

?>
