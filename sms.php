<?php

/**
 * @author Simaranjit Singh <simaranjit.singh@virdi.me>
 */
class sms
{
    // Plivo AUTH ID
    private $AUTH_ID;
    
    // Plivo AUTH TOKEN
    private $AUTH_TOKEN;
    
    // Plivo contact number
    private $PHONE_NUMBER;
    
    /**
     * @param string $authID
     * @param string $authToken
     * @param string $phoneNumber
     */
    public function __construct($authID, $authToken, $phoneNumber)
    {
        // Configure keys here
        
        $this->AUTH_ID      = $authID;
        $this->AUTH_TOKEN   = $authToken;
        $this->PHONE_NUMBER = $phoneNumber;
    }
    
    /**
     * @param array $params
     *
     * @return string
     */
    private function curl($params)
    {
        $ch = curl_init('https://api.plivo.com/v1/Account/' . $this->AUTH_ID . '/Message/');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($ch, CURLOPT_USERPWD, $this->AUTH_ID . ":" . $this->AUTH_TOKEN);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));
        $response = curl_exec($ch);
        curl_close($ch);
        
        return $response;
    }
    
    /**
     * @param string $destination
     * @param string $text
     *
     * @return array
     *
     * @throws Exception
     */
    public function send($destination, $text)
    {
        if (trim($destination) == '') {
            throw new Exception('EMPTY_DESTINATION_NUMBER');
        } else if (trim($text) == '') {
            throw new Exception('EMPTY_MESSAGE_CONTENT');
        }
        
        $params = array(
            "src" => $this->PHONE_NUMBER,
            "dst" => $destination,
            "text" => $text
        );
        
        return json_decode($this->curl($params), true);
    }
}
